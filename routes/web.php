<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Livewire\Guest\Home;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\EditProfile;

use App\Livewire\SekretarisCabang\Dashboard as CabangDashboard;
use App\Livewire\SekretarisCabang\ArsipSurat;
use App\Livewire\SekretarisCabang\ArsipBerkasSp;
use App\Livewire\SekretarisCabang\ArsipBerkasCabang;
use App\Livewire\SekretarisCabang\DataUserPac;
use App\Livewire\SekretarisCabang\PengajuanPac;
use App\Livewire\SekretarisCabang\KalenderKegiatan;
use App\Livewire\SekretarisCabang\DataAnggota\Anggota;
use App\Livewire\SekretarisCabang\Periode;
use App\Http\Controllers\SekretarisCabang\DetailArsipSurat;
use App\Http\Controllers\SekretarisCabang\PengajuanPacFileController;
use App\Http\Controllers\SekretarisCabang\ArsipBerkasSpFileController;
use App\Http\Controllers\SekretarisCabang\ArsipBerkasCabangFileController;
use App\Livewire\SekretarisCabang\Pengumuman as CabangPengumuman;

use App\Livewire\SekretarisPac\Dashboard as PacDashboard;
use App\Livewire\SekretarisPac\ArsipSurat as PacArsipSurat;
use App\Livewire\SekretarisPac\ArsipBerkasPac as PacArsipBerkasPac;
use App\Livewire\SekretarisPac\DataAnggota\Anggota as PacAnggota;
use App\Livewire\SekretarisPac\Periode as PacPeriode;
use App\Livewire\SekretarisPac\PengajuanSurat as PacPengajuanSurat;
use App\Livewire\SekretarisPac\ReferensiSurat as PacReferensiSurat;
use App\Http\Controllers\SekretarisPac\DetailArsipSuratPac;
use App\Http\Controllers\SekretarisPac\DetailPengajuanPacFileController;
use App\Http\Controllers\SekretarisPac\ArsipBerkasPacFileController as PacArsipBerkasPacFileController;
use App\Livewire\SekretarisPac\Pengumuman as PacPengumuman;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

/*
|--------------------------------------------------------------------------
| Email Verification Routes (DI LUAR grouped auth lain)
|--------------------------------------------------------------------------
*/
Route::get('/email/verify', function () {
    return redirect()->route('edit-profile');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return match ($request->user()->role) {
        'sekretaris_cabang' => redirect()->route('cabang.dashboard'),
        'sekretaris_pac' => redirect()->route('pac.dashboard'),
        default => redirect('/dashboard'),
    };
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    session()->flash('flash', [
        'type' => 'success',
        'message' => 'Email verifikasi dikirim ulang!'
    ]);

    return back();
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Profile Route
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/edit-profile', EditProfile::class)->name('edit-profile');
});

/*
|--------------------------------------------------------------------------
| Sekretaris Cabang Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:sekretaris_cabang'])
    ->prefix('cabang')
    ->name('cabang.')
    ->group(function () {

        Route::get('/dashboard', CabangDashboard::class)->name('dashboard');

        Route::middleware('verified')->group(function () {
            Route::get('/arsip-surat', ArsipSurat::class)->name('arsip-surat');
            Route::get('/arsip-surat/view-file/{id}', [DetailArsipSurat::class, 'viewFile'])->name('arsip-surat.view-file');
            Route::get('/arsip-surat/export', [ArsipSurat::class, 'export'])->name('arsip-surat.export');

            Route::get('/arsip-berkas-sp', ArsipBerkasSp::class)->name('arsip-berkas-sp');
            Route::get('/arsip-berkas-sp/view-file/{id}', [ArsipBerkasSpFileController::class, 'viewFile'])->name('arsip-berkas-sp.view-file');
            Route::get('/arsip-berkas-sp/download/{id}', [ArsipBerkasSpFileController::class, 'download'])->name('arsip-berkas-sp.download');

            Route::get('/arsip-berkas-cabang', ArsipBerkasCabang::class)->name('arsip-berkas-cabang');
            Route::get('/arsip-berkas-cabang/view-file/{id}', [ArsipBerkasCabangFileController::class, 'viewFile'])->name('arsip-berkas-cabang.view-file');
            Route::get('/arsip-berkas-cabang/download/{id}', [ArsipBerkasCabangFileController::class, 'download'])->name('arsip-berkas-cabang.download');

            Route::get('/pengajuan-pac', PengajuanPac::class)->name('pengajuan-pac');
            Route::get('/pengajuan-pac/file/{id}', [PengajuanPacFileController::class, 'show'])->name('pengajuan-pac.file');

            Route::get('/data-user-pac', DataUserPac::class)->name('data-user-pac');

            Route::get('/data-anggota', Anggota::class)->name('data-anggota');
            Route::get('/periode', Periode::class)->name('periode');
            Route::get('/kalender-kegiatan', KalenderKegiatan::class)->name('kalender-kegiatan');


            Route::get('/pengumuman', CabangPengumuman::class)->name('pengumuman');
        });
});

/*
|--------------------------------------------------------------------------
| Sekretaris PAC Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:sekretaris_pac'])
    ->prefix('pac')
    ->name('pac.')
    ->group(function () {

        Route::get('/dashboard', PacDashboard::class)->name('dashboard');

        Route::middleware('verified')->group(function () {
            Route::get('/arsip-surat', PacArsipSurat::class)->name('arsip-surat');
            Route::get('/arsip-surat/view-file/{id}', [DetailArsipSuratPac::class, 'viewFile'])->name('arsip-surat.view-file');
            Route::get('/arsip-surat/export', [PacArsipSurat::class, 'export'])->name('arsip-surat.export');

            Route::get('/arsip-berkas-pac', PacArsipBerkasPac::class)->name('arsip-berkas-pac');
            Route::get('/arsip-berkas-pac/view-file/{id}', [PacArsipBerkasPacFileController::class, 'viewFile'])->name('arsip-berkas-pac.view-file');
            Route::get('/arsip-berkas-pac/download/{id}', [PacArsipBerkasPacFileController::class, 'download'])->name('arsip-berkas-pac.download');

            Route::get('/pengajuan-surat', PacPengajuanSurat::class)->name('pengajuan-surat');
            Route::get('/pengajuan-pac/view-file/{id}', [DetailPengajuanPacFileController::class, 'viewFile'])->name('pengajuan-pac.view-file');

            Route::get('/referensi-surat', PacReferensiSurat::class)->name('referensi-surat');
            Route::get('/data-anggota', PacAnggota::class)->name('data-anggota');
            Route::get('/periode', PacPeriode::class)->name('periode');

            Route::get('/pengumuman', PacPengumuman::class)->name('pengumuman');

        });
});
