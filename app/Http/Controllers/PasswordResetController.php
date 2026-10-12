<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Show Forgot Password Form / Modal page.
     */
    public function showForgotForm()
    {
        return view('auth.login', ['activeTab' => 'forgot']);
    }

    /**
     * Send Password Reset Link to the user's email.
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ], [
            'email.required' => 'Please enter your account email address.',
            'email.email' => 'Please provide a valid email format.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => ['No account found matching this email address.']
            ], 404);
        }

        // Generate a 64-character secure random token
        $token = Str::random(64);

        // Store plain token in DB with timestamp
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Generate the reset URL
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));
        $siteName = Setting::getVal('site_name', config('app.name', 'NexPlayUK'));

        try {
            Mail::send('emails.password-reset', [
                'user' => $user,
                'resetUrl' => $resetUrl,
                'siteName' => $siteName
            ], function ($message) use ($user, $siteName) {
                $message->to($user->email, $user->name)
                        ->subject('Password Reset Request — ' . $siteName);
            });

            return response()->json([
                'success' => true,
                'message' => 'Password reset instructions have been sent to ' . $user->email . '. Please check your inbox or spam folder.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => ['Failed to send email: ' . $e->getMessage()]
            ], 500);
        }
    }

    /**
     * Show the Password Reset form.
     */
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Process Password Reset request.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Please enter a new password.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'New password confirmation does not match.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $token = $request->token;

        $record = DB::table('password_reset_tokens')
                    ->where('email', $email)
                    ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'errors' => ['Invalid password reset request or token expired.']
            ], 422);
        }

        // Check token expiration (60 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json([
                'success' => false,
                'errors' => ['This password reset link has expired (valid for 60 minutes). Please request a new one.']
            ], 422);
        }

        // Verify token match
        if ($record->token !== $token) {
            return response()->json([
                'success' => false,
                'errors' => ['Invalid password reset token.']
            ], 422);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => ['User account not found.']
            ], 404);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete reset token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your password has been successfully reset! You can now log in with your new password.',
            'redirect' => route('login')
        ]);
    }
}
