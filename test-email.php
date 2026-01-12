<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\User;

try {
    // Get test user
    $user = User::where('email', 'azkacahyadi155@gmail.com')->first();
    
    if (!$user) {
        echo "User dengan email azkacahyadi155@gmail.com tidak ditemukan.\n";
        echo "Mencoba kirim test email langsung...\n\n";
        
        Mail::raw('Ini adalah test email dari sistem ebook traveling.', function ($message) {
            $message->to('azkacahyadi155@gmail.com')
                    ->subject('Test Email - Ebook Traveling');
        });
    } else {
        // Send test notification
        $code = '123456';
        $user->notify(new \App\Notifications\ResetPasswordCodeNotification($code));
    }
    
    echo "✓ Email berhasil dikirim!\n";
    echo "Silakan cek inbox/spam email azkacahyadi155@gmail.com\n";
    
} catch (\Exception $e) {
    echo "✗ Gagal mengirim email!\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    echo "Kemungkinan penyebab:\n";
    echo "1. App Password Gmail tidak valid\n";
    echo "2. Koneksi internet bermasalah\n";
    echo "3. Gmail memblokir akses\n\n";
    
    echo "Solusi:\n";
    echo "1. Generate App Password baru di Gmail:\n";
    echo "   - Buka: https://myaccount.google.com/apppasswords\n";
    echo "   - Login dengan akun: nabilcahyadi155@gmail.com\n";
    echo "   - Buat App Password baru\n";
    echo "   - Update MAIL_PASSWORD di file .env\n";
    echo "2. Jalankan: php artisan config:clear\n";
}
