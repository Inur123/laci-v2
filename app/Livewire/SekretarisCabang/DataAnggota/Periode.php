<?php

namespace App\Livewire\SekretarisCabang\DataAnggota;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode as PeriodeModel;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Periode Kepengurusan')]
class Periode extends Component
{
    use WithFileUploads;

    public $action = 'index';
    public $periodeId;
    public $search = '';
    public $nama;
    public $page = 1; // Custom pagination

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];

    protected $messages = [
        'nama.required' => 'Nama periode harus diisi',
        'nama.max' => 'Nama periode maksimal 255 karakter',
    ];

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    // Reset page saat search berubah
    public function resetPage()
    {
        $this->page = 1;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

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
            ->whereRaw('LOWER(nama) = ?', [strtolower($this->nama)])
            ->exists();

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
            ->whereRaw('LOWER(nama) = ?', [strtolower($this->nama)])
            ->exists();

        if ($exists) {
            $this->addError('nama', 'Nama periode sudah digunakan');
            return;
        }

        $this->validate();

        $periode = PeriodeModel::where('user_id', Auth::id())->findOrFail($this->periodeId);
        $periode->update(['nama' => $this->nama]);

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
            if ($periode->anggotas()->count() > 0) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => 'Periode tidak bisa dihapus karena masih digunakan oleh anggota!'
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

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-cabang.data-anggota.periode.create'),
            'edit' => view('livewire.sekretaris-cabang.data-anggota.periode.edit', [
                'periode' => PeriodeModel::where('user_id', Auth::id())->findOrFail($this->periodeId)
            ]),
            default => view('livewire.sekretaris-cabang.data-anggota.periode.index', [
                'periodes' => $this->getFilteredPeriodes()
            ]),
        };
    }

    private function getFilteredPeriodes()
    {
        $query = PeriodeModel::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $filtered = $query;

        if ($this->search) {
            $searchLower = strtolower($this->search);
            $filtered = $query->filter(fn($periode) =>
                str_contains(strtolower($periode->nama), $searchLower)
            );
        }

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
