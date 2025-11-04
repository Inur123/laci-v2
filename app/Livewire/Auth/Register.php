<?php
// filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/app/Livewire/Auth/Register.php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.guest')]
#[Title('Register')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];

    protected $messages = [
        'name.required' => 'Nama harus diisi',
        'name.min' => 'Nama minimal 3 karakter',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Password harus diisi',
        'password.min' => 'Password minimal 6 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
    ];

    public function register()
    {
        $validated = $this->validate();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'sekretaris_pac', // Default role
        ]);

        Auth::login($user);

        session()->regenerate();

        return redirect()->route('pac.dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
