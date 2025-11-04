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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Dashboard Cabang')]
class Dashboard extends Component
{
    public $activityLimit = 20; // ✅ Default 20 aktivitas

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    // ✅ Method untuk load more activities
    public function loadMoreActivities()
    {
        $this->activityLimit += 10;
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

    public function getPengajuanPacProperty()
    {
        return User::where('role', 'sekretaris_pac')
            ->where(function($q) {
                $q->where('is_active', false)
                  ->orWhereNull('email_verified_at');
            })
            ->count();
    }

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

    // ✅ Aktivitas Terbaru - Lebih banyak data dengan limit dinamis
    public function getAktivitasTerbaruProperty()
    {
        $activities = collect();

        // Ambil lebih banyak dari setiap kategori
        $limitPerCategory = ceil($this->activityLimit / 4);

        // Surat terbaru
        $surats = Surat::with('user')
            ->latest()
            ->limit($limitPerCategory)
            ->get()
            ->map(function($surat) {
                return [
                    'type' => 'surat',
                    'icon' => 'fa-envelope',
                    'color' => $surat->jenis_surat === 'masuk' ? 'green' : 'blue',
                    'title' => 'Surat ' . ucfirst($surat->jenis_surat),
                    'description' => 'No: ' . $surat->no_surat . ' dari ' . $surat->pengirim_penerima,
                    'time' => $surat->created_at,
                    'user' => $surat->user->name,
                ];
            });

        // Anggota terbaru
        $anggotas = Anggota::with('user', 'periode')
            ->latest()
            ->limit($limitPerCategory)
            ->get()
            ->map(function($anggota) {
                return [
                    'type' => 'anggota',
                    'icon' => 'fa-user-plus',
                    'color' => 'purple',
                    'title' => 'Anggota Baru Terdaftar',
                    'description' => $anggota->nama_lengkap . ' - ' . $anggota->periode->nama,
                    'time' => $anggota->created_at,
                    'user' => $anggota->user->name,
                ];
            });

        // Kegiatan terbaru
        $kegiatans = Kegiatan::with('user')
            ->latest()
            ->limit($limitPerCategory)
            ->get()
            ->map(function($kegiatan) {
                return [
                    'type' => 'kegiatan',
                    'icon' => 'fa-calendar-alt',
                    'color' => 'yellow',
                    'title' => 'Kegiatan Dibuat',
                    'description' => $kegiatan->judul . ' - ' . $kegiatan->tanggal_mulai->format('d M Y'),
                    'time' => $kegiatan->created_at,
                    'user' => $kegiatan->user->name,
                ];
            });

        // PAC baru
        $pacs = User::where('role', 'sekretaris_pac')
            ->latest()
            ->limit($limitPerCategory)
            ->get()
            ->map(function($pac) {
                return [
                    'type' => 'pac',
                    'icon' => 'fa-building',
                    'color' => 'indigo',
                    'title' => $pac->is_active && $pac->email_verified_at ? 'PAC Aktif' : 'PAC Menunggu Aktivasi',
                    'description' => $pac->name . ($pac->pac ? ' - ' . $pac->pac->nama : ''),
                    'time' => $pac->created_at,
                    'user' => 'System',
                ];
            });

        // Gabungkan dan sort by time
        return $activities
            ->concat($surats)
            ->concat($anggotas)
            ->concat($kegiatans)
            ->concat($pacs)
            ->sortByDesc('time')
            ->take($this->activityLimit); // ✅ Batasi sesuai limit
    }

    // Distribusi Anggota per Periode
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
