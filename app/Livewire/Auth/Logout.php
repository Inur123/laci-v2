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
        request()->session()->regenerateToken();

        session()->flash('message', 'Logout berhasil! Sampai jumpa, ' . $userName . '.');

        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
