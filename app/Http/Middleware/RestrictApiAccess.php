<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictApiAccess
{
    /**
     * Daftar domain yang diizinkan mengakses API
     */
    protected $allowedOrigins = [
        'https://laci.pelajarnumagetan.or.id',              // Domain produksi utama
        'https://www.pelajarnumagetan.or.id', // Domain front-end
        'http://localhost:8000',              // Development
        'http://127.0.0.1:8000',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->headers->get('origin');
        $referer = $request->headers->get('referer');

        // Jika request GET langsung tanpa Origin/Referer → tetap IZIN
        if (!$origin && !$referer && $request->isMethod('GET')) {
            return $next($request);
        }

        // Validasi Origin
        if ($origin && !in_array($origin, $this->allowedOrigins)) {
            return response()->json([
                'message' => "Unauthorized domain: $origin"
            ], 403);
        }

        // Validasi Referer
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_SCHEME)
                . '://' . parse_url($referer, PHP_URL_HOST);

            if (!in_array($refererHost, $this->allowedOrigins)) {
                return response()->json([
                    'message' => "Unauthorized referer: $refererHost"
                ], 403);
            }
        }

        return $next($request);
    }
}
