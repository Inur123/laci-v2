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

        // Deteksi tipe file dari magic bytes
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($decrypted);

        // Map MIME type ke extension
        $extensionMap = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
        ];

        $extension = $extensionMap[$mimeType] ?? 'pdf';
        $filename = 'Surat_' . str_replace(['/', '\\'], '_', $surat->no_surat) . '.' . $extension;

        // Jika PDF atau gambar, tampilkan inline di browser
        // Jika file lain (Word, Excel, PPT), otomatis download
        $disposition = (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png'])) ? 'inline' : 'attachment';

        // Kirim file ke browser
        return response($decrypted, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"'
        ]);
    }
}
