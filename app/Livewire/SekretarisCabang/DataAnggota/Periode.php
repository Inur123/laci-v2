<?php

namespace App\Livewire\SekretarisCabang\DataAnggota;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use App\Models\Periode as PeriodeModel;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Periode Kepengurusan')]
class Periode extends Component
{
    use WithPagination;

    public $action = 'index';
    public $periodeId;
    public $search = '';

    // Form properties
    public $nama;

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

    // Computed Properties
    #[Computed]
    public function totalPeriode()
    {
        return PeriodeModel::count();
    }

    #[Computed]
    public function periodeBulanIni()
    {
        return PeriodeModel::whereMonth('created_at', now()->month)->count();
    }

    #[Computed]
    public function updateTerakhir()
    {
        return PeriodeModel::latest('updated_at')->first()?->updated_at?->diffForHumans() ?? '-';
    }

    public function create()
    {
        $this->reset(['nama']);
        $this->action = 'create';
    }

    public function save()
    {
        // Cek duplikasi manual (karena data terenkripsi)
        $exists = PeriodeModel::all()->contains(function($periode) {
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

        $this->action = 'index';
        $this->reset(['nama']);
    }

    public function edit($id)
    {
        $periode = PeriodeModel::findOrFail($id);

        $this->periodeId = $id;
        $this->nama = $periode->nama;

        $this->action = 'edit';
    }

    public function update()
    {
        // Cek duplikasi manual (exclude current record)
        $exists = PeriodeModel::where('id', '!=', $this->periodeId)
            ->get()
            ->contains(function($periode) {
                return strtolower($periode->nama) === strtolower($this->nama);
            });

        if ($exists) {
            $this->addError('nama', 'Nama periode sudah digunakan');
            return;
        }

        $this->validate();

        $periode = PeriodeModel::findOrFail($this->periodeId);

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
        $periode = PeriodeModel::find($id);

        if ($periode) {
            // Cek apakah periode masih digunakan
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.data-anggota.periode.create'),
            'edit' => view('livewire.sekretaris-cabang.data-anggota.periode.edit', [
                'periode' => PeriodeModel::findOrFail($this->periodeId)
            ]),
            default => view('livewire.sekretaris-cabang.data-anggota.periode.index', [
                'periodes' => $this->getFilteredPeriodes()
            ]),
        };
    }

    private function getFilteredPeriodes()
    {
        // Jika ada search, ambil semua data dulu (tanpa pagination)
        if ($this->search) {
            $allData = PeriodeModel::with('user')->latest()->get()->filter(function($periode) {
                // Filter setelah decrypt
                return stripos($periode->nama, $this->search) !== false;
            });

            // Manual pagination
            $perPage = 10;
            $currentPage = request()->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;

            return new \Illuminate\Pagination\LengthAwarePaginator(
                $allData->slice($offset, $perPage)->values(),
                $allData->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        // Jika tidak ada search, pagination biasa
        return PeriodeModel::with('user')->latest()->paginate(10);
    }
}
