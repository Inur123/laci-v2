<?php

namespace App\Livewire\SekretarisCabang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Pengajuan PAC')]
class PengajuanPac extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function render()
    {
        // path view diarahkan ke folder index
        return view('livewire.sekretaris-cabang.pengajuan-pac.index');
    }
}
