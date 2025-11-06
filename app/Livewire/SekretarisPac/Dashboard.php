<?php

namespace App\Livewire\SekretarisPac;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt; // TAMBAHKAN INI
use App\Models\Anggota;
use App\Models\Periode;
use App\Models\Surat;
use App\Models\PengajuanSuratPac;
use Illuminate\Support\Collection;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Dashboard PAC')]
class Dashboard extends Component
{
    public $activityLimit = 30;

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }
    }

    public function loadMoreActivities()
    {
        $this->activityLimit += 15;
    }

    // === STATISTIK ANGGOTA ===
    public function getTotalAnggotaProperty()
    {
        return Anggota::where('user_id', Auth::id())->count();
    }

    public function getAnggotaLakiLakiProperty()
    {
        return Anggota::where('user_id', Auth::id())
            ->where('jenis_kelamin', 'Laki-laki')->count();
    }

    public function getAnggotaPerempuanProperty()
    {
        return Anggota::where('user_id', Auth::id())
            ->where('jenis_kelamin', 'Perempuan')->count();
    }

    public function getAnggotaBulanIniProperty()
    {
        return Anggota::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    // === STATISTIK PERIODE ===
    public function getTotalPeriodeProperty()
    {
        return Periode::where('user_id', Auth::id())->count();
    }

    // === STATISTIK ARSIP SURAT ===
    public function getTotalSuratProperty()
    {
        return Surat::where('user_id', Auth::id())->count();
    }

    public function getSuratMasukProperty()
    {
        return Surat::where('user_id', Auth::id())->where('jenis_surat', 'masuk')->count();
    }

    public function getSuratKeluarProperty()
    {
        return Surat::where('user_id', Auth::id())->where('jenis_surat', 'keluar')->count();
    }

    public function getSuratBulanIniProperty()
    {
        return Surat::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    // === STATISTIK PENGAJUAN SURAT ===
    public function getTotalPengajuanProperty()
    {
        return PengajuanSuratPac::where('user_id', Auth::id())->count();
    }

    public function getPengajuanPendingProperty()
{
    return PengajuanSuratPac::where('user_id', Auth::id())
        ->get()
        ->filter(fn($p) => $p->status === 'pending')
        ->count();
}

public function getPengajuanDiterimaProperty()
{
    return PengajuanSuratPac::where('user_id', Auth::id())
        ->get()
        ->filter(fn($p) => $p->status === 'diterima')
        ->count();
}
    public function getAktivitasTerbaruProperty(): Collection
    {
        $activities = collect();
        $userId = Auth::id();
        $limitPerCategory = ceil($this->activityLimit / 5);

        // 1. ANGGOTA
        $anggotas = Anggota::where('user_id', $userId)
            ->with('periode')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function ($anggota) {
                $isNew = $anggota->created_at->diffInMinutes($anggota->updated_at) < 1;

                return [
                    'type' => 'anggota',
                    'icon' => $isNew ? 'fa-user-plus' : 'fa-user-edit',
                    'color' => $isNew ? 'green' : 'blue',
                    'title' => $isNew ? 'Anggota Baru Ditambahkan' : 'Anggota Diperbarui',
                    'description' => $anggota->nama_lengkap . ' - ' . $anggota->periode->nama,
                    'time' => $isNew ? $anggota->created_at : $anggota->updated_at,
                    'user' => Auth::user()->name,
                ];
            });

        // 2. SURAT
        $surats = Surat::where('user_id', $userId)
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function ($surat) {
                $isNew = $surat->created_at->diffInMinutes($surat->updated_at) < 1;

                return [
                    'type' => 'surat',
                    'icon' => $isNew ? 'fa-envelope' : 'fa-envelope-open-text',
                    'color' => $isNew ? ($surat->jenis_surat === 'masuk' ? 'teal' : 'indigo') : 'orange',
                    'title' => $isNew
                        ? 'Surat ' . ucfirst($surat->jenis_surat) . ' Baru'
                        : 'Surat Diperbarui',
                    'description' => 'No: ' . $surat->no_surat . ' - ' . $surat->pengirim_penerima,
                    'time' => $isNew ? $surat->created_at : $surat->updated_at,
                    'user' => Auth::user()->name,
                ];
            });

        // 3. PERIODE
        $periodes = Periode::where('user_id', $userId)
            ->latest('updated_at')
            ->limit($limitPerCategory)
            ->get()
            ->map(function ($periode) {
                $isNew = $periode->created_at->diffInMinutes($periode->updated_at) < 1;

                return [
                    'type' => 'periode',
                    'icon' => $isNew ? 'fa-clock' : 'fa-history',
                    'color' => $isNew ? 'purple' : 'orange',
                    'title' => $isNew ? 'Periode Baru Dibuat' : 'Periode Diperbarui',
                    'description' => $periode->nama,
                    'time' => $isNew ? $periode->created_at : $periode->updated_at,
                    'user' => Auth::user()->name,
                ];
            });

        // 4. PENGAJUAN SURAT
$pengajuans = PengajuanSuratPac::where('user_id', $userId)
    ->latest('updated_at')
    ->limit($limitPerCategory * 2)
    ->get()
    ->map(function ($pengajuan) {
        $isNew = $pengajuan->created_at->diffInMinutes($pengajuan->updated_at) < 1;
        $currentStatus = $pengajuan->status; // ← sudah di-decrypt oleh accessor

        // --- DEKRIP STATUS LAMA PAKAI ACCESSOR MODEL ---
        $originalStatus = $pengajuan->getOriginal('status')
            ? $pengajuan->newInstance()->forceFill(['status' => $pengajuan->getOriginal('status')])->status
            : null;

        // 1. Pengajuan baru
        if ($isNew) {
            return [
                'type' => 'pengajuan',
                'icon' => 'fa-file-signature',
                'color' => 'yellow',
                'title' => 'Pengajuan Surat Baru',
                'description' => 'No: ' . $pengajuan->no_surat . ' - ' . $pengajuan->keperluan,
                'time' => $pengajuan->created_at,
                'user' => Auth::user()->name,
            ];
        }

        // 2. Status berubah: Diterima
        if ($currentStatus === 'diterima' && $originalStatus !== 'diterima') {
            return [
                'type' => 'pengajuan',
                'icon' => 'fa-check-circle',
                'color' => 'green',
                'title' => 'Pengajuan Disetujui',
                'description' => 'No: ' . $pengajuan->no_surat . ' - Oleh Cabang',
                'time' => $pengajuan->updated_at,
                'user' => 'Admin Cabang',
            ];
        }

        // 3. Status berubah: Ditolak
        if ($currentStatus === 'ditolak' && $originalStatus !== 'ditolak') {
            return [
                'type' => 'pengajuan',
                'icon' => 'fa-times-circle',
                'color' => 'red',
                'title' => 'Pengajuan Ditolak',
                'description' => 'No: ' . $pengajuan->no_surat . ' - Oleh Cabang',
                'time' => $pengajuan->updated_at,
                'user' => 'Admin Cabang',
            ];
        }

        // 4. Diperbarui (bukan status baru)
        if ($pengajuan->updated_at->gt($pengajuan->created_at)) {
            return [
                'type' => 'pengajuan',
                'icon' => 'fa-edit',
                'color' => 'orange',
                'title' => 'Pengajuan Diperbarui',
                'description' => 'No: ' . $pengajuan->no_surat,
                'time' => $pengajuan->updated_at,
                'user' => Auth::user()->name,
            ];
        }

        return null; // skip
    })->filter(); // hapus null

        // 5. PROFIL USER
        $user = Auth::user();
        if ($user->updated_at->gt($user->created_at)) {
            $activities->push([
                'type' => 'profil',
                'icon' => 'fa-user-edit',
                'color' => 'indigo',
                'title' => 'Profil Diperbarui',
                'description' => 'Nama, email, atau password diubah',
                'time' => $user->updated_at,
                'user' => $user->name,
            ]);
        }

        // GABUNG SEMUA & SORT
        return $activities
            ->concat($anggotas)
            ->concat($surats)
            ->concat($periodes)
            ->concat($pengajuans)
            ->sortByDesc('time')
            ->take($this->activityLimit);
    }

    public function render()
    {
        return view('livewire.sekretaris-pac.dashboard');
    }
}
