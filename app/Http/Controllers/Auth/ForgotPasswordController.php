<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send verification code to email
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar dalam sistem'
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate 6 digit verification code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Delete old reset tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Create new token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Str::random(64),
            'verification_code' => $code,
            'created_at' => now(),
            'expires_at' => now()->addMinutes(15), // Code expires in 15 minutes
            'attempts' => 0
        ]);

        // Send email notification
        try {
            $user->notify(new ResetPasswordCodeNotification($code));
            
            return redirect()->route('password.verify-code')
                ->with('email', $request->email)
                ->with('success', 'Verification code has been sent to your email. Please check your inbox or spam folder.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }

    /**
     * Show verify code form
     */
    public function showVerifyForm()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-code');
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

        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetToken) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kode verifikasi tidak valid atau sudah kadaluarsa.']);
            }
            return back()->with('error', 'Kode verifikasi tidak valid atau sudah kadaluarsa.');
        }

        // Check if code is expired
        if (now()->greaterThan($resetToken->expires_at)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kode verifikasi telah kadaluarsa. Silakan minta kode baru.']);
            }
            return redirect()->route('password.request')
                ->with('error', 'Kode verifikasi telah kadaluarsa. Silakan minta kode baru.');
        }

        // Check attempts
        if ($resetToken->attempts >= 5) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Terlalu banyak percobaan. Silakan minta kode baru.']);
            }
            return redirect()->route('password.request')
                ->with('error', 'Terlalu banyak percobaan. Silakan minta kode baru.');
        }

        // Verify code
        if ($resetToken->verification_code !== $request->code) {
            // Increment attempts
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->increment('attempts');

            $remainingAttempts = 5 - ($resetToken->attempts + 1);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => "Kode verifikasi salah. Sisa percobaan: {$remainingAttempts}"]);
            }
            return back()->with('error', "Kode verifikasi salah. Sisa percobaan: {$remainingAttempts}");
        }

        // Code is valid
        // Save to session for reset password page
        session([
            'email' => $request->email,
            'token' => $resetToken->token
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Kode verifikasi benar',
                'redirect' => route('password.reset')
            ]);
        }
        
        return redirect()->route('password.reset')
            ->with('email', $request->email)
            ->with('token', $resetToken->token)
            ->with('success', 'Kode verifikasi benar. Silakan masukkan password baru Anda.');
    }

    /**
     * Show reset password form
     */
    public function showResetForm()
    {
        if (!session('email') || !session('token')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password');
    }

    /**
     * Reset the password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        // Verify token
        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetToken) {
            return redirect()->route('password.request')
                ->with('error', 'Token reset password tidak valid.');
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }

    /**
     * Resend verification code
     */
    public function resendCode(Request $request)
    {
        // Get email from session if not in request
        $email = $request->email ?? session('email');
        
        if (!$email) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Email tidak ditemukan.']);
            }
            return back()->with('error', 'Email tidak ditemukan.');
        }

        // Validate email exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Email tidak terdaftar.']);
            }
            return back()->with('error', 'Email tidak terdaftar.');
        }

        // Check if user recently requested a code (rate limiting)
        $recentToken = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', now()->subSeconds(30))
            ->first();

        if ($recentToken) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Harap tunggu 30 detik sebelum meminta kode baru.']);
            }
            return back()->with('error', 'Harap tunggu 30 detik sebelum meminta kode baru.');
        }

        // Generate new code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Delete old reset tokens for this email
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Create new token
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Str::random(64),
            'verification_code' => $code,
            'created_at' => now(),
            'expires_at' => now()->addMinutes(15),
            'attempts' => 0
        ]);

        // Send email notification
        try {
            $user->notify(new ResetPasswordCodeNotification($code));
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Kode verifikasi baru telah dikirim ke email Anda.']);
            }
            
            return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengirim email. Silakan coba lagi.']);
            }
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }
}
