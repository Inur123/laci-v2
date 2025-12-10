<?php


namespace App\Exports\SekretarisPac;

use App\Models\PengajuanSuratPac;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ArsipPengajuanSuratExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $search;
    protected $filterStatus;

    public function __construct($search = '', $filterStatus = '')
    {
        $this->search = $search;
        $this->filterStatus = $filterStatus;
    }

    public function collection()
    {
        $user = Auth::user();
        $query = PengajuanSuratPac::where('user_id', $user->id);

        // Filter berdasarkan periode aktif
        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $query = $query->latest()->get();

        return $query->filter(function($surat) {
            $matchSearch = true;
            $matchStatus = true;

            if ($this->search) {
                $s = strtolower($this->search);
                $matchSearch =
                    str_contains(strtolower($surat->no_surat ?? ''), $s) ||
                    str_contains(strtolower($surat->keperluan ?? ''), $s) ||
                    str_contains(strtolower($surat->penerima ?? ''), $s) ||
                    str_contains(strtolower($surat->deskripsi ?? ''), $s);
            }

            if ($this->filterStatus) {
                $matchStatus = $surat->status === $this->filterStatus;
            }

            return $matchSearch && $matchStatus;
        })->values();
    }

    public function headings(): array
    {
        return [
            'No Surat',
            'Penerima',
            'Tanggal',
            'Keperluan',
            'Deskripsi',
            'Status',
        ];
    }

    public function map($surat): array
    {
        return [
            $surat->no_surat,
            ucfirst($surat->penerima),
            $surat->tanggal?->translatedFormat('l, d F Y') ?? '-',
            $surat->keperluan ?? '-',
            $surat->deskripsi ?? '-',
            ucfirst($surat->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'], // Green-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("C2:F{$highestRow}")->getAlignment()->setWrapText(true);

        return [];
    }
}
