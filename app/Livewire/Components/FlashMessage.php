<?php

namespace App\Livewire\Components;

use Livewire\Component;

class FlashMessage extends Component
{
    public $show = false;
    public $message = '';
    public $type = 'success';
    public $flashId;

    protected $listeners = ['flash' => 'showFlash'];

    public function mount()
    {
        $this->flashId = uniqid('flash-');

        if (session()->has('message')) {
            $this->message = session('message');
            $this->type = 'success';
            $this->show = true;
        } elseif (session()->has('error')) {
            $this->message = session('error');
            $this->type = 'error';
            $this->show = true;
        } elseif (session()->has('warning')) {
            $this->message = session('warning');
            $this->type = 'warning';
            $this->show = true;
        } elseif (session()->has('info')) {
            $this->message = session('info');
            $this->type = 'info';
            $this->show = true;
        }
    }

    public function showFlash($data)
    {
        // PENTING: Generate unique ID BARU setiap kali
        $this->flashId = uniqid('flash-' . time() . '-');
        $this->message = $data['message'];
        $this->type = $data['type'] ?? 'success';
        $this->show = true;

        // Force re-render dengan dispatch ke browser
        $this->dispatch('flash-updated');
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.components.flash-message');
    }
}
