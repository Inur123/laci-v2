<?php

namespace App\Exports\SekretarisCabang;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DataAnggotaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = Anggota::with(['periode', 'user'])->latest();

        // Jika pilih user tertentu
        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        // Jika pilih periode (optional)
        if ($this->periodeId) {
            $query->where('periode_id', $this->periodeId);
        }

        // Jika userId null => semua user
        // Jika periodeId null => semua periode
        return $query->get();
    }


    //  HEADER EXCEL (SESUAI MODEL)
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'NIA',
            'Email',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Jenis Kelamin',
            'Alamat Lengkap',
            'No HP',
            'Hobi',
            'Jabatan',
            'No RFID',
            'Periode',
            'Dibuat Oleh',
        ];
    }

    //  DATA MAPPING (SESUAI FIELD & DEKRIPSI OTOMATIS)
    public function map($anggota): array
    {
        return [
            $anggota->nama_lengkap ?? '-',
            $anggota->nik ?? '-',
            $anggota->nia ?? '-',
            $anggota->email ?? '-',
            $anggota->tempat_lahir ?? '-',
            $anggota->tanggal_lahir
                ? $anggota->tanggal_lahir->format('d-m-Y')
                : '-',
            $anggota->umur ?? '-',
            $anggota->jenis_kelamin ?? '-',
            $anggota->alamat_lengkap ?? '-',
            $anggota->no_hp ?? '-',
            $anggota->hobi ?? '-',
            $anggota->jabatan ?? '-',
            $anggota->no_rfid ?? '-',
            $anggota->periode->nama ?? '-',
            $anggota->user->name ?? '-',
        ];
    }

    //  STYLING HEADER EXCEL
    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Header Style
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Isi rata kiri + wrapping
        $sheet->getStyle("A2:{$highestColumn}{$highestRow}")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER);

        return [];
    }
}
