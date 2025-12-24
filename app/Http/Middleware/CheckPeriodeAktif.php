<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // ✅ tambahkan ini

class CheckPeriodeAktif
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); // ✅ sudah diganti

        if (!$user || !$user->periode_aktif_id) {
            session()->flash('warning', 'Silakan pilih periode aktif terlebih dahulu');
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
