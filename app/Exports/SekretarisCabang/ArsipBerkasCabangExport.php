<?php

namespace App\Exports\SekretarisCabang;

use App\Models\ArsipBerkasCabang;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArsipBerkasCabangExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $search;

    public function __construct($search = '')
    {
        $this->search = $search;
    }

    public function collection()
    {
        $user = Auth::user();

        $query = ArsipBerkasCabang::with(['user', 'periode']);

        // Filter berdasarkan periode aktif
        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $allData = $query->latest()->get();

        if ($this->search) {
            // Karena data terenkripsi, kita harus load semua dulu dan filter
            return $allData->filter(function ($item) {
                $searchLower = strtolower($this->search);
                return str_contains(strtolower($item->nama), $searchLower) ||
                       str_contains(strtolower($item->catatan ?? ''), $searchLower);
            });
        }

        return $allData;
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
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4299E1']
                ]
            ],
        ];
    }
}
