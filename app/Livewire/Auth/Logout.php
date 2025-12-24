<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function logout()
    {
        $userName = Auth::user()->name;

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        session()->flash('message', 'Logout berhasil! Sampai jumpa, ' . $userName . '.');

        // Tetap SPA-style dengan wire:navigate
        // TAPI pastikan Turnstile script sudah di-fix (lihat artifact turnstile_blade_final)
        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
