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
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Data User PAC')]
class DataUserPac extends Component
{
    use WithPagination;

    public $action = 'index';
    public $userId;
    public $search = '';
    public $filterStatus = '';
    public $page = 1; // 🔥 Property untuk custom pagination

    // 🔥 Reset page saat filter berubah
    public function resetPage()
    {
        $this->page = 1;
    }

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
        'is_active' => !$user->is_active,
        'last_status_changed_by_admin_at' => now(), // tambahkan ini
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

        $user->update([
            'password' => Hash::make('password123'),
            'last_password_reset_at' => now(), // tambahkan ini
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => "Password {$user->name} berhasil direset ke 'password123'!"
        ]);
    }

    // 🔥 Auto-reset page saat filter berubah
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
        return match ($this->action) {
            'detail' => view('livewire.sekretaris-cabang.data-user-pac.detail', [
                'user' => User::with(['anggotas', 'periodes', 'surats'])->findOrFail($this->userId)
            ]),
            default => view('livewire.sekretaris-cabang.data-user-pac.index', [
                'users' => $this->getFilteredUsers()
            ]),
        };
    }

    // 🔥 Custom Pagination
    private function getFilteredUsers()
    {
        // Ambil semua data user PAC
        $query = User::where('role', 'sekretaris_pac')->latest();

        $allData = $query->get();

        // Filter manual
        $filtered = $allData->filter(function ($user) {
            $matchSearch = true;
            $matchStatus = true;

            // Filter Search
            if ($this->search) {
                $searchLower = strtolower($this->search);
                $matchSearch = str_contains(strtolower($user->name ?? ''), $searchLower) ||
                    str_contains(strtolower($user->email ?? ''), $searchLower);
            }

            // Filter Status
            if ($this->filterStatus !== '') {
                $matchStatus = $user->is_active == $this->filterStatus;
            }

            return $matchSearch && $matchStatus;
        });

        // Manual pagination
        $perPage = 10;
        $currentPage = $this->page;
        $total = $filtered->count();
        $items = $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
    }
}
