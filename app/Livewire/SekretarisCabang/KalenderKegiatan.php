<?php

namespace App\Livewire\SekretarisCabang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Kalender Kegiatan')]
class KalenderKegiatan extends Component
{
    public $action = 'index'; // default view
    public $kegiatanId;       // untuk edit

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
        $this->kegiatanId = $id;
        $this->action = 'edit';
    }

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.kalender-kegiatan.create'),
            'edit' => view('livewire.sekretaris-cabang.kalender-kegiatan.edit', [
                'kegiatanId' => $this->kegiatanId
            ]),
            default => view('livewire.sekretaris-cabang.kalender-kegiatan.index'),
        };
    }
}
