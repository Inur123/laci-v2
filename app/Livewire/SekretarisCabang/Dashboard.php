<?php

namespace App\Livewire\SekretarisCabang;

use App\Models\User;
use App\Models\Surat;
use App\Models\Anggota;
use App\Models\Periode;
use Livewire\Component;
use App\Models\Kegiatan;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PengajuanSuratPac;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Dashboard Cabang')]
class Dashboard extends Component
{
    public $activityLimit = 30;

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function loadMoreActivities()
    {
        $this->activityLimit += 15;
    }

    public function getTotalPacActiveProperty()
    {
        return User::where('role', 'sekretaris_pac')
            ->where('is_active', true)
            ->whereNotNull('email_verified_at')
            ->count();
    }

    public function getTotalPacVerifiedProperty()
    {
        return User::where('role', 'sekretaris_pac')
            ->whereNotNull('email_verified_at')
            ->count();
    }

    public function getTotalPacUnverifiedProperty()
    {
        return User::where('role', 'sekretaris_pac')
            ->whereNull('email_verified_at')
            ->count();
    }

    public function getTotalPacInactiveProperty()
    {
        return User::where('role', 'sekretaris_pac')
            ->where('is_active', false)
            ->count();
    }

    public function getTotalPengajuanPacProperty()
    {
        return PengajuanSuratPac::count();
    }
    public function getPengajuanPendingProperty()
    {
        return PengajuanSuratPac::where('status', 'pending')->count();
    }
    public function getPengajuanDiterimaProperty()
    {
        return PengajuanSuratPac::where('status', 'diterima')->count();
    }
    public function getPengajuanDitolakProperty()
    {
        return PengajuanSuratPac::where('status', 'ditolak')->count();
    }

    // === STATISTIK ANGGOTA ===
    public function getTotalAnggotaProperty()
    {
        return Anggota::count();
    }

    public function getAnggotaBulanIniProperty()
    {
        return Anggota::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function getAnggotaLakiLakiProperty()
    {
        return Anggota::where('jenis_kelamin', 'Laki-laki')->count();
    }

    public function getAnggotaPerempuanProperty()
    {
        return Anggota::where('jenis_kelamin', 'Perempuan')->count();
    }
    // === STATISTIK SURAT ===
    public function getTotalSuratProperty()
    {
        return Surat::where('user_id', Auth::user()->id)->count();
    }

    public function getSuratBulanIniProperty()
    {
        return Surat::where('user_id', Auth::user()->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function getSuratMasukProperty()
    {
        return Surat::where('user_id', Auth::user()->id)
            ->where('jenis_surat', 'masuk')
            ->count();
    }

    public function getSuratKeluarProperty()
    {
        return Surat::where('user_id', Auth::user()->id)
            ->where('jenis_surat', 'keluar')
            ->count();
    }



    // === STATISTIK KEGIATAN ===
    public function getTotalKegiatanProperty()
    {
        return Kegiatan::count();
    }

    public function getKegiatanMendatangProperty()
    {
        return Kegiatan::where('tanggal_mulai', '>', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3)
            ->get();
    }

    public function getKegiatanBerlangsungProperty()
    {
        return Kegiatan::where('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', now());
            })
            ->count();
    }

    // === AKTIVITAS TERBARU (DENGAN IKON DIPERBAIKI) ===
    public function getAktivitasTerbaruProperty()
    {
        $activities = collect();
        $limitPerCategory = ceil($this->activityLimit / 7);

        // 1. ANGGOTA - CREATE & UPDATE
        $anggotas = Anggota::with('user', 'periode')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function ($anggota) {
                $isNew = $anggota->created_at->diffInMinutes($anggota->updated_at) < 1;

                return [
                    'type' => 'anggota',
                    'icon' => $isNew ? 'fas fa-user-plus' : 'fas fa-user-pen',
                    'color' => $isNew ? 'emerald' : 'sky',
                    'title' => $isNew ? 'Anggota Baru Ditambahkan' : 'Anggota Diperbarui',
                    'description' => $anggota->nama_lengkap . ' - ' . $anggota->periode->nama,
                    'time' => $isNew ? $anggota->created_at : $anggota->updated_at,
                    'user' => $anggota->user->name,
                ];
            });

        // 2. SURAT - CREATE & UPDATE
        $surats = Surat::with('user')
            ->where('user_id', Auth::id())
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function ($surat) {
                $isNew = $surat->created_at->eq($surat->updated_at);

                return [
                    'no_surat' => $surat->no_surat,
                    'type' => 'surat',
                    'icon' => $isNew ? 'fas fa-folder-plus' : 'fas fa-edit',
                    'color' => $isNew ? 'teal' : 'amber',
                    'title' => $isNew ? 'Surat Baru Diarsipkan' : 'Surat Diperbarui',
                    'description' => 'No: ' . $surat->no_surat . ' - ' . $surat->pengirim_penerima,
                    'time' => $isNew ? $surat->created_at : $surat->updated_at,
                    'user' => $surat->user->name,
                ];
            })
            ->keyBy('no_surat')
            ->values();

        // 3. KEGIATAN - CREATE & UPDATE
        $kegiatans = Kegiatan::with('user')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function ($kegiatan) {
                $isNew = $kegiatan->created_at->diffInMinutes($kegiatan->updated_at) < 1;

                return [
                    'type' => 'kegiatan',
                    'icon' => $isNew ? 'fas fa-calendar-plus' : 'fas fa-calendar-pen',
                    'color' => $isNew ? 'lime' : 'orange',
                    'title' => $isNew ? 'Kegiatan Baru Dibuat' : 'Kegiatan Diperbarui',
                    'description' => $kegiatan->judul . ' - ' . $kegiatan->tanggal_mulai->format('d M Y'),
                    'time' => $isNew ? $kegiatan->created_at : $kegiatan->updated_at,
                    'user' => $kegiatan->user->name,
                ];
            });

        // 4. PERIODE - CREATE & UPDATE
        $periodes = Periode::with('user')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function ($periode) {
                $isNew = $periode->created_at->diffInMinutes($periode->updated_at) < 1;

                return [
                    'type' => 'periode',
                    'icon' => $isNew ? 'fas fa-clock' : 'fas fa-history',
                    'color' => $isNew ? 'pink' : 'indigo',
                    'title' => $isNew ? 'Periode Baru Dibuat' : 'Periode Diperbarui',
                    'description' => $periode->nama . ($isNew ? '' : ' - Data diperbarui'),
                    'time' => $isNew ? $periode->created_at : $periode->updated_at,
                    'user' => $periode->user->name,
                ];
            });

        // 5. PENGAJUAN SURAT PAC
        $pengajuanPacs = PengajuanSuratPac::with('user')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->flatMap(function ($pengajuan) {
                $items = [];

                // Pengajuan baru
                if ($pengajuan->created_at->eq($pengajuan->updated_at)) {
                    $items[] = [
                        'type' => 'pengajuan_pac',
                        'icon' => 'fas fa-file-signature',
                        'color' => 'teal',
                        'title' => 'Pengajuan Surat Baru',
                        'description' => 'No: ' . $pengajuan->no_surat . ' - ' . $pengajuan->keperluan,
                        'time' => $pengajuan->created_at,
                        'user' => $pengajuan->user->name,
                    ];
                }
                // Update biasa (bukan status)
                elseif ($pengajuan->updated_at->gt($pengajuan->created_at) && !$pengajuan->last_status_changed_at) {
                    $items[] = [
                        'type' => 'pengajuan_pac',
                        'icon' => 'fas fa-edit',
                        'color' => 'amber',
                        'title' => 'Pengajuan Diperbarui',
                        'description' => 'No: ' . $pengajuan->no_surat . ' - Data diubah',
                        'time' => $pengajuan->updated_at,
                        'user' => $pengajuan->user->name,
                    ];
                }

                // Status berubah (approve/reject)
                if ($pengajuan->last_status_changed_at) {
                    if ($pengajuan->status === 'diterima') {
                        $items[] = [
                            'type' => 'pengajuan_pac',
                            'icon' => 'fas fa-check-circle',
                            'color' => 'green',
                            'title' => 'Pengajuan Disetujui',
                            'description' => 'No: ' . $pengajuan->no_surat,
                            'time' => $pengajuan->last_status_changed_at,
                            'user' => 'Admin Cabang',
                        ];
                    } elseif ($pengajuan->status === 'ditolak') {
                        $items[] = [
                            'type' => 'pengajuan_pac',
                            'icon' => 'fas fa-times-circle',
                            'color' => 'red',
                            'title' => 'Pengajuan Ditolak',
                            'description' => 'No: ' . $pengajuan->no_surat,
                            'time' => $pengajuan->last_status_changed_at,
                            'user' => 'Admin Cabang',
                        ];
                    }
                }

                return $items;
            });

        // 6. USER PAC - RESET PASSWORD & STATUS
        $users = User::where('role', 'sekretaris_pac')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->flatMap(function ($user) {
                $activities = [];

                // Reset password
                if ($user->last_password_reset_at && $user->last_password_reset_at->gt($user->created_at)) {
                    $activities[] = [
                        'type' => 'user_pac',
                        'icon' => 'fas fa-key',
                        'color' => 'amber',
                        'title' => 'Password Direset',
                        'description' => $user->name . ' (' . $user->email . ')',
                        'time' => $user->last_password_reset_at,
                        'user' => 'Admin Cabang',
                    ];
                }

                // Status aktif/nonaktif
                if ($user->last_status_changed_by_admin_at && $user->last_status_changed_by_admin_at->gt($user->created_at)) {
                    $activities[] = [
                        'type' => 'user_pac',
                        'icon' => $user->is_active ? 'fas fa-toggle-on' : 'fas fa-toggle-off',
                        'color' => $user->is_active ? 'green' : 'red',
                        'title' => $user->is_active ? 'User Diaktifkan' : 'User Dinonaktifkan',
                        'description' => $user->name . ' (' . $user->email . ')',
                        'time' => $user->last_status_changed_by_admin_at,
                        'user' => 'Admin Cabang',
                    ];
                }

                return $activities;
            });

        return $activities
            ->concat($anggotas)
            ->concat($surats)
            ->concat($kegiatans)
            ->concat($periodes)
            ->concat($pengajuanPacs)
            ->concat($users)
            ->sortByDesc('time')
            ->take($this->activityLimit);
    }

    // === DISTRIBUSI PERIODE ===
    public function getDistribusiPeriodeProperty()
    {
        return Periode::withCount('anggotas')
            ->orderBy('anggotas_count', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.sekretaris-cabang.dashboard');
    }
}
