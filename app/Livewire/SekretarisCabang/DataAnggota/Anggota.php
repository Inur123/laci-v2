<?php

namespace App\Livewire\SekretarisCabang\DataAnggota;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Data Anggota')]
class Anggota extends Component
{
    public $action = 'index'; // default view
    public $anggotaId;        // untuk edit, bisa kosong dulu

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function create()
    {
        $this->action = 'create';
    }

    public function edit($id)
    {
        $this->anggotaId = $id;
        $this->action = 'edit';
    }

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.data-anggota.create'),
            'edit' => view('livewire.sekretaris-cabang.data-anggota.edit', [
                'anggotaId' => $this->anggotaId
            ]),
            default => view('livewire.sekretaris-cabang.data-anggota.index'),
        };
    }
}
