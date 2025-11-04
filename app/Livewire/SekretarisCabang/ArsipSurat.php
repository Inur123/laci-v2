<?php
namespace App\Livewire\SekretarisCabang;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Arsip Surat')]
class ArsipSurat extends Component
{
    public $action = 'index'; // default view

    public $arsipId; // untuk edit

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
        $this->arsipId = $id;
        $this->action = 'edit';
    }

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.arsip-surat.create'),
            'edit' => view('livewire.sekretaris-cabang.arsip-surat.edit', [
                'arsipId' => $this->arsipId
            ]),
            default => view('livewire.sekretaris-cabang.arsip-surat.index'),
        };
    }
}
