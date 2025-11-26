<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Turnstile implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('Mohon verifikasi captcha terlebih dahulu.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!$response->successful() || !($result['success'] ?? false)) {
                $fail('Verifikasi captcha gagal. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Turnstile verification error: ' . $e->getMessage());
            $fail('Terjadi kesalahan saat verifikasi captcha.');
        }
    }
}
