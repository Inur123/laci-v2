<?php

namespace App\Livewire\SekretarisCabang\DataAnggota;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Periode Anggota')]
class Periode extends Component
{
    public $action = 'index'; // default view
    public $periodeId;        // untuk edit

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
        $this->periodeId = $id;
        $this->action = 'edit';
    }

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.data-anggota.periode.create'),
            'edit' => view('livewire.sekretaris-cabang.data-anggota.periode.edit', [
                'periodeId' => $this->periodeId
            ]),
            default => view('livewire.sekretaris-cabang.data-anggota.periode.index'),
        };
    }
}
