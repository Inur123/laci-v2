<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.guest')]
#[Title('Login - Laci Digital')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $showPassword = false;

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

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function login()
    {
        $this->validate();

        // Cek apakah user tidak aktif DULU sebelum attempt
        $user = User::where('email', $this->email)->first();

        if ($user && !$user->is_active) {
            // Dispatch flash message event
            $this->dispatch('flash', [
                'type' => 'error',
                'message' => 'Akun Anda belum diaktifkan. Silakan hubungi admin untuk aktivasi akun.'
            ]);
            return;
        }

        // Cek kredensial dan is_active
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'is_active' => true], $this->remember)) {
            session()->regenerate();

            $user = Auth::user();

            // Cek role
            if ($user->role === 'sekretaris_cabang') {
                session()->flash('message', 'Login berhasil! Selamat datang, ' . $user->name);
                return $this->redirect(route('cabang.dashboard'), navigate: true);
            } elseif ($user->role === 'sekretaris_pac') {
                session()->flash('message', 'Login berhasil! Selamat datang, ' . $user->name);
                return $this->redirect(route('pac.dashboard'), navigate: true);
            }

            // Default jika role tidak dikenali
            session()->flash('error', 'Anda tidak memiliki akses ke sistem ini.');
            Auth::logout();
            return $this->redirect(route('login'), navigate: true);
        }

        // Email atau password salah
        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
