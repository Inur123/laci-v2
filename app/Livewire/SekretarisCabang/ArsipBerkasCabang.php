<?php

namespace App\Livewire\SekretarisCabang;

use App\Models\ArsipBerkasCabang as ArsipBerkasCabangModel;
use App\Models\Periode;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\SekretarisCabang\ArsipBerkasCabangExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Arsip Berkas Cabang')]
class ArsipBerkasCabang extends Component
{
    use WithPagination, WithFileUploads;

    public $action = 'index';
    public $arsipId;
    public $search = '';
    public $page = 1;

    // Form properties
    public $nama;
    public $tanggal;
    public $catatan;
    public $file;
    public $oldFile;

    // Modal Detail
    public $showDetailModal = false;
    public $selectedBerkas = null;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'catatan' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
    ];

    protected $messages = [
        'nama.required' => 'Nama berkas harus diisi',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
        'file.mimes' => 'File harus berformat PDF, DOC, DOCX, XLS, atau XLSX',
        'file.max' => 'Ukuran file maksimal 10MB',
    ];

    #[On('periodeChanged')]
    public function refreshData()
    {
        $this->resetPage();
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function create()
    {
        $this->reset(['nama', 'tanggal', 'catatan', 'file']);
        $this->action = 'create';
    }

    public function save()
    {
        if (!Auth::user()->periode_aktif_id) {
            $this->dispatch('flash', [
                'type' => 'error',
                'message' => 'Anda belum memiliki periode aktif! Silakan pilih periode terlebih dahulu.'
            ]);
            return;
        }

        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'periode_id' => Auth::user()->periode_aktif_id,
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
            'catatan' => $this->catatan,
        ];

        if ($this->file) {
            $data['file_path'] = ArsipBerkasCabangModel::encryptAndStoreFile($this->file);
        }

        ArsipBerkasCabangModel::create($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Berkas Cabang berhasil ditambahkan!'
        ]);

        $this->action = 'index';
        $this->reset(['nama', 'tanggal', 'catatan', 'file']);
    }

    public function edit($id)
    {
        $berkas = ArsipBerkasCabangModel::where('user_id', Auth::id())->findOrFail($id);

        $this->arsipId = $id;
        $this->nama = $berkas->nama;
        $this->tanggal = $berkas->tanggal?->format('Y-m-d') ?? '';
        $this->catatan = $berkas->catatan;
        $this->oldFile = $berkas->file_path;

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();

        $berkas = ArsipBerkasCabangModel::where('user_id', Auth::id())->findOrFail($this->arsipId);

        $data = [
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
            'catatan' => $this->catatan,
        ];

        if ($this->file) {
            if ($this->oldFile && Storage::disk('local')->exists($this->oldFile)) {
                Storage::disk('local')->delete($this->oldFile);
            }
            $data['file_path'] = ArsipBerkasCabangModel::encryptAndStoreFile($this->file);
        }

        $berkas->update($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Berkas Cabang berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['nama', 'tanggal', 'catatan', 'file', 'arsipId', 'oldFile']);
    }

    public function showDetail($id)
    {
        $this->selectedBerkas = ArsipBerkasCabangModel::findOrFail($id);
        $this->selectedBerkas->load(['user', 'periode']);
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedBerkas = null;
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['nama', 'tanggal', 'catatan', 'file', 'arsipId', 'oldFile']);
    }

    public function delete($id)
    {
        $berkas = ArsipBerkasCabangModel::where('user_id', Auth::id())->find($id);

        if ($berkas) {
            if ($berkas->file_path && Storage::disk('local')->exists($berkas->file_path)) {
                Storage::disk('local')->delete($berkas->file_path);
            }

            $nama = $berkas->nama;
            $berkas->delete();

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => "Berkas {$nama} berhasil dihapus!"
            ]);
        }
    }

    public function updatingSearch()
    {
        $this->page = 1;
    }

    public function export()
    {
        $filename = 'Arsip_Berkas_Cabang_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new ArsipBerkasCabangExport($this->search),
            $filename
        );
    }

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-cabang.arsip-berkas-cabang.create'),
            'edit' => view('livewire.sekretaris-cabang.arsip-berkas-cabang.edit', [
                'berkas' => ArsipBerkasCabangModel::where('user_id', Auth::id())->findOrFail($this->arsipId),
            ]),
            default => view('livewire.sekretaris-cabang.arsip-berkas-cabang.index', [
                'berkasList' => $this->getFilteredBerkas(),
                'stats' => $this->getStats()
            ]),
        };
    }

    private function getFilteredBerkas()
    {
        $user = Auth::user();

        $query = ArsipBerkasCabangModel::with(['user', 'periode'])
            ->where('user_id', $user->id); //  WAJIB

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $allBerkas = $query->latest()->get();

        if ($this->search) {
            $allBerkas = $allBerkas->filter(function ($berkas) {
                $searchLower = strtolower($this->search);
                return str_contains(strtolower($berkas->nama), $searchLower) ||
                    str_contains(strtolower($berkas->catatan ?? ''), $searchLower);
            });
        }

        $perPage = 10;
        $currentPage = $this->page;
        $total = $allBerkas->count();
        $items = $allBerkas->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
    }


    private function getStats()
    {
        $user = Auth::user();
        $query = ArsipBerkasCabangModel::query();

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return [
            'total' => $query->count(),
        ];
    }
}
