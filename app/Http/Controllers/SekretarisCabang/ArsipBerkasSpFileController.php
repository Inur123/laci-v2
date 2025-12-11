<?php

namespace App\Http\Controllers\SekretarisCabang;

use App\Http\Controllers\Controller;
use App\Models\ArsipBerkasSp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ArsipBerkasSpFileController extends Controller
{
    public function download($id)
    {
        // Validasi user adalah sekretaris cabang
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }

        $berkas = ArsipBerkasSp::findOrFail($id);

        // Cek file ada
        if (!$berkas->file_path || !Storage::disk('local')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        try {
            // Ambil file terenkripsi
            $encryptedContent = Storage::disk('local')->get($berkas->file_path);

            // Dekripsi
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

            // Generate nama file untuk download
            $filename = 'Berkas_' . str_replace(['/', '\\'], '_', $berkas->nama) . '_' . now()->format('YmdHis') . '.' . $extension;

            // Return file untuk didownload
            return response($decryptedContent)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            abort(500, 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }

    public function viewFile($id)
    {
        // Validasi user adalah sekretaris cabang
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }

        $berkas = ArsipBerkasSp::findOrFail($id);

        // Cek file ada
        if (!$berkas->file_path || !Storage::disk('local')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        try {
            // Ambil file terenkripsi
            $encryptedContent = Storage::disk('local')->get($berkas->file_path);

            // Dekripsi
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

            // Tampilkan file di browser (PDF inline, lainnya download)
            return response($decryptedContent, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => $disposition . '; filename="' . $filename . '"'
            ]);

        } catch (\Exception $e) {
            abort(500, 'Gagal membuka file: ' . $e->getMessage());
        }
    }
}
