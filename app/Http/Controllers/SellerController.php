<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SellerTransfer;
use App\Models\SellerChatMessage;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    /**
     * Show the Seller Login Page.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->is_seller) {
                return redirect()->route('seller.dashboard');
            }
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return view('seller.login');
    }

    /**
     * Process Seller Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid email or password credentials.'])->withInput();
        }

        if (!$user->is_seller && !$user->is_admin) {
            return back()->withErrors(['email' => 'This account does not have authorized Seller/Agent access.'])->withInput();
        }

        if ($user->seller_status === 'inactive' || $user->is_blocked) {
            return back()->withErrors(['email' => 'Your seller account has been disabled or placed on hold by Admin.'])->withInput();
        }

        Auth::login($user, $request->has('remember'));

        return redirect()->intended(route('seller.dashboard'));
    }

    /**
     * Seller Dashboard Home.
     */
    public function dashboard()
    {
        $seller = Auth::user();
        if (!$seller->is_seller && !$seller->is_admin) {
            abort(403, 'Unauthorized seller portal access.');
        }

        $totalTransferred = SellerTransfer::where('seller_id', $seller->id)->sum('amount');
        $transfersCount   = SellerTransfer::where('seller_id', $seller->id)->count();
        $recentTransfers  = SellerTransfer::with('customer:id,name,email,user_code')
            ->where('seller_id', $seller->id)
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        $activeChatUsers = SellerChatMessage::with('customer:id,name,email,user_code,balance')
            ->where('seller_id', $seller->id)
            ->select('customer_id', DB::raw('MAX(created_at) as last_msg_time'), DB::raw('COUNT(CASE WHEN is_read = 0 AND sender_type = "customer" THEN 1 END) as unread_count'))
            ->groupBy('customer_id')
            ->orderBy('last_msg_time', 'desc')
            ->get();

        return view('seller.dashboard', compact('seller', 'totalTransferred', 'transfersCount', 'recentTransfers', 'activeChatUsers'));
    }

    /**
     * Lookup Customer by 10-digit User Code.
     */
    public function lookupCustomer(Request $request)
    {
        $code = trim($request->query('user_code', ''));
        if (strlen($code) < 4) {
            return response()->json(['success' => false, 'message' => 'Please enter a valid User ID.']);
        }

        $customer = User::where('user_code', $code)->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer with User ID #' . $code . ' not found.']);
        }

        if ($customer->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'You cannot transfer balance to your own account.']);
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'id'        => $customer->id,
                'user_code' => $customer->user_code,
                'name'      => $customer->name,
                'email'     => $customer->email,
                'currency'  => $customer->currency ?: 'BDT',
                'balance'   => number_format($customer->balance, 2, '.', ''),
            ]
        ]);
    }

    /**
     * Transfer Balance from Seller to Customer.
     */
    public function transferToCustomer(Request $request)
    {
        $seller = Auth::user();
        if (!$seller->is_seller && !$seller->is_admin) {
            return response()->json(['success' => false, 'errors' => ['Unauthorized seller action.']], 403);
        }

        $validator = Validator::make($request->all(), [
            'user_code' => 'required|string|min:4|max:20',
            'amount'    => 'required|numeric|min:10',
            'notes'     => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        $amount = (float)$request->amount;
        $customer = User::where('user_code', trim($request->user_code))->first();

        if (!$customer) {
            return response()->json(['success' => false, 'errors' => ['Customer with User ID #' . $request->user_code . ' not found.']], 404);
        }

        if ($customer->id === $seller->id) {
            return response()->json(['success' => false, 'errors' => ['Cannot transfer balance to yourself.']], 422);
        }

        if ($seller->balance < $amount) {
            return response()->json([
                'success' => false,
                'errors' => ['Insufficient seller balance! Available balance is ৳' . number_format($seller->balance, 2)]
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Lock records for update
            $sellerDb   = User::where('id', $seller->id)->lockForUpdate()->first();
            $customerDb = User::where('id', $customer->id)->lockForUpdate()->first();

            if ($sellerDb->balance < $amount) {
                DB::rollBack();
                return response()->json(['success' => false, 'errors' => ['Insufficient balance.']], 422);
            }

            $sellerBefore   = $sellerDb->balance;
            $customerBefore = $customerDb->balance;

            $sellerDb->balance -= $amount;
            $customerDb->balance += $amount;

            $sellerDb->save();
            $customerDb->save();

            // Record Transfer
            $transfer = SellerTransfer::create([
                'seller_id'               => $sellerDb->id,
                'customer_id'             => $customerDb->id,
                'customer_user_code'      => $customerDb->user_code,
                'amount'                  => $amount,
                'seller_balance_before'   => $sellerBefore,
                'seller_balance_after'    => $sellerDb->balance,
                'customer_balance_before' => $customerBefore,
                'customer_balance_after'  => $customerDb->balance,
                'notes'                   => $request->notes,
            ]);

            // Create ledger transactions for both parties
            Transaction::create([
                'user_id'  => $customerDb->id,
                'type'     => 'Deposit',
                'gateway'  => 'Agent: ' . $sellerDb->name,
                'amount'   => $amount,
                'fee'      => 0,
                'status'   => 'Completed',
                'metadata' => [
                    'agent_id'    => $sellerDb->id,
                    'agent_name'  => $sellerDb->name,
                    'transfer_id' => $transfer->id,
                    'notes'       => $request->notes,
                ]
            ]);

            Transaction::create([
                'user_id'  => $sellerDb->id,
                'type'     => 'Transfer',
                'gateway'  => 'Agent Transfer Out',
                'amount'   => $amount,
                'fee'      => 0,
                'status'   => 'Completed',
                'metadata' => [
                    'recipient_id'   => $customerDb->id,
                    'recipient_name' => $customerDb->name,
                    'recipient_code' => $customerDb->user_code,
                    'transfer_id'    => $transfer->id,
                ]
            ]);

            DB::commit();

            return response()->json([
                'success'        => true,
                'message'        => 'Successfully transferred ৳' . number_format($amount, 2) . ' to ' . $customerDb->name . ' (ID: ' . $customerDb->user_code . ').',
                'seller_balance' => number_format($sellerDb->balance, 2, '.', ''),
                'transfer'       => [
                    'id'            => $transfer->id,
                    'customer_name' => $customerDb->name,
                    'user_code'     => $customerDb->user_code,
                    'amount'        => number_format($amount, 2),
                    'created_at'    => $transfer->created_at->format('d M Y, h:i A'),
                ]
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'errors' => ['Transfer failed: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Get Seller Transfer History.
     */
    public function getTransfersHistory()
    {
        $seller = Auth::user();
        $transfers = SellerTransfer::with('customer:id,name,email,user_code')
            ->where('seller_id', $seller->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success'   => true,
            'transfers' => $transfers->map(function ($t) {
                return [
                    'id'            => $t->id,
                    'customer_name' => $t->customer ? $t->customer->name : 'N/A',
                    'user_code'     => $t->customer_user_code,
                    'amount'        => number_format($t->amount, 2),
                    'seller_bal'    => number_format($t->seller_balance_after, 2),
                    'notes'         => $t->notes,
                    'created_at'    => $t->created_at->format('d M Y, h:i A'),
                ];
            })
        ]);
    }

    /**
     * Get Chat Messages with a specific Customer.
     */
    public function getChatMessages($customerId)
    {
        $seller = Auth::user();
        $customer = User::find($customerId);
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }

        // Mark incoming messages as read
        SellerChatMessage::where('seller_id', $seller->id)
            ->where('customer_id', $customerId)
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = SellerChatMessage::where('seller_id', $seller->id)
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success'  => true,
            'customer' => [
                'id'        => $customer->id,
                'name'      => $customer->name,
                'user_code' => $customer->user_code,
                'email'     => $customer->email,
                'balance'   => number_format($customer->balance, 2),
            ],
            'messages' => $messages->map(function ($m) {
                return [
                    'id'          => $m->id,
                    'sender_type' => $m->sender_type,
                    'message'     => $m->message,
                    'time'        => $m->created_at->format('h:i A'),
                ];
            })
        ]);
    }

    /**
     * Send Message from Seller to Customer.
     */
    public function sendChatMessage(Request $request)
    {
        $seller = Auth::user();
        $request->validate([
            'customer_id' => 'required|integer',
            'message'     => 'required|string|max:1000',
        ]);

        $msg = SellerChatMessage::create([
            'seller_id'   => $seller->id,
            'customer_id' => $request->customer_id,
            'sender_type' => 'seller',
            'message'     => trim($request->message),
            'is_read'     => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'          => $msg->id,
                'sender_type' => 'seller',
                'message'     => $msg->message,
                'time'        => $msg->created_at->format('h:i A'),
            ]
        ]);
    }

    /**
     * Public API for Customer: List Active Sellers.
     */
    public function getPublicSellers()
    {
        $sellers = User::where('is_seller', true)
            ->where('seller_status', 'active')
            ->where('is_blocked', false)
            ->select('id', 'name', 'user_code', 'seller_photo', 'seller_phone', 'created_at')
            ->get();

        return response()->json([
            'success' => true,
            'sellers' => $sellers->map(function ($s) {
                $photo = $s->seller_photo && file_exists(public_path($s->seller_photo))
                    ? asset($s->seller_photo)
                    : asset('uploads/agent_profile_pictures/default_agent.png');
                return [
                    'id'           => $s->id,
                    'name'         => $s->name,
                    'user_code'    => $s->user_code,
                    'seller_photo' => $photo,
                    'seller_phone' => $s->seller_phone ?: 'Available 24/7',
                ];
            })
        ]);
    }

    /**
     * Customer API: Get Chat Messages with Seller.
     */
    public function getCustomerChat($sellerId)
    {
        $customer = Auth::user();
        $seller = User::where('id', $sellerId)->where('is_seller', true)->first();
        if (!$seller) {
            return response()->json(['success' => false, 'message' => 'Agent not found.'], 404);
        }

        // Mark incoming messages as read
        SellerChatMessage::where('seller_id', $sellerId)
            ->where('customer_id', $customer->id)
            ->where('sender_type', 'seller')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = SellerChatMessage::where('seller_id', $sellerId)
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $photo = $seller->seller_photo && file_exists(public_path($seller->seller_photo))
            ? asset($seller->seller_photo)
            : asset('uploads/agent_profile_pictures/default_agent.png');

        return response()->json([
            'success' => true,
            'seller'  => [
                'id'           => $seller->id,
                'name'         => $seller->name,
                'user_code'    => $seller->user_code,
                'seller_photo' => $photo,
                'seller_phone' => $seller->seller_phone,
            ],
            'customer_user_code' => $customer->user_code,
            'messages' => $messages->map(function ($m) {
                return [
                    'id'          => $m->id,
                    'sender_type' => $m->sender_type,
                    'message'     => $m->message,
                    'time'        => $m->created_at->format('h:i A'),
                ];
            })
        ]);
    }

    /**
     * Customer API: Send message to Seller.
     */
    public function sendCustomerMessage(Request $request)
    {
        $customer = Auth::user();
        $request->validate([
            'seller_id' => 'required|integer',
            'message'   => 'required|string|max:1000',
        ]);

        $msg = SellerChatMessage::create([
            'seller_id'   => $request->seller_id,
            'customer_id' => $customer->id,
            'sender_type' => 'customer',
            'message'     => trim($request->message),
            'is_read'     => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'          => $msg->id,
                'sender_type' => 'customer',
                'message'     => $msg->message,
                'time'        => $msg->created_at->format('h:i A'),
            ]
        ]);
    }

    /**
     * Seller Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('seller.login');
    }
}
