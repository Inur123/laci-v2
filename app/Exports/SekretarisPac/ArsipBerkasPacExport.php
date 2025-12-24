<?php

namespace App\Exports\SekretarisPac;

use App\Models\ArsipBerkasPac;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArsipBerkasPacExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $search;

    public function __construct($search = '')
    {
        $this->search = $search;
    }

    public function collection()
    {
        $periodeAktifId = Auth::user()->periode_aktif_id;

        $berkas = ArsipBerkasPac::with(['user', 'periode'])
            ->where('user_id', Auth::id())
            ->where('periode_id', $periodeAktifId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($this->search) {
            $berkas = $berkas->filter(function ($item) {
                $searchLower = strtolower($this->search);
                return stripos(strtolower($item->nama), $searchLower) !== false ||
                    stripos(strtolower($item->catatan ?? ''), $searchLower) !== false;
            });
        }

        return $berkas;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Berkas',
            'Tanggal',
            'Catatan',
            'Periode',
            'Dibuat Oleh',
        ];
    }

    public function map($berkas): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $berkas->nama,
            $berkas->tanggal ? $berkas->tanggal->locale('id')->translatedFormat('d F Y') : '-',
            $berkas->catatan ?? '-',
            $berkas->periode->nama ?? '-',
            $berkas->user->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
