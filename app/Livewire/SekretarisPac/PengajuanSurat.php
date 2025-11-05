<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/app/Livewire/SekretarisPac/PengajuanSurat.php

namespace App\Livewire\SekretarisPac;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Pengajuan Surat - PAC')]
class PengajuanSurat extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }
    }

    public function render()
    {
        return view('livewire.sekretaris-pac.pengajuan-surat');
    }
}
