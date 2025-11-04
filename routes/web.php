<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/routes/web.php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\SekretarisPac\Dashboard as PacDashboard;
use App\Livewire\SekretarisCabang\Dashboard as CabangDashboard;
use Illuminate\Support\Facades\Auth;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Logout route
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Routes untuk Sekretaris PAC
    Route::middleware(['role:sekretaris_pac'])->prefix('sekretaris-pac')->group(function () {
        Route::get('/dashboard', PacDashboard::class)->name('pac.dashboard');
    });

    // Routes untuk Sekretaris Cabang
    Route::middleware(['role:sekretaris_cabang'])->prefix('sekretaris-cabang')->group(function () {
        Route::get('/dashboard', CabangDashboard::class)->name('cabang.dashboard');
    });
});
