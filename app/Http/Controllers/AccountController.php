<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
    public function index()
    {
        $accountData = $this->userService->getAccountData(Auth::id());

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
}
