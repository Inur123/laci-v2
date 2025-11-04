<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/app/Livewire/SekretarisPac/Dashboard.php

namespace App\Livewire\SekretarisPac;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Dashboard PAC')]
class Dashboard extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }
    }

    public function render()
    {
        return view('livewire.sekretaris-pac.dashboard');
    }
}
