<?php

namespace App\Exports\SekretarisPac;

use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;
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
    protected $search;
    protected $filterPeriode;

    public function __construct($search = '', $filterPeriode = '')
    {
        $this->search = $search;
        $this->filterPeriode = $filterPeriode;
    }

    public function collection()
    {
        $user = Auth::user();
        $query = Anggota::with(['periode', 'user'])
            ->where('user_id', $user->id)
            ->latest();

        // Filter berdasarkan periode aktif jika tidak ada filter manual
        if (!$this->filterPeriode && $user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        if ($this->filterPeriode) {
            $query->where('periode_id', $this->filterPeriode);
        }

        $allData = $query->get();

        //  FILTER SEARCH MANUAL (AMAN UNTUK DATA TEREKRIPSI)
        return $allData->filter(function ($anggota) {
            if (!$this->search) return true;

            $searchLower = strtolower($this->search);

            return str_contains(strtolower($anggota->nama_lengkap ?? ''), $searchLower) ||
                   str_contains(strtolower($anggota->nik ?? ''), $searchLower) ||
                   str_contains(strtolower($anggota->nia ?? ''), $searchLower) ||
                   str_contains(strtolower($anggota->email ?? ''), $searchLower) ||
                   str_contains(strtolower($anggota->no_hp ?? ''), $searchLower) ||
                   str_contains(strtolower($anggota->tempat_lahir ?? ''), $searchLower) ||
                   str_contains(strtolower($anggota->jabatan ?? ''), $searchLower) ||
                   str_contains(strtolower($anggota->alamat_lengkap ?? ''), $searchLower);
        })->values();
    }

    //  HEADER FULL SESUAI MODEL
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

    //  MAPPING FULL SESUAI FIELD ANGGOTA
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

    //  STYLING EXCEL OTOMATIS SESUAI JUMLAH KOLOM
    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Header style
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

        // Isi wrap & rata tengah vertikal
        $sheet->getStyle("A2:{$highestColumn}{$highestRow}")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER);

        return [];
    }
}
