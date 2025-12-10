<?php


namespace App\Http\Controllers\Api;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KegiatanController extends Controller
{
    // GET /api/kegiatan - Semua kegiatan dengan periode aktif
    public function index()
    {
        $kegiatan = Kegiatan::with(['user:id,name', 'periode'])
            ->latest('tanggal_mulai')
            ->get();

        return [
            'data' => $kegiatan,
            'meta' => [
                'total' => $kegiatan->count(),
                'periode_tersedia' => \App\Models\Periode::orderBy('created_at', 'desc')
                    ->get()
                    ->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama])
            ]
        ];
    }

    // GET /api/kegiatan/{id} - Detail kegiatan
    public function show($id)
    {
        $kegiatan = Kegiatan::with(['user:id,name', 'periode'])->find($id);

        if (!$kegiatan) {
            return response()->json(['message' => 'Kegiatan tidak ditemukan'], 404);
        }

        return $kegiatan;
    }

    // GET /api/kegiatan/upcoming - Kegiatan mendatang
    public function upcoming()
    {
        return Kegiatan::with(['user:id,name', 'periode'])->upcoming()->get();
    }

    // GET /api/kegiatan/past - Kegiatan selesai
    public function past()
    {
        return Kegiatan::with(['user:id,name', 'periode'])->past()->get();
    }

    // GET /api/kegiatan/month/{year}/{month} - Kegiatan per bulan
    public function month($year, $month)
    {
        return Kegiatan::with(['user:id,name', 'periode'])
            ->inMonth($year, $month)
            ->get();
    }

    // GET /api/kegiatan/periode/{periodeId} - Kegiatan per periode
    public function byPeriode($periodeId)
    {
        $periode = \App\Models\Periode::find($periodeId);

        if (!$periode) {
            return response()->json(['message' => 'Periode tidak ditemukan'], 404);
        }

        $kegiatan = Kegiatan::with(['user:id,name', 'periode'])
            ->where('periode_id', $periodeId)
            ->latest('tanggal_mulai')
            ->get();

        return [
            'periode' => $periode,
            'kegiatan' => $kegiatan,
            'total' => $kegiatan->count()
        ];
    }

    // GET /api/kegiatan/stats - Statistik
    public function stats()
    {
        // Ambil periode terbaru sebagai periode aktif (asumsi)
        $periodeAktif = \App\Models\Periode::latest('created_at')->first();

        return [
            'total' => Kegiatan::count(),
            'bulan_ini' => Kegiatan::inMonth(now()->year, now()->month)->count(),
            'mendatang' => Kegiatan::upcoming()->count(),
            'selesai' => Kegiatan::past()->count(),
            'periode_terbaru' => $periodeAktif ? [
                'id' => $periodeAktif->id,
                'nama' => $periodeAktif->nama,
                'total_kegiatan' => Kegiatan::where('periode_id', $periodeAktif->id)->count()
            ] : null,
            'per_periode' => \App\Models\Periode::withCount('kegiatans')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn($p) => [
                    'id' => $p->id,
                    'nama' => $p->nama,
                    'kegiatans_count' => $p->kegiatans_count
                ])
        ];
    }
}
