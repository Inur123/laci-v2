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

        $originalFilename = basename($berkas->file_path, '.enc');

        return response()->streamDownload(function () use ($decryptedContent) {
            echo $decryptedContent;
        }, $originalFilename);
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

            $filename = 'Berkas_' . str_replace(['/', '\\'], '_', $berkas->nama) . '.pdf';
            $mime = 'application/pdf';

            return response($decryptedContent, 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        } catch (\Exception $e) {
            abort(500, 'Gagal membuka file: ' . $e->getMessage());
        }
    }
}
