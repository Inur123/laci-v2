<?php

namespace App\Exports\SekretarisCabang;

use App\Models\PengajuanSuratPac;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PengajuanSuratPacExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $userId;
    protected $periodeId;

    public function __construct($userId = null, $periodeId = null)
    {
        $this->userId = $userId;
        $this->periodeId = $periodeId;
    }

    public function collection()
    {
        // Tampilkan berdasarkan periode_id_pac (periode PAC saat mengirim)
        $query = PengajuanSuratPac::with('user')->latest();

        if ($this->userId) {
            $query->where('user_id', $this->userId);

            // Filter berdasarkan periode_id_pac jika ada
            if ($this->periodeId) {
                $query->where('periode_id_pac', $this->periodeId);
            }
        }

        return $query->get();
    }    public function headings(): array
    {
        return [
            'No Surat',
            'Keperluan',
            'Tanggal',
            'Penerima',
            'Status',
            'Pengaju',
            'Email Pengaju',
        ];
    }

    public function map($pengajuan): array
    {
        return [
            $pengajuan->no_surat,
            $pengajuan->keperluan ?? '-',
            $pengajuan->tanggal?->translatedFormat('l, d F Y') ?? '-',
            $pengajuan->penerima ?? '-',
            ucfirst($pengajuan->status),
            $pengajuan->user->name ?? '-',
            $pengajuan->user->email ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("C2:G{$highestRow}")->getAlignment()->setWrapText(true);

        return [];
    }
}
