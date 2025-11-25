<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;


#[Layout('components.layouts.home')]
#[Title('Home - LACI')]

class Home extends Component
{
    public function render()
    {
        return view('livewire.guest.home');
    }
}
