<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Title('Edit Profile - LACI')]
class EditProfile extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;
    public $showPasswordConfirmation = false;

    public string $layout = 'components.layouts.guest';

    // Change from method to property
    public $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'nullable|string|min:6|confirmed',
    ];

    protected $messages = [
        'name.required' => 'Nama harus diisi',
        'name.max' => 'Nama maksimal 255 karakter',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
        'password.min' => 'Password minimal 6 karakter',
        'password.confirmed' => 'Konfirmasi password tidak sama',
    ];

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        // Set layout sesuai role
        $this->layout = match($user->role) {
            'sekretaris_pac' => 'components.layouts.sekretaris-pac',
            'sekretaris_cabang' => 'components.layouts.sekretaris-cabang',
            default => 'components.layouts.guest',
        };

        // Update unique rule for email with current user ID
        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function togglePasswordConfirmation()
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    public function updateProfile(): void
    {
        $this->validate();

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }



        $user->save();

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Profil berhasil diupdate!'
        ]);
    }

    public function render()
    {
        return view('livewire.auth.edit-profile')->layout($this->layout);
    }
}
