<?php

namespace App\Livewire\SekretarisPac;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode as PeriodeModel;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Periode Kepengurusan')]
class Periode extends Component
{
    use WithPagination;

    public $action = 'index';
    public $periodeId;
    public $search = '';
    public $nama;
    public $page = 1; // 🔥 Property untuk custom pagination

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];

    protected $messages = [
        'nama.required' => 'Nama periode harus diisi',
        'nama.max' => 'Nama periode maksimal 255 karakter',
    ];

    // 🔥 Reset page saat filter berubah
    public function resetPage()
    {
        $this->page = 1;
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }
    }

    // Stats hanya milik user login
    #[Computed]
    public function totalPeriode()
    {
        return PeriodeModel::where('user_id', Auth::id())->count();
    }

    #[Computed]
    public function periodeBulanIni()
    {
        return PeriodeModel::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    #[Computed]
    public function updateTerakhir()
    {
        return PeriodeModel::where('user_id', Auth::id())
            ->latest('updated_at')->first()?->updated_at?->diffForHumans() ?? '-';
    }

    public function create()
    {
        $this->reset(['nama']);
        $this->action = 'create';
    }

    public function save()
    {
        $exists = PeriodeModel::where('user_id', Auth::id())
            ->get()
            ->contains(function($periode) {
                return strtolower($periode->nama) === strtolower($this->nama);
            });

        if ($exists) {
            $this->addError('nama', 'Nama periode sudah digunakan');
            return;
        }

        $this->validate();

        PeriodeModel::create([
            'user_id' => Auth::id(),
            'nama' => $this->nama,
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Periode berhasil ditambahkan!'
        ]);

        // Dispatch event ke GantiPeriode component
        $this->dispatch('periodeCreated')->to('components.ganti-periode');

        $this->action = 'index';
        $this->reset(['nama']);
    }

    public function edit($id)
    {
        $periode = PeriodeModel::where('user_id', Auth::id())->findOrFail($id);

        $this->periodeId = $id;
        $this->nama = $periode->nama;

        $this->action = 'edit';
    }

    public function update()
    {
        $exists = PeriodeModel::where('user_id', Auth::id())
            ->where('id', '!=', $this->periodeId)
            ->get()
            ->contains(function($periode) {
                return strtolower($periode->nama) === strtolower($this->nama);
            });

        if ($exists) {
            $this->addError('nama', 'Nama periode sudah digunakan');
            return;
        }

        $this->validate();

        $periode = PeriodeModel::where('user_id', Auth::id())->findOrFail($this->periodeId);

        $periode->update([
            'nama' => $this->nama,
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Periode berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['nama', 'periodeId']);
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['nama', 'periodeId']);
    }

    public function delete($id)
    {
        $periode = PeriodeModel::where('user_id', Auth::id())->find($id);

        if ($periode) {
            // Cek apakah user yang login sedang menggunakan periode ini sebagai periode aktif
            if (Auth::user()->periode_aktif_id == $id) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => 'Periode tidak bisa dihapus karena Anda sedang menggunakannya sebagai periode aktif!'
                ]);
                return;
            }

            // Cek apakah periode masih digunakan oleh anggota
            if ($periode->anggotas()->count() > 0) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => 'Periode tidak bisa dihapus karena masih digunakan oleh anggota!'
                ]);
                return;
            }

            // Cek apakah periode masih digunakan oleh surat
            $suratCount = \App\Models\Surat::where('periode_id', $id)->count();
            if ($suratCount > 0) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => "Periode tidak bisa dihapus karena masih digunakan oleh {$suratCount} surat!"
                ]);
                return;
            }

            // Cek apakah periode masih digunakan oleh pengajuan surat PAC
            $pengajuanCount = \App\Models\PengajuanSuratPac::where('periode_id', $id)->count();
            if ($pengajuanCount > 0) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => "Periode tidak bisa dihapus karena masih digunakan oleh {$pengajuanCount} pengajuan surat!"
                ]);
                return;
            }

            $periode->delete();

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => 'Periode berhasil dihapus!'
            ]);
        }
    }

    // 🔥 Auto-reset page saat search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-pac.periode.create'),
            'edit' => view('livewire.sekretaris-pac.periode.edit', [
                'periode' => PeriodeModel::where('user_id', Auth::id())->findOrFail($this->periodeId)
            ]),
            default => view('livewire.sekretaris-pac.periode.index', [
                'periodes' => $this->getFilteredPeriodes()
            ]),
        };
    }

    private function getFilteredPeriodes()
    {
        // Ambil semua data
        $query = PeriodeModel::with('user')
            ->where('user_id', Auth::id())
            ->latest();

        $allData = $query->get();

        // Filter search manual
        $filtered = $allData->filter(function($periode) {
            if (!$this->search) {
                return true;
            }

            return str_contains(strtolower($periode->nama), strtolower($this->search));
        });

        // Manual pagination
        $perPage = 10;
        $currentPage = $this->page; // 🔥 Gunakan property page
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
