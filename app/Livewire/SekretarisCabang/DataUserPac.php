<?php

namespace App\Livewire\SekretarisCabang;

use App\Models\User;
use App\Models\Surat;
use App\Models\Anggota;
use App\Models\Periode;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PengajuanSuratPac;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SekretarisCabang\ArsipSuratExport;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\SekretarisCabang\DataAnggotaExport;
use App\Exports\SekretarisCabang\PengajuanSuratPacExport;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Data User PAC')]
class DataUserPac extends Component
{
    use WithPagination;

    public $action = 'index';
    public $userId;
    public $search = '';
    public $filterStatus = '';
    public $page = 1; // custom pagination
    public $selectedPeriodeId = null;

    public function resetPage()
    {
        $this->page = 1;
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') abort(403, 'Akses ditolak');
    }

    #[Computed] public function totalUserPac() { return User::where('role', 'sekretaris_pac')->count(); }
    #[Computed] public function userAktif() { return User::where('role', 'sekretaris_pac')->where('is_active', true)->count(); }
    #[Computed] public function userNonaktif() { return User::where('role', 'sekretaris_pac')->where('is_active', false)->count(); }
    #[Computed] public function userVerified() { return User::where('role', 'sekretaris_pac')->whereNotNull('email_verified_at')->count(); }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function detail($id)
    {
        $this->userId = $id;
        $this->action = 'detail';
        $user = User::findOrFail($id);
        $this->selectedPeriodeId = $user->periode_aktif_id;
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
            $this->dispatch('flash', ['type' => 'error', 'message' => 'Hanya bisa mengubah status user PAC!']);
            return;
        }

        $user->update([
            'is_active' => !$user->is_active,
            'last_status_changed_by_admin_at' => now(),
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        $this->dispatch('flash', ['type' => 'success', 'message' => "Akun {$user->name} berhasil {$status}!"]);
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'sekretaris_pac') {
            $this->dispatch('flash', ['type' => 'error', 'message' => 'Hanya bisa reset password user PAC!']);
            return;
        }

        $user->update([
            'password' => Hash::make('password123'),
            'last_password_reset_at' => now(),
        ]);

        $this->dispatch('flash', ['type' => 'success', 'message' => "Password {$user->name} berhasil direset ke 'password123'!"]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'sekretaris_pac') {
            $this->dispatch('flash', ['type' => 'error', 'message' => 'Hanya bisa menghapus user PAC!']);
            return;
        }

        $user->delete();

        $this->dispatch('flash', ['type' => 'success', 'message' => "Akun {$user->name} berhasil dihapus!"]);
        $this->back();
    }

    public function render()
    {
        $cabangUser = Auth::user();
        $periodeFilter = $this->selectedPeriodeId ?? $cabangUser->periode_aktif_id;

        return match ($this->action) {
            'detail' => view('livewire.sekretaris-cabang.data-user-pac.detail', [
                'user' => User::with([
                    'anggotas' => fn($q) => $periodeFilter ? $q->where('periode_id', $periodeFilter) : $q,
                    'periodes',
                    'surats' => fn($q) => $periodeFilter ? $q->where('periode_id', $periodeFilter) : $q,
                ])->findOrFail($this->userId),
                'stats' => $this->getUserStats($this->userId, $periodeFilter),
                'availablePeriodes' => $this->getAvailablePeriodes($this->userId),
            ]),
            default => view('livewire.sekretaris-cabang.data-user-pac.index', [
                'users' => $this->getFilteredUsers()
            ]),
        };
    }

    private function getAvailablePeriodes($userId)
    {
        $user = User::findOrFail($userId);

        $periodeIds = collect()
            ->merge(Surat::where('user_id', $userId)->whereNotNull('periode_id')->pluck('periode_id'))
            ->merge(Anggota::where('user_id', $userId)->whereNotNull('periode_id')->pluck('periode_id'))
            ->merge(PengajuanSuratPac::where('user_id', $userId)->whereNotNull('periode_id_pac')->pluck('periode_id_pac'));

        $uniquePeriodeIds = $periodeIds->unique()->filter();

        return Periode::whereIn('id', $uniquePeriodeIds)
            ->orderBy('nama', 'desc')
            ->get()
            ->map(fn($periode) => [
                'id' => $periode->id,
                'label' => $periode->nama,
                'is_active' => $periode->id == $user->periode_aktif_id
            ]);
    }

    private function getUserStats($userId, $periodeFilter)
    {
        return [
            'total_surat' => Surat::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id', $periodeFilter))->count(),
            'surat_masuk' => Surat::where('user_id', $userId)->where('jenis_surat', 'masuk')->when($periodeFilter, fn($q) => $q->where('periode_id', $periodeFilter))->count(),
            'surat_keluar' => Surat::where('user_id', $userId)->where('jenis_surat', 'keluar')->when($periodeFilter, fn($q) => $q->where('periode_id', $periodeFilter))->count(),
            'total_anggota' => Anggota::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id', $periodeFilter))->count(),
            'total_pengajuan' => PengajuanSuratPac::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id_pac', $periodeFilter))->count(),
            'pengajuan_pending' => PengajuanSuratPac::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id_pac', $periodeFilter))->get()->filter(fn($p) => $p->status === 'pending')->count(),
            'pengajuan_diterima' => PengajuanSuratPac::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id_pac', $periodeFilter))->get()->filter(fn($p) => $p->status === 'diterima')->count(),
            'pengajuan_ditolak' => PengajuanSuratPac::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id_pac', $periodeFilter))->get()->filter(fn($p) => $p->status === 'ditolak')->count(),
            'latest_surat' => Surat::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id', $periodeFilter))->latest()->take(5)->get(),
            'latest_anggota' => Anggota::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id', $periodeFilter))->latest()->take(5)->get(),
            'latest_pengajuan' => PengajuanSuratPac::where('user_id', $userId)->when($periodeFilter, fn($q) => $q->where('periode_id_pac', $periodeFilter))->latest()->take(5)->get(),
        ];
    }

    private function getFilteredUsers()
    {
        $allData = User::where('role', 'sekretaris_pac')->latest()->get();

        $filtered = $allData->filter(function ($user) {
            $matchSearch = true;
            $matchStatus = true;

            if ($this->search) {
                $searchLower = strtolower($this->search);
                $matchSearch = str_contains(strtolower($user->name ?? ''), $searchLower) ||
                              str_contains(strtolower($user->email ?? ''), $searchLower);
            }

            if ($this->filterStatus !== '') {
                $matchStatus = $user->is_active == $this->filterStatus;
            }

            return $matchSearch && $matchStatus;
        });

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
