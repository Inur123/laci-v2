<?php


namespace App\Livewire\SekretarisCabang;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Surat;
use App\Models\Kegiatan;
use App\Models\Periode;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
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

    // Statistik PAC
    public function getTotalPacProperty()
    {
        return User::where('role', 'sekretaris_pac')
            ->where('is_active', true)
            ->whereNotNull('email_verified_at')
            ->count();
    }

    public function getPacBulanIniProperty()
    {
        return User::where('role', 'sekretaris_pac')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    // ✅ HAPUS getPengajuanPacProperty() - Karena bukan untuk user registration

    // Statistik Anggota
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
        return Anggota::all()->filter(function($anggota) {
            return $anggota->jenis_kelamin === 'Laki-laki';
        })->count();
    }

    public function getAnggotaPerempuanProperty()
    {
        return Anggota::all()->filter(function($anggota) {
            return $anggota->jenis_kelamin === 'Perempuan';
        })->count();
    }

    // Statistik Surat
    public function getTotalSuratProperty()
    {
        return Surat::count();
    }

    public function getSuratBulanIniProperty()
    {
        return Surat::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function getSuratMasukProperty()
    {
        return Surat::all()->filter(function($surat) {
            return $surat->jenis_surat === 'masuk';
        })->count();
    }

    public function getSuratKeluarProperty()
    {
        return Surat::all()->filter(function($surat) {
            return $surat->jenis_surat === 'keluar';
        })->count();
    }

    // Statistik Kegiatan
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
            ->where(function($q) {
                $q->whereNull('tanggal_selesai')
                  ->orWhere('tanggal_selesai', '>=', now());
            })
            ->count();
    }

    // Aktivitas Terbaru
    public function getAktivitasTerbaruProperty()
    {
        $activities = collect();
        $limitPerCategory = ceil($this->activityLimit / 5); // ✅ Dibagi 5 (bukan 6)

        // 1. USER PAC - Toggle & Reset Password
        $userPacs = User::where('role', 'sekretaris_pac')
            ->latest('updated_at')
            ->limit($limitPerCategory)
            ->get()
            ->map(function($user) {
                $isNew = $user->created_at->diffInMinutes($user->updated_at) < 1;

                if ($isNew) {
                    if ($user->is_active && $user->email_verified_at) {
                        $title = '✅ User PAC Baru Aktif';
                        $color = 'green';
                        $icon = 'fa-user-shield';
                    } elseif (!$user->email_verified_at) {
                        $title = '⏳ User PAC Menunggu Verifikasi';
                        $color = 'yellow';
                        $icon = 'fa-user-clock';
                    } else {
                        $title = '🔒 User PAC Baru (Nonaktif)';
                        $color = 'red';
                        $icon = 'fa-user-slash';
                    }
                    $description = $user->name . ' - ' . $user->email;
                } else {
                    if ($user->is_active) {
                        $title = '✅ User PAC Diaktifkan';
                        $color = 'green';
                        $icon = 'fa-toggle-on';
                    } else {
                        $title = '🔒 User PAC Dinonaktifkan';
                        $color = 'red';
                        $icon = 'fa-toggle-off';
                    }
                    $description = $user->name . ' - Status diubah';
                }

                return [
                    'type' => 'user_pac',
                    'icon' => $icon,
                    'color' => $color,
                    'title' => $title,
                    'description' => $description,
                    'time' => $user->updated_at,
                    'user' => 'Admin Cabang',
                ];
            });

        // 2. ANGGOTA - CREATE & UPDATE
        $anggotas = Anggota::with('user', 'periode')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function($anggota) {
                $isNew = $anggota->created_at->diffInMinutes($anggota->updated_at) < 1;

                if ($isNew) {
                    return [
                        'type' => 'anggota',
                        'icon' => 'fa-user-plus',
                        'color' => 'purple',
                        'title' => '👤 Anggota Baru Ditambahkan',
                        'description' => $anggota->nama_lengkap . ' - ' . $anggota->periode->nama,
                        'time' => $anggota->created_at,
                        'user' => $anggota->user->name,
                    ];
                } else {
                    return [
                        'type' => 'anggota',
                        'icon' => 'fa-user-edit',
                        'color' => 'blue',
                        'title' => '✏️ Anggota Diupdate',
                        'description' => $anggota->nama_lengkap . ' - Data diperbarui',
                        'time' => $anggota->updated_at,
                        'user' => $anggota->user->name,
                    ];
                }
            });

        // 3. SURAT - CREATE & UPDATE
        $surats = Surat::with('user')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function($surat) {
                $isNew = $surat->created_at->diffInMinutes($surat->updated_at) < 1;

                if ($isNew) {
                    return [
                        'type' => 'surat',
                        'icon' => 'fa-envelope',
                        'color' => $surat->jenis_surat === 'masuk' ? 'green' : 'blue',
                        'title' => '📧 Surat ' . ucfirst($surat->jenis_surat) . ' Baru',
                        'description' => 'No: ' . $surat->no_surat . ' dari ' . $surat->pengirim_penerima,
                        'time' => $surat->created_at,
                        'user' => $surat->user->name,
                    ];
                } else {
                    return [
                        'type' => 'surat',
                        'icon' => 'fa-envelope-open-text',
                        'color' => 'orange',
                        'title' => '✏️ Surat Diupdate',
                        'description' => 'No: ' . $surat->no_surat . ' - Data diperbarui',
                        'time' => $surat->updated_at,
                        'user' => $surat->user->name,
                    ];
                }
            });

        // 4. KEGIATAN - CREATE & UPDATE
        $kegiatans = Kegiatan::with('user')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function($kegiatan) {
                $isNew = $kegiatan->created_at->diffInMinutes($kegiatan->updated_at) < 1;

                if ($isNew) {
                    return [
                        'type' => 'kegiatan',
                        'icon' => 'fa-calendar-plus',
                        'color' => 'yellow',
                        'title' => '📅 Kegiatan Baru',
                        'description' => $kegiatan->judul . ' - ' . $kegiatan->tanggal_mulai->format('d M Y'),
                        'time' => $kegiatan->created_at,
                        'user' => $kegiatan->user->name,
                    ];
                } else {
                    return [
                        'type' => 'kegiatan',
                        'icon' => 'fa-calendar-edit',
                        'color' => 'orange',
                        'title' => '✏️ Kegiatan Diupdate',
                        'description' => $kegiatan->judul . ' - Data diperbarui',
                        'time' => $kegiatan->updated_at,
                        'user' => $kegiatan->user->name,
                    ];
                }
            });

        // 5. PERIODE - CREATE & UPDATE
        $periodes = Periode::with('user')
            ->latest('updated_at')
            ->limit($limitPerCategory * 2)
            ->get()
            ->map(function($periode) {
                $isNew = $periode->created_at->diffInMinutes($periode->updated_at) < 1;

                if ($isNew) {
                    return [
                        'type' => 'periode',
                        'icon' => 'fa-clock',
                        'color' => 'pink',
                        'title' => '🕐 Periode Baru',
                        'description' => $periode->nama,
                        'time' => $periode->created_at,
                        'user' => $periode->user->name,
                    ];
                } else {
                    return [
                        'type' => 'periode',
                        'icon' => 'fa-history',
                        'color' => 'orange',
                        'title' => '✏️ Periode Diupdate',
                        'description' => $periode->nama . ' - Data diperbarui',
                        'time' => $periode->updated_at,
                        'user' => $periode->user->name,
                    ];
                }
            });

        return $activities
            ->concat($userPacs)
            ->concat($anggotas)
            ->concat($surats)
            ->concat($kegiatans)
            ->concat($periodes)
            ->sortByDesc('time')
            ->take($this->activityLimit);
    }

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
