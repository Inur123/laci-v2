<?php

namespace App\Exports\SekretarisCabang;

use App\Models\ArsipBerkasSp;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArsipBerkasSpExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $search;

    public function __construct($search = '')
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = ArsipBerkasSp::with(['user', 'periode'])
            ->byPeriodeUser()
            ->latest();

        if ($this->search) {
            // Karena data terenkripsi, kita harus load semua dulu
            $allData = $query->get();
            return $allData->filter(function ($item) {
                return stripos($item->nama, $this->search) !== false ||
                       stripos($item->catatan ?? '', $this->search) !== false;
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Berkas',
            'Periode',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Catatan',
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
            $berkas->periode->nama ?? '-',
            $berkas->tanggal_mulai?->locale('id')->translatedFormat('d F Y') ?? '-',
            $berkas->tanggal_berakhir?->locale('id')->translatedFormat('d F Y') ?? '-',
            $berkas->catatan ?? '-',
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
