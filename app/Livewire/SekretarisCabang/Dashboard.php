<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/app/Livewire/SekretarisCabang/Dashboard.php

namespace App\Livewire\SekretarisCabang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Dashboard Cabang')]
class Dashboard extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function render()
    {
        return view('livewire.sekretaris-cabang.dashboard');
    }
}
