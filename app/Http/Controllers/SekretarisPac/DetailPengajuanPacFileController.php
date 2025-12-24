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
        $filename = 'Pengajuan_' . str_replace(['/', '\\'], '_', $pengajuan->no_surat) . '.' . $extension;

        // Jika PDF atau gambar, tampilkan inline di browser
        // Jika file lain (Word, Excel, PPT), otomatis download
        $disposition = (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png'])) ? 'inline' : 'attachment';

        return response($decrypted, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"'
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
        $filename = 'Pengajuan_' . str_replace(['/', '\\'], '_', $pengajuan->no_surat) . '.' . $extension;

        return response($decrypted, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
