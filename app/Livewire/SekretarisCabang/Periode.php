<?php

namespace App\Livewire\SekretarisCabang;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
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

            // Cek apakah periode masih digunakan oleh arsip berkas cabang
            $berkasCabangCount = \App\Models\ArsipBerkasCabang::where('periode_id', $id)->count();
            if ($berkasCabangCount > 0) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => "Periode tidak bisa dihapus karena masih digunakan oleh {$berkasCabangCount} berkas cabang!"
                ]);
                return;
            }

            // Cek apakah periode masih digunakan oleh pengajuan surat PAC
            $pengajuanCount = \App\Models\PengajuanSuratPac::where('periode_id', $id)->count();
            if ($pengajuanCount > 0) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => "Periode tidak bisa dihapus karena masih digunakan oleh {$pengajuanCount} pengajuan surat PAC!"
                ]);
                return;
            }

            // Cek apakah periode masih digunakan oleh kegiatan
            $kegiatanCount = \App\Models\Kegiatan::where('periode_id', $id)->count();
            if ($kegiatanCount > 0) {
                $this->dispatch('flash', [
                    'type' => 'error',
                    'message' => "Periode tidak bisa dihapus karena masih digunakan oleh {$kegiatanCount} kegiatan!"
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
            'create' => view('livewire.sekretaris-cabang.periode.create'),
            'edit' => view('livewire.sekretaris-cabang.periode.edit', [
                'periode' => PeriodeModel::where('user_id', Auth::id())->findOrFail($this->periodeId)
            ]),
            default => view('livewire.sekretaris-cabang.periode.index', [
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
