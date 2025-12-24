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
use Livewire\Attributes\On;
use App\Models\PengajuanSuratPac;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Dashboard Cabang')]
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
        // Realtime refresh saat ada pengajuan baru/update dari PAC
        // Livewire akan otomatis re-render component
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
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
        $user = Auth::user();

        if (!$user->periode_aktif_id) {
            return PengajuanSuratPac::count();
        }

        // Semua pengajuan di periode Cabang ini
        return PengajuanSuratPac::where('periode_id', $user->periode_aktif_id)->count();
    }
    public function getPengajuanPendingProperty()
    {
        // Pending dari periode PAC manapun
        return PengajuanSuratPac::where('status', 'pending')->count();
    }
    public function getPengajuanDiterimaProperty()
    {
        $user = Auth::user();
        $query = PengajuanSuratPac::where('status', 'diterima');

        // Diterima yang sudah masuk ke periode aktif Cabang
        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }
    public function getPengajuanDitolakProperty()
    {
        $user = Auth::user();
        $query = PengajuanSuratPac::where('status', 'ditolak');

        // Ditolak yang sudah masuk ke periode aktif Cabang
        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }    // === STATISTIK ANGGOTA ===
    public function getTotalAnggotaProperty()
    {
        $user = Auth::user();
        $query = Anggota::query();

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getAnggotaBulanIniProperty()
    {
        $user = Auth::user();
        $query = Anggota::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getAnggotaLakiLakiProperty()
    {
        $user = Auth::user();
        $query = Anggota::where('jenis_kelamin', 'Laki-laki');

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getAnggotaPerempuanProperty()
    {
        $user = Auth::user();
        $query = Anggota::where('jenis_kelamin', 'Perempuan');

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }
    // === STATISTIK SURAT ===
    public function getTotalSuratProperty()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
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

    public function getSuratMasukProperty()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id)
            ->where('jenis_surat', 'masuk');

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getSuratKeluarProperty()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id)
            ->where('jenis_surat', 'keluar');

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }



    // === STATISTIK KEGIATAN ===
    public function getTotalKegiatanProperty()
    {
        $user = Auth::user();
        $query = Kegiatan::query();

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    public function getKegiatanMendatangProperty()
    {
        $user = Auth::user();
        $query = Kegiatan::where('tanggal_mulai', '>', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->get();
    }

    public function getKegiatanBerlangsungProperty()
    {
        $user = Auth::user();
        $query = Kegiatan::where('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', now());
            });

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    // === AKTIVITAS TERBARU (DENGAN IKON DIPERBAIKI) ===
    public function getAktivitasTerbaruProperty()
    {
        $activities = collect();
        $limitPerCategory = ceil($this->activityLimit / 7);
        $user = Auth::user();

        // Query untuk filter periode
        $periodeQuery = function($query) use ($user) {
            if ($user->periode_aktif_id) {
                $query->where('periode_id', $user->periode_aktif_id);
            }
        };

        // 1. ANGGOTA - CREATE & UPDATE
        $anggotas = Anggota::with('user', 'periode')
            ->where($periodeQuery)
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
            ->where('user_id', $user->id)
            ->where($periodeQuery)
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
            ->where($periodeQuery)
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

        // 4. PERIODE - CREATE & UPDATE (tidak perlu filter periode karena ini menampilkan aktivitas periode)
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
        // Tampilkan berdasarkan periode_id (periode Cabang)
        $pengajuanPacs = PengajuanSuratPac::with('user')
            ->where(function($q) use ($user) {
                if ($user->periode_aktif_id) {
                    $q->where('periode_id', $user->periode_aktif_id);
                }
            })
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
        $user = Auth::user();

        $query = Periode::withCount(['anggotas' => function($q) use ($user) {
            // Count hanya anggota dari periode aktif
            if ($user->periode_aktif_id) {
                $q->where('periode_id', $user->periode_aktif_id);
            }
        }]);

        // Filter periode milik user (cabang bisa lihat semua periode dari PAC-nya)
        // Jika ingin filter hanya periode user ini, uncomment baris berikut:
        // $query->where('user_id', $user->id);

        return $query->orderBy('anggotas_count', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.sekretaris-cabang.dashboard');
    }
}
