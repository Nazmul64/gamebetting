<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6',
            'gender' => 'required|string',
            'country' => 'required|string',
            'currency' => 'required|string|size:3|alpha:ascii',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Check for referral code in session or request
        $referredBy = null;
        $refCode = $request->input('referred_by') ?: session('referred_by');
        if ($refCode) {
            $referrerId = (int)$refCode - 50000;
            if ($referrerId > 0 && User::where('id', $referrerId)->exists()) {
                $referredBy = $referrerId;
            }
        }

        // Create the user with 0 balance — balance is added only after deposit approval
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'mobile'     => $request->mobile,
            'password'   => Hash::make($request->password),
            'gender'     => $request->gender,
            'country'    => $request->country,
            'currency'   => $request->currency,
            'balance'    => 0.00,
            'referred_by'=> $referredBy,
        ]);

        // Clear session referred_by if it was set
        if ($refCode) {
            session()->forget('referred_by');
        }

        // Log the user in
        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect' => route('dashboard')
        ]);
    }

    /**
     * Handle user login (supporting both Email and Mobile).
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $username = $request->username;
        $password = $request->password;

        // Check if the username is email or mobile
        $loginField = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        if (Auth::attempt([$loginField => $username, 'password' => $password], $request->has('remember'))) {
            // Check if the account has been blocked by admin
            if (Auth::user()->is_blocked) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json([
                    'success' => false,
                    'errors'  => ['Your account has been blocked. Please contact support.'],
                    'blocked' => true
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => ['These credentials do not match our records.']
        ], 422);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
