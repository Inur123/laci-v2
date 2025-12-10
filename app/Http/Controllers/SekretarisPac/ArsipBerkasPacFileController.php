<?php

namespace App\Http\Controllers\SekretarisPac;

use App\Http\Controllers\Controller;
use App\Models\ArsipBerkasCabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipBerkasPacFileController extends Controller
{
    public function download(ArsipBerkasCabang $berkas)
    {
        abort_if(!$berkas->file_path, 404, 'File tidak ditemukan');

        $encryptedContent = Storage::disk('local')->get($berkas->file_path);
        $decryptedContent = decrypt($encryptedContent);

        $originalFilename = basename($berkas->file_path, '.enc');

        return response()->streamDownload(function () use ($decryptedContent) {
            echo $decryptedContent;
        }, $originalFilename);
    }
}
