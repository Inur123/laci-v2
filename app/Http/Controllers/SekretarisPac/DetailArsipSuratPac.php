<?php

namespace App\Http\Controllers\SekretarisPac;

use App\Models\Surat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailArsipSuratPac extends Controller
{
    public function viewFile($id)
    {
        // Ambil surat berdasarkan ID
        $surat = Surat::findOrFail($id);

        // Pastikan ada file-nya
        if (!$surat->file) {
            abort(404, 'File tidak tersedia!');
        }

        // Dekripsi file
        $decrypted = $surat->decrypted_file;
        $filename = $surat->original_filename ?? 'file.pdf';

        // Tentukan MIME type agar bisa ditampilkan langsung di browser
        $mime = 'application/pdf';
        if (str_ends_with($filename, '.jpg') || str_ends_with($filename, '.jpeg')) $mime = 'image/jpeg';
        if (str_ends_with($filename, '.png')) $mime = 'image/png';

        // Kirim file langsung ke browser
        return response($decrypted, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
