<?php

namespace App\Livewire\Components;

use App\Models\Periode;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class GantiPeriode extends Component
{
    public $periodeAktif;
    public $showModal = false;

    public function mount()
    {
        $this->loadPeriodeAktif();
    }

    public function loadPeriodeAktif()
    {
        $user = Auth::user();
        $this->periodeAktif = $user->periode_aktif_id;

        // Auto set periode pertama jika belum ada periode aktif
        if (!$user->periode_aktif_id) {
            $firstPeriode = Periode::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($firstPeriode) {
                $user->update(['periode_aktif_id' => $firstPeriode->id]);
                $this->periodeAktif = $firstPeriode->id;
            }
        }
    }

    #[On('periodeCreated')]
    public function handlePeriodeCreated()
    {
        $this->loadPeriodeAktif();
    }

    public function gantiPeriode($periodeId)
    {
        $user = Auth::user();

        // Validasi periode milik user
        $periode = Periode::where('id', $periodeId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $user->update([
            'periode_aktif_id' => $periodeId
        ]);

        $this->periodeAktif = $periodeId;
        $this->showModal = false;

        // Dispatch event untuk refresh semua component
        $this->dispatch('periodeChanged');

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Periode berhasil diganti ke ' . $periode->nama
        ]);
    }

    public function render()
    {
        $user = Auth::user();
        $periodes = Periode::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.components.ganti-periode', [
            'periodes' => $periodes
        ]);
    }
}
