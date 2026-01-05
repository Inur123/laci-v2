<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('emails'); // opsional
    }

    protected function verificationUrl($notifiable)
    {
        $expire = config('auth.verification.expire', 60);

        // simpan root url saat ini (biar tidak efek global)
        $oldRoot = URL::to('/');

        // paksa pakai APP_URL (termasuk :8000) hanya saat bikin signed URL
        URL::forceRootUrl(config('app.url'));

        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes($expire),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        // balikin lagi root url ke semula
        URL::forceRootUrl($oldRoot);

        return $url;
    }

    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email Akun Anda')
            ->view('emails.verify-email', [
                'user' => $notifiable,
                'url'  => $url,
            ]);
    }
}
