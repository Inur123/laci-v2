<?php

namespace App\Http\Controllers\SekretarisCabang;

use App\Http\Controllers\Controller;
use App\Models\ArsipBerkasPac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ArsipBerkasPacFileController extends Controller
{
    public function download($id)
    {
        // Validasi user adalah sekretaris cabang
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }

        $berkas = ArsipBerkasPac::findOrFail($id);

        // Cek file ada
        if (!$berkas->file_path || !Storage::disk('local')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        try {
            // Ambil file terenkripsi
            $encryptedContent = Storage::disk('local')->get($berkas->file_path);

            // Dekripsi
            $decryptedContent = Crypt::decryptString($encryptedContent);

            // Tentukan extension dari nama file asli
            $extension = 'pdf'; // default

            // Generate nama file untuk download
            $filename = 'Berkas_' . str_replace(['/', '\\'], '_', $berkas->nama) . '_' . now()->format('YmdHis') . '.' . $extension;

            // Return file untuk didownload
            return response($decryptedContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            abort(500, 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }
}
