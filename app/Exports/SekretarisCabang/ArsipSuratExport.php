<?php

namespace App\Exports\SekretarisCabang;

use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ArsipSuratExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $userId;
    protected $periodeId;

    public function __construct($userId, $periodeId = null)
    {
        $this->userId = $userId;
        $this->periodeId = $periodeId;
    }

    /**
     * Data yang diambil (user PAC tertentu)
     */
    public function collection()
    {
        $query = Surat::where('user_id', $this->userId);

        // Filter berdasarkan periode jika ada
        if ($this->periodeId) {
            $query->where('periode_id', $this->periodeId);
        }

        return $query->latest()->get();
    }

    /**
     * Header Excel
     */
    public function headings(): array
    {
        return [
            'No Surat',
            'Jenis Surat',
            'Tanggal',
            'Pengirim / Penerima',
            'Perihal',
            'Deskripsi',
        ];
    }

    /**
     * Mapping data tiap baris
     */
    public function map($surat): array
    {
        return [
            $surat->no_surat,
            ucfirst($surat->jenis_surat),
            $surat->tanggal?->translatedFormat('l, d F Y') ?? '-',
            $surat->pengirim_penerima ?? '-',
            $surat->perihal ?? '-',
            $surat->deskripsi ?? '-',
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'], // Blue-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Wrap text untuk kolom panjang
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("C2:F{$highestRow}")->getAlignment()->setWrapText(true);

        return [];
    }
}
