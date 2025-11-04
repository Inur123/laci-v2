<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictApiAccess
{
    /**
     * Domain yang diizinkan mengakses API
     */
    protected $allowedOrigins = [
        // ✅ Development
        'http://localhost:8000',
        'http://127.0.0.1:8000',

        // ✅ Production - Tambahkan domain production di sini
        'https://yourdomain.com',
        'https://www.yourdomain.com',

        // ✅ Staging - Kalau ada staging server
        'https://staging.yourdomain.com',

        // ✅ Domain lain yang mau dikasih akses
        'https://partnerdomain.com',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->headers->get('origin');
        $referer = $request->headers->get('referer');

        // ❌ Akses langsung tanpa origin/referer - TOLAK
        if (!$origin && !$referer) {
            return response()->json([
                'message' => 'Direct access not allowed'
            ], 403);
        }

        // ❌ Origin tidak ada di whitelist - TOLAK
        if ($origin && !in_array($origin, $this->allowedOrigins)) {
            return response()->json([
                'message' => 'Unauthorized domain: ' . $origin
            ], 403);
        }

        // ❌ Referer tidak ada di whitelist - TOLAK
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_SCHEME) . '://' . parse_url($referer, PHP_URL_HOST);
            if (!in_array($refererHost, $this->allowedOrigins)) {
                return response()->json([
                    'message' => 'Unauthorized referer: ' . $refererHost
                ], 403);
            }
        }

        return $next($request);
    }
}
