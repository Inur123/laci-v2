<?php

namespace App\Livewire\SekretarisCabang;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Data User PAC')]
class DataUserPac extends Component
{
    use WithPagination;

    public $action = 'index';
    public $userId;
    public $search = '';
    public $filterStatus = '';

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    // Computed Properties
    #[Computed]
    public function totalUserPac()
    {
        return User::where('role', 'sekretaris_pac')->count();
    }

    #[Computed]
    public function userAktif()
    {
        return User::where('role', 'sekretaris_pac')
            ->where('is_active', true)
            ->count();
    }

    #[Computed]
    public function userNonaktif()
    {
        return User::where('role', 'sekretaris_pac')
            ->where('is_active', false)
            ->count();
    }

    #[Computed]
    public function userVerified()
    {
        return User::where('role', 'sekretaris_pac')
            ->whereNotNull('email_verified_at')
            ->count();
    }

    public function detail($id)
    {
        $this->userId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['userId']);
    }

    // Toggle Active/Nonactive
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'sekretaris_pac') {
            $this->dispatch('flash', [
                'type' => 'error',
                'message' => 'Hanya bisa mengubah status user PAC!'
            ]);
            return;
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => "Akun {$user->name} berhasil {$status}!"
        ]);
    }

    // Reset Password (set ke default)
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'sekretaris_pac') {
            $this->dispatch('flash', [
                'type' => 'error',
                'message' => 'Hanya bisa reset password user PAC!'
            ]);
            return;
        }

        // Set password default (misalnya: password123)
        $user->update([
            'password' => Hash::make('password123')
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => "Password {$user->name} berhasil direset ke 'password123'!"
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        return match($this->action) {
            'detail' => view('livewire.sekretaris-cabang.data-user-pac.detail', [
                'user' => User::with(['anggotas', 'periodes', 'surats'])->findOrFail($this->userId)
            ]),
            default => view('livewire.sekretaris-cabang.data-user-pac.index', [
                'users' => User::query()
                    ->where('role', 'sekretaris_pac')
                    ->when($this->search, function($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                              ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->when($this->filterStatus !== '', function($query) {
                        $query->where('is_active', $this->filterStatus);
                    })
                    ->latest()
                    ->paginate(10)
            ]),
        };
    }
}
