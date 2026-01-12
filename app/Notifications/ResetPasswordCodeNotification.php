<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordCodeNotification extends Notification
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
            ->subject('Kode Reset Password - ' . config('app.name'))
            ->greeting('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
            ->line('Gunakan kode verifikasi berikut untuk reset password:')
            ->line('')
            ->line('**Kode Verifikasi: ' . $this->code . '**')
            ->line('')
            ->line('Kode ini akan kadaluarsa dalam 15 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->line('Terima kasih telah menggunakan ' . config('app.name') . '!');
    }
}
