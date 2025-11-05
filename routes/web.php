<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/routes/web.php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\Register;

use App\Livewire\SekretarisCabang\ArsipSurat;
use App\Livewire\SekretarisCabang\DataUserPac;
use App\Livewire\SekretarisCabang\PengajuanPac;
use App\Livewire\SekretarisCabang\KalenderKegiatan;
use App\Livewire\SekretarisCabang\DataAnggota\Anggota;
use App\Livewire\SekretarisCabang\DataAnggota\Periode;
use App\Livewire\SekretarisCabang\Dashboard as CabangDashboard;

use App\Livewire\SekretarisPac\Dashboard as PacDashboard;
use App\Livewire\SekretarisPac\ArsipSurat as PacArsipSurat;
use App\Livewire\SekretarisPac\PengajuanSurat as PacPengajuanSurat;
use App\Livewire\SekretarisPac\ReferensiSurat as PacReferensiSurat;
use App\Livewire\SekretarisPac\DataAnggota\Anggota as PacAnggota;
use App\Livewire\SekretarisPac\DataAnggota\Periode as PacPeriode;

use App\Http\Controllers\SekretarisCabang\DetailArsipSurat;
use App\Http\Controllers\SekretarisCabang\PengajuanPacFileController;
use App\Http\Controllers\SekretarisPac\DetailArsipSuratPac;
use App\Http\Controllers\SekretarisPac\DetailPengajuanPacFileController;

/* Guest Routes */
Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

/* Sekretaris Cabang Routes */
Route::middleware(['auth', 'role:sekretaris_cabang'])->prefix('cabang')->name('cabang.')->group(function () {
    Route::get('/dashboard', CabangDashboard::class)->name('dashboard');

    Route::get('/arsip-surat', ArsipSurat::class)->name('arsip-surat');
    Route::get('/arsip-surat/view-file/{id}', [DetailArsipSurat::class, 'viewFile'])->name('arsip-surat.view-file');

    Route::get('/pengajuan-pac', PengajuanPac::class)->name('pengajuan-pac');
    Route::get('/pengajuan-pac/file/{id}', [PengajuanPacFileController::class, 'show'])->name('pengajuan-pac.file');

    Route::get('/data-user-pac', DataUserPac::class)->name('data-user-pac');
    Route::get('/data-anggota', Anggota::class)->name('data-anggota');
    Route::get('/periode', Periode::class)->name('periode');
    Route::get('/kalender-kegiatan', KalenderKegiatan::class)->name('kalender-kegiatan');
});

/* Sekretaris PAC Routes */
Route::middleware(['auth', 'role:sekretaris_pac'])->prefix('pac')->name('pac.')->group(function () {
    Route::get('/dashboard', PacDashboard::class)->name('dashboard');

    Route::get('/arsip-surat', PacArsipSurat::class)->name('arsip-surat');
    Route::get('/arsip-surat/view-file/{id}', [DetailArsipSuratPac::class, 'viewFile'])->name('arsip-surat.view-file');

    Route::get('/pengajuan-surat', PacPengajuanSurat::class)->name('pengajuan-surat');
    Route::get('/pengajuan-pac/view-file/{id}', [DetailPengajuanPacFileController::class, 'viewFile'])->name('pengajuan-pac.view-file');

    Route::get('/referensi-surat', PacReferensiSurat::class)->name('referensi-surat');
    Route::get('/data-anggota', PacAnggota::class)->name('data-anggota');
    Route::get('/periode', PacPeriode::class)->name('periode');
});
