<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        return view('customer.dashboard');
    }

    /**
     * Handle manual deposit request.
     */
    public function deposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gateway_id' => 'required|integer',
            'amount' => 'required|numeric|min:10',
            'sender_number' => 'required|string|min:10|max:20',
            'transaction_id' => 'required|string|min:6|max:50',
            'screenshot' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $gateway = PaymentGateway::find($request->gateway_id);
        if (!$gateway || $gateway->status !== 'active') {
            return response()->json([
                'success' => false,
                'errors' => ['Selected payment gateway is invalid or inactive.']
            ], 422);
        }

        // Duplicate TxID Check:
        $txid = trim($request->transaction_id);
        $duplicate = Transaction::where('type', 'Deposit')
            ->whereIn('status', ['Pending', 'Completed'])
            ->where(function ($query) use ($txid) {
                $query->where('metadata->transaction_id', $txid)
                      ->orWhere('metadata->transaction_id', strtolower($txid))
                      ->orWhere('metadata->transaction_id', strtoupper($txid));
            })
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'errors' => ['This Transaction ID has already been submitted or completed.']
            ], 422);
        }

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $fileName = 'screenshot_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $dir = public_path('uploads/screenshots');
            if (!file_exists($dir)) {
                @mkdir($dir, 0755, true);
            }
            
            $file->move($dir, $fileName);
            $screenshotPath = '/uploads/screenshots/' . $fileName;
        }

        $amount = (float)$request->amount;
        $user = Auth::user();

        // Create transaction with status 'Pending'
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'Deposit',
            'gateway' => $gateway->name,
            'amount' => $amount,
            'status' => 'Pending',
            'metadata' => [
                'gateway_id' => $gateway->id,
                'sender_number' => $request->sender_number,
                'transaction_id' => $txid,
                'screenshot' => $screenshotPath,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your deposit request has been submitted successfully and is pending admin approval.',
            'balance' => number_format($user->balance, 2, '.', '')
        ]);
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'gateway_id' => 'required|integer',
            'amount' => 'required|numeric|min:50|max:' . $user->balance,
            'account_number' => 'required|string|min:10|max:40',
            'note' => 'nullable|string|max:255',
        ], [
            'amount.max' => 'Insufficient wallet balance for this withdrawal.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $gateway = PaymentGateway::find($request->gateway_id);
        if (!$gateway) {
            return response()->json([
                'success' => false,
                'errors' => ['Selected payment gateway is invalid.']
            ], 422);
        }

        $amount = (float)$request->amount;
        
        // Calculate withdraw commission fee only if active
        $withdrawCommStatus = Setting::getVal('withdraw_commission_status', 'active');
        if ($withdrawCommStatus === 'active') {
            $withdrawCommPct = (float)Setting::getVal('withdraw_commission', '5');
            $fee = round($amount * ($withdrawCommPct / 100), 2);
        } else {
            $fee = 0.00;
        }
        $net = $amount - $fee;

        // Note: As requested, do NOT deduct customer balance immediately. 
        // Deduction happens ONLY upon admin approval.

        // Record withdraw transaction in Pending state
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'Withdraw',
            'gateway' => $gateway->name,
            'amount' => $amount,
            'fee' => $fee,
            'status' => 'Pending',
            'metadata' => [
                'account_number' => $request->account_number,
                'note' => $request->note,
                'net_payable' => $net,
                'gateway_id' => $gateway->id
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal request submitted! Net: ' . number_format($net, 2) . ' ' . $user->currency . ' (Fee: ' . number_format($fee, 2) . ' ' . $user->currency . ') is pending admin approval.',
            'balance' => number_format($user->balance, 2, '.', '')
        ]);
    }

    /**
     * Handle peer-to-peer amount transfer.
     */
    public function transfer(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'recipient' => 'required|string',
            'amount' => 'required|numeric|min:10|max:' . $user->balance,
            'password' => 'required|string',
        ], [
            'amount.max' => 'Insufficient balance for transfer.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Verify sender password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['Incorrect password. Transfer verification failed.']
            ], 422);
        }

        $recipientIdentifier = $request->recipient;

        // Check if recipient is current user (self-transfer check)
        if ($recipientIdentifier === $user->email || $recipientIdentifier === $user->mobile) {
            return response()->json([
                'success' => false,
                'errors' => ['You cannot transfer funds to yourself.']
            ], 422);
        }

        // Find recipient user
        $recipient = User::where('email', $recipientIdentifier)
                         ->orWhere('mobile', $recipientIdentifier)
                         ->first();

        if (!$recipient) {
            return response()->json([
                'success' => false,
                'errors' => ['Recipient not found. Please verify the Email or Mobile number.']
            ], 422);
        }

        $amount = (float)$request->amount;

        // Perform balance shift
        $user->balance -= $amount;
        $user->save();

        $recipient->balance += $amount;
        $recipient->save();

        // Record DB transactions
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'Transfer Out',
            'gateway' => $recipient->email ?: $recipient->mobile,
            'amount' => $amount,
            'status' => 'Completed'
        ]);

        Transaction::create([
            'user_id' => $recipient->id,
            'type' => 'Transfer In',
            'gateway' => $user->email ?: $user->mobile,
            'amount' => $amount,
            'status' => 'Completed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully transferred ' . number_format($amount, 2) . ' ' . $user->currency . ' to ' . $recipient->name . '.',
            'balance' => number_format($user->balance, 2, '.', '')
        ]);
    }

    /**
     * Handle profile and password updates.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'country' => 'required|string|max:255',
            'old_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Handle password change if requested
        if ($request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['Your current password does not match.']
                ], 422);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->country = $request->country;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);
    }

    /**
     * Sync in-game balance to database.
     */
    public function updateBalance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'balance' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false], 422);
        }

        $user = Auth::user();
        $user->balance = $request->balance;
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Get user transactions history.
     */
    public function getTransactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return response()->json([
            'success' => true,
            'transactions' => $transactions->map(function($t) {
                return [
                    'datetime' => $t->created_at->format('d M Y, h:i A'),
                    'type' => $t->type,
                    'gateway' => $t->gateway ?: 'System',
                    'amount' => number_format($t->amount, 2, '.', ''),
                    'fee' => number_format($t->fee, 2, '.', ''),
                    'status' => $t->status,
                ];
            })
        ]);
    }

    /**
     * Get user referral tree details up to 3 generations.
     */
    public function getReferrals()
    {
        $userId = Auth::id();

        // Level 1: direct referrals
        $l1 = User::where('referred_by', $userId)->get(['id', 'name', 'email', 'mobile', 'created_at']);
        $l1_ids = $l1->pluck('id')->toArray();

        // Level 2: indirect referrals (referred by L1)
        $l2 = count($l1_ids) ? User::whereIn('referred_by', $l1_ids)->get(['id', 'name', 'email', 'mobile', 'referred_by', 'created_at']) : collect();
        $l2_ids = $l2->pluck('id')->toArray();

        // Level 3: indirect referrals (referred by L2)
        $l3 = count($l2_ids) ? User::whereIn('referred_by', $l2_ids)->get(['id', 'name', 'email', 'mobile', 'referred_by', 'created_at']) : collect();

        // Fetch referral commission transactions for this user
        $commissions = Transaction::where('user_id', $userId)
                                   ->whereIn('type', ['Referral Commission L1', 'Referral Commission L2', 'Referral Commission L3'])
                                   ->get();

        $referralsList = [];

        foreach ($l1 as $u) {
            $earned = $commissions->filter(function($t) use ($u) {
                return $t->type === 'Referral Commission L1' && isset($t->metadata['from_user_id']) && $t->metadata['from_user_id'] == $u->id;
            })->sum('amount');

            $referralsList[] = [
                'name' => $u->name,
                'email' => $u->email,
                'mobile' => $u->mobile ?: '—',
                'level' => 'Level 1 (Direct)',
                'joined_date' => $u->created_at->format('d M Y'),
                'commission' => number_format($earned, 2, '.', '')
            ];
        }

        foreach ($l2 as $u) {
            $earned = $commissions->filter(function($t) use ($u) {
                return $t->type === 'Referral Commission L2' && isset($t->metadata['from_user_id']) && $t->metadata['from_user_id'] == $u->id;
            })->sum('amount');

            $referralsList[] = [
                'name' => $u->name,
                'email' => $u->email,
                'mobile' => $u->mobile ?: '—',
                'level' => 'Level 2 (Gen 2)',
                'joined_date' => $u->created_at->format('d M Y'),
                'commission' => number_format($earned, 2, '.', '')
            ];
        }

        foreach ($l3 as $u) {
            $earned = $commissions->filter(function($t) use ($u) {
                return $t->type === 'Referral Commission L3' && isset($t->metadata['from_user_id']) && $t->metadata['from_user_id'] == $u->id;
            })->sum('amount');

            $referralsList[] = [
                'name' => $u->name,
                'email' => $u->email,
                'mobile' => $u->mobile ?: '—',
                'level' => 'Level 3 (Gen 3)',
                'joined_date' => $u->created_at->format('d M Y'),
                'commission' => number_format($earned, 2, '.', '')
            ];
        }

        return response()->json([
            'success' => true,
            'referrals' => $referralsList,
            'total_earnings' => number_format($commissions->sum('amount'), 2, '.', '')
        ]);
    }

    /**
     * Get active gateways for customer panel.
     */
    public function getGateways()
    {
        $gateways = PaymentGateway::where('status', 'active')->get();
        return response()->json([
            'success' => true,
            'gateways' => $gateways
        ]);
    }

    /**
     * Update customer theme preference in database.
     */
    public function updateTheme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme' => 'required|in:light,dark',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $user = Auth::user();
        $user->theme = $request->theme;
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Get active game settings in real-time.
     */
    public function getActiveSettings()
    {
        return response()->json([
            'success' => true,
            'active_helicopter_design' => Setting::getVal('active_helicopter_design', '1'),
            'game_countdown_time'      => Setting::getVal('game_countdown_time', '10'),
            'game_bg_music'            => Setting::getVal('game_bg_music', ''),
            'game_countdown_sound'     => Setting::getVal('game_countdown_sound', ''),
        ]);
    }

    /**
     * Get support messages list for the logged-in customer.
     */
    public function getSupportMessages()
    {
        $userId = Auth::id();
        $messages = \App\Models\SupportMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark admin replies as read
        \App\Models\SupportMessage::where('user_id', $userId)
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender' => $msg->sender,
                    'message' => $msg->message,
                    'time' => $msg->created_at->diffForHumans(),
                    'datetime' => $msg->created_at->format('d M Y, h:i A'),
                ];
            })
        ]);
    }

    /**
     * Send a support message from the customer.
     */
    public function sendSupportMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $msg = \App\Models\SupportMessage::create([
            'user_id' => Auth::id(),
            'sender' => 'user',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => [
                'id' => $msg->id,
                'sender' => $msg->sender,
                'message' => $msg->message,
                'time' => 'Just now',
                'datetime' => $msg->created_at->format('d M Y, h:i A'),
            ]
        ]);
    }

    /**
     * Place a real bet.
     */
    public function placeBet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'round_id'   => 'required|string|max:50',
            'bet_amount' => 'required|numeric|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $user = Auth::user();
        
        // Create the game bet record
        \App\Models\GameBet::create([
            'user_id'    => $user->id,
            'round_id'   => $request->round_id,
            'bet_amount' => $request->bet_amount,
            'result'     => 'pending',
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Cash out a real bet.
     */
    public function cashoutBet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'round_id'     => 'required|string|max:50',
            'cashout_odds' => 'required|numeric|min:1',
            'winnings'     => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $user = Auth::user();

        // Update the bet to win
        $bet = \App\Models\GameBet::where('user_id', $user->id)
            ->where('round_id', $request->round_id)
            ->where('result', 'pending')
            ->first();

        if ($bet) {
            $bet->update([
                'cashout_odds' => $request->cashout_odds,
                'winnings'     => $request->winnings,
                'result'       => 'win',
            ]);
        }

        return response()->json(['success' => true]);
    }
}

