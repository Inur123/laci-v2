<?php

namespace App\Http\Controllers\SekretarisPac;

use App\Http\Controllers\Controller;
use App\Models\ArsipBerkasPac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class ArsipBerkasPacFileController extends Controller
{
    public function download(ArsipBerkasPac $berkas)
    {
        abort_if(!$berkas->file_path, 404, 'File tidak ditemukan');

        $encryptedContent = Storage::disk('local')->get($berkas->file_path);
        $decryptedContent = Crypt::decryptString($encryptedContent);

        // Deteksi tipe file dari magic bytes
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($decryptedContent);

        // Map MIME type ke extension
        $extensionMap = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        ];

        $extension = $extensionMap[$mimeType] ?? 'pdf';
        $filename = 'Berkas_' . str_replace(['/', '\\'], '_', $berkas->nama) . '_' . now()->format('YmdHis') . '.' . $extension;

        return response($decryptedContent)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function viewFile($id)
    {
        $berkas = ArsipBerkasPac::findOrFail($id);

        if (!$berkas->file_path || !Storage::disk('local')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        try {
            $encryptedContent = Storage::disk('local')->get($berkas->file_path);
            $decryptedContent = Crypt::decryptString($encryptedContent);

            // Deteksi tipe file dari magic bytes
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($decryptedContent);

            // Map MIME type ke extension
            $extensionMap = [
                'application/pdf' => 'pdf',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/vnd.ms-excel' => 'xls',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                'application/vnd.ms-powerpoint' => 'ppt',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            ];

            $extension = $extensionMap[$mimeType] ?? 'pdf';
            $filename = 'Berkas_' . str_replace(['/', '\\'], '_', $berkas->nama) . '.' . $extension;

            // Jika PDF, tampilkan inline di browser
            // Jika file lain (Word, Excel, PPT), otomatis download karena browser tidak bisa tampilkan
            $disposition = ($mimeType === 'application/pdf') ? 'inline' : 'attachment';

            return response($decryptedContent, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => $disposition . '; filename="' . $filename . '"'
            ]);
        } catch (\Exception $e) {
            abort(500, 'Gagal membuka file: ' . $e->getMessage());
        }
    }
}
