<?php


namespace App\Http\Controllers\Api;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KegiatanController extends Controller
{
    // GET /api/kegiatan - Semua kegiatan
    public function index()
    {
        return Kegiatan::with('user:id,name')->latest('tanggal_mulai')->get();
    }

    // GET /api/kegiatan/{id} - Detail kegiatan
    public function show($id)
    {
        $kegiatan = Kegiatan::with('user:id,name')->find($id);

        if (!$kegiatan) {
            return response()->json(['message' => 'Kegiatan tidak ditemukan'], 404);
        }

        return $kegiatan;
    }

    // GET /api/kegiatan/upcoming - Kegiatan mendatang
    public function upcoming()
    {
        return Kegiatan::with('user:id,name')->upcoming()->get();
    }

    // GET /api/kegiatan/past - Kegiatan selesai
    public function past()
    {
        return Kegiatan::with('user:id,name')->past()->get();
    }

    // GET /api/kegiatan/month/{year}/{month} - Kegiatan per bulan
    public function month($year, $month)
    {
        return Kegiatan::with('user:id,name')
            ->inMonth($year, $month)
            ->get();
    }

    // GET /api/kegiatan/stats - Statistik
    public function stats()
    {
        return [
            'total' => Kegiatan::count(),
            'bulan_ini' => Kegiatan::inMonth(now()->year, now()->month)->count(),
            'mendatang' => Kegiatan::upcoming()->count(),
            'selesai' => Kegiatan::past()->count(),
        ];
    }
}
