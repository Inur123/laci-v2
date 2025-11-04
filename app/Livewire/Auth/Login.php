<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/app/Livewire/Auth/Login.php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.guest')]
#[Title('Login')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'password.required' => 'Password harus diisi',
        'password.min' => 'Password minimal 6 karakter',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'sekretaris_pac') {
                return redirect()->route('pac.dashboard');
            } else {
                return redirect()->route('cabang.dashboard');
            }
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
