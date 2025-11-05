<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/routes/web.php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\SekretarisCabang\ArsipSurat;
use App\Livewire\SekretarisCabang\DataUserPac;
use App\Livewire\SekretarisCabang\PengajuanPac;
use App\Livewire\SekretarisCabang\KalenderKegiatan;

use App\Livewire\SekretarisCabang\DataAnggota\Anggota;
use App\Livewire\SekretarisCabang\DataAnggota\Periode;
use App\Livewire\SekretarisPac\Dashboard as PacDashboard;
use App\Livewire\SekretarisPac\ArsipSurat as PacArsipSurat;
use App\Livewire\SekretarisCabang\Dashboard as CabangDashboard;
use App\Livewire\SekretarisPac\DataAnggota\Anggota as PacAnggota;
use App\Livewire\SekretarisPac\DataAnggota\Periode as PacPeriode;
use App\Livewire\SekretarisPac\PengajuanSurat as PacPengajuanSurat;
use App\Livewire\SekretarisPac\ReferensiSurat as PacReferensiSurat;
use App\Http\Controllers\SekretarisCabang\PengajuanPacFileController;


// Guest routes
Route::middleware('guest')->group(function () {

    Route::get('/', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Authenticated routes
// Sekretaris Cabang Routes
Route::middleware(['auth', 'role:sekretaris_cabang'])->prefix('cabang')->name('cabang.')->group(function () {
    Route::get('/dashboard', CabangDashboard::class)->name('dashboard');
    Route::get('/arsip-surat', ArsipSurat::class)->name('arsip-surat');
    Route::get('/pengajuan-pac', PengajuanPac::class)->name('pengajuan-pac');
    Route::get('/pengajuan-pac/file/{id}', [PengajuanPacFileController::class, 'show'])
    ->middleware(['auth', 'role:sekretaris_cabang'])
    ->name('pengajuan-pac.file');
    Route::get('/data-user-pac', DataUserPac::class)->name('data-user-pac');
    Route::get('/data-anggota', Anggota::class)->name('data-anggota');
    Route::get('/periode', Periode::class)->name('periode');
    Route::get('/kalender-kegiatan', KalenderKegiatan::class)->name('kalender-kegiatan');
});

// Sekretaris PAC Routes
Route::middleware(['auth', 'role:sekretaris_pac'])->prefix('pac')->name('pac.')->group(function () {
    Route::get('/dashboard', PacDashboard::class)->name('dashboard');
    Route::get('/arsip-surat', PacArsipSurat::class)->name('arsip-surat');
    Route::get('/pengajuan-surat', PacPengajuanSurat::class)->name('pengajuan-surat');
    Route::get('/referensi-surat', PacReferensiSurat::class)->name('referensi-surat');
    Route::get('/data-anggota', PacAnggota::class)->name('data-anggota');
    Route::get('/periode', PacPeriode::class)->name('periode');
});
