<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Anggota;
use App\Models\PengajuanSuratPac;

#[Layout('components.layouts.home')]
#[Title('Home - LACI')]
class Home extends Component
{
    public function render()
    {
        $anggotaTerdaftar = Anggota::query()
            ->join('users', 'users.id', '=', 'anggotas.user_id')
            ->whereColumn('anggotas.periode_id', 'users.periode_aktif_id')
            ->count();

        $suratDiterima = PengajuanSuratPac::query()
            ->select('pengajuan_surat_pac.*')
            ->join('users', 'users.id', '=', 'pengajuan_surat_pac.user_id')
            ->whereColumn('pengajuan_surat_pac.periode_id', 'users.periode_aktif_id')
            ->get() // status terenkripsi, jadi filternya di PHP
            ->filter(fn ($s) => $s->status === 'diterima')
            ->count();

        return view('livewire.guest.home', [
            'anggotaTerdaftar' => $anggotaTerdaftar,
            'suratDiterima' => $suratDiterima,
        ]);
    }
}
