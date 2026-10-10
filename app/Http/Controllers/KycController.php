<?php

namespace App\Http\Controllers;

use App\Models\KycVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Exception;

class KycController extends Controller
{
    /**
     * Ensure upload directory exists
     */
    protected function ensureKycUploadDir()
    {
        $path = public_path('uploads/kyc');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        return $path;
    }

    /**
     * CUSTOMER: Submit KYC Verification documents
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'অননুমোদিত প্রবেশাধিকার। অনুগ্রহ করে লগইন করুন।'], 401);
        }

        // Check if user already has a pending or verified KYC
        $existing = KycVerification::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'verified'])
            ->latest()
            ->first();

        if ($existing && $existing->status === 'verified') {
            return response()->json([
                'success' => false,
                'message' => 'আপনার অ্যাকাউন্ট ইতিমধ্যে সফলভাবে ভেরিফাইড (Verified) রয়েছে।'
            ], 400);
        }

        if ($existing && $existing->status === 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'আপনার কেওয়াইসি (KYC) আবেদনটি পর্যালোচনার জন্য পেন্ডিং (Pending) রয়েছে। অনুগ্রহ করে অ্যাডমিনের অনুমোদনের অপেক্ষা করুন।'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'document_type'   => 'required|in:nid,passport,birth_certificate',
            'document_number' => 'nullable|string|max:100',
            'full_name'       => 'nullable|string|max:150',
            'dob'             => 'nullable|string|max:50',
            'front_image'     => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
            'back_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
        ], [
            'document_type.required' => 'ডকুমেন্টের ধরণ নির্বাচন করুন।',
            'front_image.required'   => 'ডকুমেন্টের সামনের পাতার (Front Part) ছবি আপলোড করুন।',
            'front_image.image'      => 'সামনের পাতার ফাইলটি একটি বৈধ ছবি হতে হবে।',
            'back_image.image'       => 'পেছনের পাতার ফাইলটি একটি বৈধ ছবি হতে হবে।',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        $this->ensureKycUploadDir();

        // Upload Front Part
        $frontImage = $request->file('front_image');
        $frontName = 'kyc_front_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $frontImage->getClientOriginalExtension();
        $frontImage->move(public_path('uploads/kyc'), $frontName);
        $frontPath = 'uploads/kyc/' . $frontName;

        // Upload Back Part (if provided)
        $backPath = null;
        if ($request->hasFile('back_image')) {
            $backImage = $request->file('back_image');
            $backName = 'kyc_back_' . $user->id . '_' . time() . '_' . uniqid() . '.' . $backImage->getClientOriginalExtension();
            $backImage->move(public_path('uploads/kyc'), $backName);
            $backPath = 'uploads/kyc/' . $backName;
        }

        $kyc = KycVerification::create([
            'user_id'         => $user->id,
            'document_type'   => $request->document_type,
            'document_number' => $request->document_number ?? '',
            'full_name'       => $request->full_name ?? $user->name,
            'dob'             => $request->dob ?? '',
            'front_image'     => $frontPath,
            'back_image'      => $backPath,
            'status'          => 'pending',
            'submitted_at'    => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'কেওয়াইসি (KYC) ডকুমেন্ট সফলভাবে জমা হয়েছে! অ্যাডমিন পর্যালোচনা করে অনুমোদন দিলে আপনার অ্যাকাউন্ট ভেরিফাইড হয়ে যাবে।',
            'kyc'     => $kyc
        ]);
    }

    /**
     * CUSTOMER: Get current KYC status and details
     */
    public function getStatus()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $kyc = KycVerification::where('user_id', $user->id)->latest()->first();

        return response()->json([
            'success' => true,
            'status'  => $kyc ? $kyc->status : 'unverified',
            'kyc'     => $kyc ? [
                'id'              => $kyc->id,
                'document_type'   => $kyc->document_type,
                'document_label'  => $kyc->document_type_label,
                'document_number' => $kyc->document_number,
                'full_name'       => $kyc->full_name,
                'front_image'     => asset($kyc->front_image),
                'back_image'      => $kyc->back_image ? asset($kyc->back_image) : null,
                'status'          => $kyc->status,
                'status_label'    => $kyc->status_label,
                'rejection_reason'=> $kyc->rejection_reason,
                'submitted_at'    => $kyc->submitted_at ? $kyc->submitted_at->format('d M, Y h:i A') : '',
                'reviewed_at'     => $kyc->reviewed_at ? $kyc->reviewed_at->format('d M, Y h:i A') : '',
            ] : null
        ]);
    }

    /**
     * ADMIN: List all KYC verification submissions
     */
    public function adminList(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = KycVerification::with(['user' => function($q) {
            $q->select('id', 'name', 'email', 'mobile', 'user_code', 'balance', 'country');
        }])->orderByDesc('id');

        if (in_array($status, ['pending', 'verified', 'rejected'])) {
            $query->where('status', $status);
        }

        $verifications = $query->paginate(20);

        $counts = [
            'all'      => KycVerification::count(),
            'pending'  => KycVerification::where('status', 'pending')->count(),
            'verified' => KycVerification::where('status', 'verified')->count(),
            'rejected' => KycVerification::where('status', 'rejected')->count(),
        ];

        return response()->json([
            'success' => true,
            'data'    => $verifications,
            'counts'  => $counts
        ]);
    }

    /**
     * ADMIN: Approve KYC verification
     */
    public function adminApprove($id)
    {
        $kyc = KycVerification::with('user')->find($id);
        if (!$kyc) {
            return response()->json(['success' => false, 'message' => 'KYC রেকর্ড পাওয়া যায়নি।'], 404);
        }

        $kyc->status = 'verified';
        $kyc->rejection_reason = null;
        $kyc->reviewed_at = now();
        $kyc->save();

        return response()->json([
            'success' => true,
            'message' => "ব্যবহারকারী '{$kyc->user->name}' এর KYC সফলভাবে অনুমোদিত (Approved/Verified) হয়েছে!",
            'kyc'     => $kyc
        ]);
    }

    /**
     * ADMIN: Reject KYC verification
     */
    public function adminReject(Request $request, $id)
    {
        $kyc = KycVerification::with('user')->find($id);
        if (!$kyc) {
            return response()->json(['success' => false, 'message' => 'KYC রেকর্ড পাওয়া যায়নি।'], 404);
        }

        $reason = $request->input('reason', 'ডকুমেন্ট অস্পষ্ট অথবা তথ্যের অমিল রয়েছে। পুনরায় সঠিক ডকুমেন্ট আপলোড করুন।');
        $kyc->status = 'rejected';
        $kyc->rejection_reason = $reason;
        $kyc->reviewed_at = now();
        $kyc->save();

        return response()->json([
            'success' => true,
            'message' => "ব্যবহারকারী '{$kyc->user->name}' এর KYC আবেদন বাতিল (Rejected) করা হয়েছে।",
            'kyc'     => $kyc
        ]);
    }

    /**
     * ADMIN: Reset / Release KYC (delete record so user can resubmit freshly)
     */
    public function adminReset($id)
    {
        $kyc = KycVerification::find($id);
        if (!$kyc) {
            return response()->json(['success' => false, 'message' => 'KYC রেকর্ড পাওয়া যায়নি।'], 404);
        }

        // Delete uploaded files if exist
        if ($kyc->front_image && File::exists(public_path($kyc->front_image))) {
            @unlink(public_path($kyc->front_image));
        }
        if ($kyc->back_image && File::exists(public_path($kyc->back_image))) {
            @unlink(public_path($kyc->back_image));
        }

        $kyc->delete();

        return response()->json([
            'success' => true,
            'message' => 'কেওয়াইসি (KYC) রেকর্ডটি সফলভাবে রিলিজ / মুছে ফেলা হয়েছে।'
        ]);
    }
}
