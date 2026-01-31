<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\City;
use App\Models\EbookRating;


class AccountController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show account dashboard
     */
    public function index(Request $request)
    {
        // ✅ CLEAN URL: Jika Mayar menambahkan params tapi dengan tanda '?' yang salah
        // Contoh bad URL: /page-account?tab=dashboard?external_id=...&name=...
        $rawQuery = $request->getQueryString();
        $tabParam = $request->query('tab');

        $hasExternalAsKey = $request->has('external_id');
        $hasExternalInRaw = is_string($rawQuery) && strpos($rawQuery, 'external_id=') !== false;
        $externalInsideTab = is_string($tabParam) && strpos($tabParam, '?external_id=') !== false;

        if ($hasExternalAsKey || $hasExternalInRaw || $externalInsideTab) {
            Log::info('🧹 [ACCOUNT] Cleaning Mayar redirect URL (robust check)', [
                'original_url' => $request->fullUrl(),
                'raw_query' => $rawQuery,
                'tab_param' => $tabParam,
            ]);

            // Redirect ke URL yang clean: /page-account?tab=dashboard (tanpa parameter apapun dari Mayar)
            return redirect()->route('page-account', ['tab' => 'dashboard']);
        }

        // ✅ 1. AMBIL USER BARU DARI DATABASE
        $user = auth()->user()->fresh();

        // ✅ 2. LOAD SEMUA RELASI YANG DIBUTUHKAN
        $user->load([
            'currentSubscription.plan',
            'subscriptions.plan',
            'payments.plan',
            'payments.subscription.plan',
        ]);

        // ✅ 3. GANTI SESSION USER DENGAN YANG BARU
        auth()->setUser($user);

        // Lanjutkan seperti biasa
        $accountData = $this->userService->getAccountData($user->id, $request);
        $accountData['user'] = $user;

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        $accountData['citiesHeader'] = $citiesHeader;

        // ✅ 4. GET SUBSCRIPTION PLANS FOR UPGRADE OPTIONS
        // Only show plans with higher duration than current active plan
        $currentPlan = $user->currentPlan;
        $currentDuration = $currentPlan ? $currentPlan->duration_days : 0;

        $subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)
            ->where('duration_days', '>', $currentDuration)
            ->orderBy('duration_days', 'asc')
            ->get();
        $accountData['subscriptionPlans'] = $subscriptionPlans;

        return view('page-account', $accountData);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'country' => 'nullable|string|max:100',
            'preferred_language' => 'required|in:id,en',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $result = $this->userService->updateProfile(Auth::id(), $request->all());

        if ($result['success']) {
            return redirect()->route('page-account')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', 'Profile update failed: ' . $result['error']);
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:6|confirmed',
        ]);

        try {
            // Pakai Eloquent langsung dengan UUID
            $user = User::find(Auth::id());

            if (!$user) {
                return redirect()->back()
                    ->with('error', 'User not found');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('page-account')
                ->with('success', 'Password updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Password update failed: ' . $e->getMessage());
        }
    }

    public function updateAvatar(Request $request)
    {
        // Validasi input
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Hapus avatar lama jika ada dan bukan default
        if ($user->avatar && $user->avatar !== 'users/avatars/default.png') {
            Storage::delete('public/' . $user->avatar);
        }

        // Proses upload avatar baru
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            // --- GUNAKAN CARA INI YANG SUDAH TERBUKTI BERHASIL ---
            $destinationPath = public_path('storage/users/avatars/' . $filename);
            move_uploaded_file($avatar->getPathname(), $destinationPath);

            // Update path avatar di database
            $user->avatar = 'users/avatars/' . $filename;
            $user->save();
        }

        return back()->with('success', 'Profile photo updated successfully!');
    }

    // AccountController.php
    public function updateReview(Request $request, string $ratingId)
    {
        $rating = EbookRating::where('id', $ratingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'review_text' => 'required|string|max:2000',
            'rating' => 'required|integer|between:1,5',
        ]);

        $rating->update($request->only(['review_text', 'rating']));

        return redirect()->route('page-account', ['tab' => 'reviews'])
            ->with('success', 'Review updated successfully!');
    }
}
