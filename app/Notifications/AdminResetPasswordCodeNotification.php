<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordCodeNotification extends Notification
{
    use Queueable;

    public $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Admin - Kode Reset Password - ' . config('app.name'))
            ->greeting('Halo Admin!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun admin Anda.')
            ->line('Gunakan kode verifikasi berikut untuk reset password:')
            ->line('')
            ->line('**Kode Verifikasi: ' . $this->code . '**')
            ->line('')
            ->line('Kode ini akan kadaluarsa dalam 15 menit.')
            ->line('Jika Anda tidak meminta reset password, segera hubungi administrator sistem untuk keamanan akun Anda.')
            ->line('Terima kasih!');
    }
}