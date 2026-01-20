<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminPasswordResetService;
use Illuminate\Http\Request;

class AdminForgotPasswordController extends Controller
{
    protected $passwordResetService;

    public function __construct(AdminPasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Show forgot password form
     */
    public function showForgotForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Send verification code to email
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid'
        ]);

        try {
            $result = $this->passwordResetService->sendVerificationCode($request->email);
            
            return redirect()->route('admin.password.verify-code')
                ->with('email', $request->email)
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show verify code form
     */
    public function showVerifyForm()
    {
        if (!session('email')) {
            return redirect()->route('admin.password.request');
        }

        return view('admin.auth.verify-code');
    }

    /**
     * Verify the code
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ], [
            'code.required' => 'Kode verifikasi harus diisi',
            'code.size' => 'Kode verifikasi harus 6 digit'
        ]);

        try {
            $result = $this->passwordResetService->verifyCode($request->email, $request->code);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message']
                ]);
            }

            return redirect()->route('admin.password.reset')
                ->with('email', $request->email)
                ->with('token', $result['token'])
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }

            return back()
                ->with('email', $request->email)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Resend verification code
     */
    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            $result = $this->passwordResetService->resendCode($request->email);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message']
                ]);
            }

            return back()
                ->with('email', $request->email)
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }

            return back()
                ->with('email', $request->email)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show reset password form
     */
    public function showResetForm()
    {
        if (!session('email') || !session('token')) {
            return redirect()->route('admin.password.request');
        }

        return view('admin.auth.reset-password');
    }

    /**
     * Reset password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ], [
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        try {
            $result = $this->passwordResetService->resetPassword(
                $request->email,
                $request->token,
                $request->password
            );

            return redirect()->route('admin.login')
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }
}
