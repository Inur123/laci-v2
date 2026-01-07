<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     *  INI YANG PENTING!
     * override supaya URL verifikasi pakai localhost:8000
     */
    protected function verificationUrl($notifiable)
    {
        $appUrl = app()->environment('local')
            ? 'http://localhost:8000'
            : 'https://laci.pelajarnumagetan.or.id';

        // generate signed url laravel default
        $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        //  paksa host jadi $appUrl
        return preg_replace('#^https?://[^/]+#', $appUrl, $signedUrl);
    }

    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email Akun Anda')
            ->view('emails.verify-email', [
                'user' => $notifiable,
                'url'  => $url
            ]);
    }
}
