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
    public $new_email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;
    public $showPasswordConfirmation = false;

    public int $resendCooldown = 0; // <-- Tambahan: detik tersisa

    public string $layout = 'components.layouts.guest';

    public $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:6|confirmed',
    ];

    protected $messages = [
        'name.required' => 'Nama harus diisi',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'password.min' => 'Password minimal 6 karakter',
        'password.confirmed' => 'Konfirmasi password tidak sama',
    ];

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->new_email = $user->email;

        // Restore cooldown dari session jika ada (survive refresh)
        $this->resendCooldown = (int) session('verification_resend_cooldown', 0);

        $this->layout = match ($user->role) {
            'sekretaris_pac' => 'components.layouts.sekretaris-pac',
            'sekretaris_cabang' => 'components.layouts.sekretaris-cabang',
            default => 'components.layouts.guest',
        };

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
        $oldEmail = $user->email;

        $user->name = $this->name;

        if ($this->new_email !== $oldEmail) {
            $user->new_email = $this->new_email;
            $user->sendEmailVerificationNotification();

            $this->dispatch('flash', [
                'type' => 'warning',
                'message' => 'Email baru disimpan sementara. Silakan verifikasi email baru untuk mengaktifkannya!'
            ]);
        }

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Profil berhasil diperbarui!'
        ]);
    }

    public function resendVerification(): void
    {
        if ($this->resendCooldown > 0) {
            $this->dispatch('flash', [
                'type' => 'info',
                'message' => "Harap tunggu {$this->resendCooldown} detik sebelum mengirim ulang."
            ]);
            return;
        }

        $user = Auth::user();
        $emailToVerify = $user->new_email ?? $user->email;

        // Set cooldown 30 detik
        $this->resendCooldown = 30;
        session(['verification_resend_cooldown' => 30]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => "Link verifikasi telah dikirim ulang ke {$emailToVerify}!"
        ]);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();
    }

    // Dipanggil oleh Alpine setiap detik
    public function decrementCooldown(): void
    {
        if ($this->resendCooldown > 0) {
            $this->resendCooldown--;
            session(['verification_resend_cooldown' => $this->resendCooldown]);

            if ($this->resendCooldown <= 0) {
                session()->forget('verification_resend_cooldown');
            }
        }
    }

    public function render()
    {
        return view('livewire.auth.edit-profile')->layout($this->layout);
    }
}
