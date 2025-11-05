<?php

namespace App\Http\Controllers\SekretarisPac;

use Illuminate\Http\Request;
use App\Models\PengajuanSuratPac;
use App\Http\Controllers\Controller;

class DetailPengajuanPacFileController extends Controller
{
    public function viewFile($id)
    {
        $pengajuan = PengajuanSuratPac::findOrFail($id);

        if (!$pengajuan->file) {
            abort(404, 'File tidak tersedia!');
        }

        $decrypted = $pengajuan->decrypted_file;
        $filename = $pengajuan->original_filename ?? 'file.pdf';

        $mime = 'application/pdf';
        if (str_ends_with($filename, '.jpg') || str_ends_with($filename, '.jpeg')) $mime = 'image/jpeg';
        if (str_ends_with($filename, '.png')) $mime = 'image/png';

        return response($decrypted, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    // Download file (opsional, bisa arahkan ke viewFile juga)
    public function downloadFile($id)
    {
        $pengajuan = PengajuanSuratPac::findOrFail($id);

        if (!$pengajuan->file) {
            abort(404, 'File tidak tersedia!');
        }

        $decrypted = $pengajuan->decrypted_file;
        $filename = $pengajuan->original_filename ?? 'file.pdf';

        $mime = 'application/pdf';
        if (str_ends_with($filename, '.jpg') || str_ends_with($filename, '.jpeg')) $mime = 'image/jpeg';
        if (str_ends_with($filename, '.png')) $mime = 'image/png';

        return response($decrypted, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
