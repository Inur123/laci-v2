<?php


namespace App\Livewire\Auth;

use App\Models\User;
use App\Rules\Turnstile;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.guest')]
#[Title('Register - Laci Digital')]
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;
    public $showPasswordConfirmation = false;
    public $captcha = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'captcha' => ['required', new Turnstile()],
        ];
    }

    protected $messages = [
        'name.required' => 'Nama harus diisi',
        'name.max' => 'Nama maksimal 255 karakter',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Password harus diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'captcha.required' => 'Mohon verifikasi captcha',
    ];

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function togglePasswordConfirmation()
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    public function register()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            if ($e->validator->errors()->has('captcha')) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => $e->validator->errors()->first('captcha')
                ]);
                $this->captcha = '';
                $this->dispatch('reset-captcha');
                return;
            }
            throw $e;
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_active' => false,
        ]);

        session()->flash('message', 'Registrasi berhasil! Silakan login dengan akun Anda.');

        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
