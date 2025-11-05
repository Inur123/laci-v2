<?php

namespace App\Http\Controllers\SekretarisCabang;

use App\Http\Controllers\Controller;
use App\Models\Surat;

class DetailArsipSurat extends Controller
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

        // Tentukan MIME type agar bisa ditampilkan langsung
        $mime = 'application/pdf';
        if (str_ends_with($filename, '.jpg') || str_ends_with($filename, '.jpeg')) $mime = 'image/jpeg';
        if (str_ends_with($filename, '.png')) $mime = 'image/png';

        // Tampilkan file langsung di browser
        return response($decrypted, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
