<?php

namespace App\Exports\SekretarisPac;

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
    protected $search;
    protected $filterJenis;

    public function __construct($search = '', $filterJenis = '')
    {
        $this->search = $search;
        $this->filterJenis = $filterJenis;
    }

    /**
     * Ambil data sesuai filtered search
     */
    public function collection()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id);

        // Filter berdasarkan periode aktif
        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $query = $query->latest()->get();

        return $query->filter(function($surat) {
            $matchSearch = true;
            $matchJenis = true;

            if ($this->search) {
                $s = strtolower($this->search);
                $matchSearch =
                    str_contains(strtolower($surat->no_surat), $s) ||
                    str_contains(strtolower($surat->pengirim_penerima ?? ''), $s) ||
                    str_contains(strtolower($surat->deskripsi ?? ''), $s) ||
                    str_contains(strtolower($surat->perihal ?? ''), $s);
            }

            if ($this->filterJenis) {
                $matchJenis = $surat->jenis_surat === $this->filterJenis;
            }

            return $matchSearch && $matchJenis;
        })->values();
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
     * Mapping data baris
     */
    public function map($surat): array
    {
        return [
            $surat->no_surat,
            $surat->jenis_surat === 'masuk' ? 'Surat Masuk' : 'Surat Keluar',
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
        // Style Header A1:F1
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'], // Green-600 PAC
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Wrap text untuk kolom panjang (C s/d F)
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("C2:F{$highestRow}")->getAlignment()->setWrapText(true);

        return [];
    }
}
