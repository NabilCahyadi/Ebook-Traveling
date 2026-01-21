<?php

namespace App\Services;

use App\Models\Admin;
use App\Notifications\AdminResetPasswordCodeNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminPasswordResetService
{
    /**
     * Send verification code to admin email
     */
    public function sendVerificationCode(string $email): array
    {
        // Check if admin exists and is active
        $admin = Admin::where('email', $email)
            ->where('status', 'active')
            ->first();

        if (!$admin) {
            throw new \Exception('Email tidak terdaftar sebagai admin atau akun tidak aktif.');
        }

        // Generate 6 digit verification code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Delete old reset tokens for this email
        DB::table('admin_password_resets')->where('email', $email)->delete();

        // Create new token
        DB::table('admin_password_resets')->insert([
            'email' => $email,
            'token' => Str::random(64),
            'verification_code' => $code,
            'created_at' => now(),
            'expires_at' => now()->addMinutes(15), // Code expires in 15 minutes
            'attempts' => 0
        ]);

        // Send email notification
        try {
            $admin->notify(new AdminResetPasswordCodeNotification($code));
            return [
                'success' => true,
                'message' => 'Kode verifikasi telah dikirim ke email Anda. Silakan periksa inbox atau folder spam.'
            ];
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengirim email. Silakan coba lagi.');
        }
    }

    /**
     * Verify the code
     */
    public function verifyCode(string $email, string $code): array
    {
        $resetToken = DB::table('admin_password_resets')
            ->where('email', $email)
            ->first();

        if (!$resetToken) {
            throw new \Exception('Kode verifikasi tidak valid atau sudah kadaluarsa.');
        }

        // Check if code has expired
        if (now()->isAfter($resetToken->expires_at)) {
            DB::table('admin_password_resets')->where('email', $email)->delete();
            throw new \Exception('Kode verifikasi sudah kadaluarsa. Silakan minta kode baru.');
        }

        // Check attempts
        if ($resetToken->attempts >= 5) {
            DB::table('admin_password_resets')->where('email', $email)->delete();
            throw new \Exception('Terlalu banyak percobaan. Silakan minta kode verifikasi baru.');
        }

        // Verify code
        if ($resetToken->verification_code !== $code) {
            // Increment attempts
            DB::table('admin_password_resets')
                ->where('email', $email)
                ->increment('attempts');

            throw new \Exception('Kode verifikasi salah. Sisa percobaan: ' . (5 - ($resetToken->attempts + 1)));
        }

        return [
            'success' => true,
            'token' => $resetToken->token,
            'message' => 'Kode verifikasi berhasil diverifikasi.'
        ];
    }

    /**
     * Resend verification code
     */
    public function resendCode(string $email): array
    {
        $resetToken = DB::table('admin_password_resets')
            ->where('email', $email)
            ->first();

        if (!$resetToken) {
            throw new \Exception('Tidak ada permintaan reset password untuk email ini.');
        }

        // Check if last code was sent less than 1 minute ago
        if (now()->diffInSeconds($resetToken->created_at) < 60) {
            throw new \Exception('Mohon tunggu 1 menit sebelum meminta kode baru.');
        }

        // Delete old token and send new one
        DB::table('admin_password_resets')->where('email', $email)->delete();

        return $this->sendVerificationCode($email);
    }

    /**
     * Reset password
     */
    public function resetPassword(string $email, string $token, string $password): array
    {
        $resetToken = DB::table('admin_password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$resetToken) {
            throw new \Exception('Token reset password tidak valid.');
        }

        // Check if token has expired
        if (now()->isAfter($resetToken->expires_at)) {
            DB::table('admin_password_resets')->where('email', $email)->delete();
            throw new \Exception('Token sudah kadaluarsa. Silakan ulangi proses reset password.');
        }

        // Find admin
        $admin = Admin::where('email', $email)
            ->where('status', 'active')
            ->first();

        if (!$admin) {
            throw new \Exception('Admin tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            // Update password
            $admin->password = Hash::make($password);
            $admin->save();

            // Delete reset token
            DB::table('admin_password_resets')->where('email', $email)->delete();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Password berhasil direset. Silakan login dengan password baru Anda.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Check if reset token exists
     */
    public function checkToken(string $email): bool
    {
        return DB::table('admin_password_resets')
            ->where('email', $email)
            ->exists();
    }
}
