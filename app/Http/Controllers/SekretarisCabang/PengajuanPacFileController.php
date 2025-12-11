<?php

namespace App\Http\Controllers\SekretarisCabang;

use Illuminate\Http\Request;
use App\Models\PengajuanSuratPac;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class PengajuanPacFileController extends Controller
{
     public function show($id)
    {
        $surat = PengajuanSuratPac::findOrFail($id);

        if (!$surat->file) {
            abort(404, 'File tidak ditemukan');
        }

        $decrypted = $surat->decrypted_file; // Attribute dari model

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
        $filename = 'Pengajuan_' . str_replace(['/', '\\'], '_', $surat->no_surat) . '.' . $extension;

        // Jika PDF atau gambar, tampilkan inline di browser
        // Jika file lain (Word, Excel, PPT), otomatis download
        $disposition = (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png'])) ? 'inline' : 'attachment';

        return Response::make($decrypted, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"'
        ]);
    }
}
