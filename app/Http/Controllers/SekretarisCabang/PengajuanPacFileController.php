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

        // Tentukan mime type, misal PDF
        $mime = 'application/pdf';
        if (str_ends_with($surat->file, '.jpg') || str_ends_with($surat->file, '.jpeg')) $mime = 'image/jpeg';
        if (str_ends_with($surat->file, '.png')) $mime = 'image/png';

        return Response::make($decrypted, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="surat-'.$surat->id.'"'
        ]);
    }
}
