<?php

namespace App\Livewire\SekretarisPac;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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

    #[On('periodeChanged')]
    public function refreshData()
    {
        // Method ini akan dipanggil otomatis saat periode berubah
        // Livewire akan otomatis re-render component
    }

    #[On('pengajuanPacUpdated')]
    public function handlePengajuanUpdate()
    {
        // Realtime refresh saat ada perubahan pengajuan
        // Livewire akan otomatis re-render component
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }

        // Auto set periode pertama jika belum ada
        $user = Auth::user();
        if (!$user->periode_aktif_id) {
            $firstPeriode = Periode::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($firstPeriode) {
                $user->update(['periode_aktif_id' => $firstPeriode->id]);
            }
        }
    }

    public function loadMoreActivities()
    {
        $this->activityLimit += 15;
    }

    // === STATISTIK ANGGOTA ===
    public function getTotalAnggotaProperty()
    {
        $user = Auth::user();
        $query = Anggota::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getAnggotaLakiLakiProperty()
    {
        $user = Auth::user();
        $query = Anggota::where('user_id', $user->id)
            ->where('jenis_kelamin', 'Laki-laki');

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getAnggotaPerempuanProperty()
    {
        $user = Auth::user();
        $query = Anggota::where('user_id', $user->id)
            ->where('jenis_kelamin', 'Perempuan');

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getAnggotaBulanIniProperty()
    {
        $user = Auth::user();
        $query = Anggota::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    // === STATISTIK PERIODE ===
    public function getTotalPeriodeProperty()
    {
        return Periode::where('user_id', Auth::id())->count();
    }

    // === STATISTIK ARSIP SURAT ===
    public function getTotalSuratProperty()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getSuratMasukProperty()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->get()->where('jenis_surat', 'masuk')->count();
    }

    public function getSuratKeluarProperty()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->get()->where('jenis_surat', 'keluar')->count();
    }

    public function getSuratBulanIniProperty()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    // === STATISTIK PENGAJUAN SURAT ===
    public function getTotalPengajuanProperty()
    {
        $user = Auth::user();
        $query = PengajuanSuratPac::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getPengajuanPendingProperty()
    {
        $user = Auth::user();
        $query = PengajuanSuratPac::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->get()->filter(fn($p) => $p->status === 'pending')->count();
    }

    public function getPengajuanDiterimaProperty()
    {
        $user = Auth::user();
        $query = PengajuanSuratPac::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->get()->filter(fn($p) => $p->status === 'diterima')->count();
    }
    public function getAktivitasTerbaruProperty(): Collection
    {
        $activities = collect();
        $user = Auth::user();
        $userId = $user->id;
        $limitPerCategory = ceil($this->activityLimit / 5);

        // Query untuk filter periode
        $periodeQuery = function($query) use ($user) {
            if ($user->periode_aktif_id) {
                $query->where('periode_id', $user->periode_aktif_id);
            }
        };

        // 1. ANGGOTA
        $anggotas = Anggota::where('user_id', $userId)
            ->where($periodeQuery)
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
    ->where($periodeQuery)
    ->latest('updated_at')
    ->limit($limitPerCategory * 2)
    ->get()
    ->map(function ($surat) {
        $isNew = $surat->created_at->diffInMinutes($surat->updated_at) < 1;

        return [
            'type' => 'surat',
            'icon' => $isNew ? 'fa-folder-plus' : 'fa-folder-open',
            'color' => $isNew ? 'teal' : 'orange',
            'title' => $isNew
                ? 'Arsip Surat Ditambahkan'
                : 'Arsip Surat Diperbarui',
            'description' => 'No: ' . $surat->no_surat . ' - ' . $surat->pengirim_penerima,
            'time' => $isNew ? $surat->created_at : $surat->updated_at,
            'user' => Auth::user()->name,
        ];
    });

        // 3. PERIODE (tidak perlu filter periode karena ini aktivitas periode)
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
    ->where($periodeQuery)
    ->latest('updated_at')
    ->limit($limitPerCategory * 2)
    ->get()
    ->flatMap(function ($pengajuan) {
        $items = [];

        // 1. Pengajuan baru
        if ($pengajuan->created_at->eq($pengajuan->updated_at)) {
            $items[] = [
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
        if (
            $pengajuan->last_status_changed_at &&
            $pengajuan->status === 'diterima'
        ) {
            $items[] = [
                'type' => 'pengajuan_status',
                'icon' => 'fa-check-circle',
                'color' => 'green',
                'title' => 'Pengajuan Disetujui',
                'description' => 'No: ' . $pengajuan->no_surat . ' - Oleh Cabang',
                'time' => $pengajuan->last_status_changed_at,
                'user' => 'Admin Cabang',
            ];
            return $items; // STOP di sini, JANGAN tambahkan aktivitas update
        }

        // 3. Status berubah: Ditolak
        if (
            $pengajuan->last_status_changed_at &&
            $pengajuan->status === 'ditolak'
        ) {
            $items[] = [
                'type' => 'pengajuan_status',
                'icon' => 'fa-times-circle',
                'color' => 'red',
                'title' => 'Pengajuan Ditolak',
                'description' => 'No: ' . $pengajuan->no_surat . ' - Oleh Cabang',
                'time' => $pengajuan->last_status_changed_at,
                'user' => 'Admin Cabang',
            ];
            return $items; // STOP di sini, JANGAN tambahkan aktivitas update
        }

        // 4. Diperbarui (bukan perubahan status)
        if ($pengajuan->updated_at->gt($pengajuan->created_at)) {
            $items[] = [
                'type' => 'pengajuan',
                'icon' => 'fa-edit',
                'color' => 'orange',
                'title' => 'Pengajuan Diperbarui',
                'description' => 'No: ' . $pengajuan->no_surat,
                'time' => $pengajuan->updated_at,
                'user' => Auth::user()->name,
            ];
        }

        return $items;
    })->filter();

        // 5. PROFIL USER
        $user = Auth::user();

        // 5a. Profil diperbarui oleh user sendiri
        if (
            $user->updated_at->gt($user->created_at)
            && (
                // updated_at tidak sama dengan last_password_reset_at
                !$user->last_password_reset_at || !$user->updated_at->ne($user->last_password_reset_at)
            )
            && (
                // updated_at tidak sama dengan last_status_changed_by_admin_at
                !$user->last_status_changed_by_admin_at || !$user->updated_at->ne($user->last_status_changed_by_admin_at)
            )
        ) {
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

        // 5b. Password direset oleh admin
        if (
            $user->last_password_reset_at &&
            $user->last_password_reset_at->gt($user->created_at)
        ) {
            $activities->push([
                'type' => 'profil',
                'icon' => 'fa-key',
                'color' => 'orange',
                'title' => 'Password Direset oleh Admin',
                'description' => 'Password akun Anda direset ke default oleh Admin Cabang',
                'time' => $user->last_password_reset_at,
                'user' => 'Admin Cabang',
            ]);
        }

        // 5c. Status aktif/nonaktif oleh admin
        if (
            isset($user->last_status_changed_by_admin_at) &&
            $user->last_status_changed_by_admin_at &&
            $user->last_status_changed_by_admin_at->gt($user->created_at)
        ) {
            $activities->push([
                'type' => 'profil',
                'icon' => $user->is_active ? 'fa-toggle-on' : 'fa-toggle-off',
                'color' => $user->is_active ? 'green' : 'red',
                'title' => $user->is_active ? 'Akun Diaktifkan oleh Admin' : 'Akun Dinonaktifkan oleh Admin',
                'description' => 'Status akun Anda diubah oleh Admin Cabang',
                'time' => $user->last_status_changed_by_admin_at,
                'user' => 'Admin Cabang',
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
