<?php

namespace App\Livewire\SekretarisPac;

use App\Models\ArsipBerkasCabang;
use App\Models\Periode;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\SekretarisPac\ArsipBerkasPacExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Arsip Berkas PAC')]
class ArsipBerkasPac extends Component
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
        'nama.required' => 'Nama berkas harus diisi.',
        'tanggal.required' => 'Tanggal harus diisi.',
        'file.mimes' => 'File harus berformat PDF, DOC, DOCX, XLS, atau XLSX.',
        'file.max' => 'Ukuran file maksimal 10MB.',
    ];

    public function updatingSearch()
    {
        $this->page = 1;
    }

    public function mount()
    {
        if (!Auth::user()->periode_aktif_id) {
            session()->flash('error', 'Anda belum memilih periode aktif. Silakan pilih periode terlebih dahulu.');
            return redirect()->route('pac.periode');
        }
    }

    public function getFilteredBerkas()
    {
        $periodeAktifId = Auth::user()->periode_aktif_id;

        $berkas = ArsipBerkasCabang::with(['user', 'periode'])
            ->where('user_id', Auth::id())
            ->where('periode_id', $periodeAktifId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($this->search) {
            $berkas = $berkas->filter(function ($item) {
                $searchLower = strtolower($this->search);
                return stripos(strtolower($item->nama), $searchLower) !== false ||
                    stripos(strtolower($item->catatan ?? ''), $searchLower) !== false;
            });
        }

        $perPage = 10;
        $currentPage = $this->page;
        $offset = ($currentPage - 1) * $perPage;

        $paginatedItems = $berkas->slice($offset, $perPage)->values();

        return new LengthAwarePaginator(
            $paginatedItems,
            $berkas->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
    }

    public function create()
    {
        $this->action = 'create';
        $this->reset(['nama', 'tanggal', 'catatan', 'file']);
    }

    public function save()
    {
        $this->validate();

        $filePath = null;
        if ($this->file) {
            $filePath = ArsipBerkasCabang::encryptAndStoreFile($this->file);
        }

        ArsipBerkasCabang::create([
            'user_id' => Auth::id(),
            'periode_id' => Auth::user()->periode_aktif_id,
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
            'catatan' => $this->catatan,
            'file_path' => $filePath,
        ]);

        session()->flash('success', 'Berkas PAC berhasil ditambahkan.');
        return redirect()->route('pac.arsip-berkas-pac');
    }

    public function edit($id)
    {
        $berkas = ArsipBerkasCabang::where('user_id', Auth::id())->findOrFail($id);

        $this->arsipId = $berkas->id;
        $this->nama = $berkas->nama;
        $this->tanggal = $berkas->tanggal?->format('Y-m-d');
        $this->catatan = $berkas->catatan;
        $this->oldFile = $berkas->file_path;
        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();

        $berkas = ArsipBerkasCabang::where('user_id', Auth::id())->findOrFail($this->arsipId);

        $filePath = $berkas->file_path;
        if ($this->file) {
            if ($berkas->file_path) {
                Storage::disk('local')->delete($berkas->file_path);
            }
            $filePath = ArsipBerkasCabang::encryptAndStoreFile($this->file);
        }

        $berkas->update([
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
            'catatan' => $this->catatan,
            'file_path' => $filePath,
        ]);

        session()->flash('success', 'Berkas PAC berhasil diperbarui.');
        return redirect()->route('pac.arsip-berkas-pac');
    }

    public function delete($id)
    {
        $berkas = ArsipBerkasCabang::where('user_id', Auth::id())->findOrFail($id);

        if ($berkas->file_path) {
            Storage::disk('local')->delete($berkas->file_path);
        }

        $berkas->delete();

        session()->flash('success', 'Berkas PAC berhasil dihapus.');
    }

    public function showDetail($id)
    {
        $this->selectedBerkas = ArsipBerkasCabang::with(['user', 'periode'])->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedBerkas = null;
    }

    public function export()
    {
        $periodeAktif = Periode::find(Auth::user()->periode_aktif_id);
        $filename = 'arsip_berkas_pac_' . ($periodeAktif ? $periodeAktif->nama : 'semua') . '_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new ArsipBerkasPacExport($this->search), $filename);
    }

    public function cancel()
    {
        $this->action = 'index';
        $this->reset(['arsipId', 'nama', 'tanggal', 'catatan', 'file', 'oldFile']);
    }

    #[On('berkas-deleted')]
    public function handleBerkasDeleted()
    {
        $this->page = 1;
    }

    public function render()
    {
        $berkasList = $this->getFilteredBerkas();
        $periodeAktif = Periode::find(Auth::user()->periode_aktif_id);

        $stats = [
            'total' => ArsipBerkasCabang::where('user_id', Auth::id())
                ->where('periode_id', Auth::user()->periode_aktif_id)
                ->count(),
        ];

        if ($this->action === 'create') {
            return view('livewire.sekretaris-pac.arsip-berkas-pac.create', [
                'periodeAktif' => $periodeAktif,
            ]);
        }

        if ($this->action === 'edit') {
            $berkas = ArsipBerkasCabang::findOrFail($this->arsipId);
            return view('livewire.sekretaris-pac.arsip-berkas-pac.edit', [
                'berkas' => $berkas,
                'periodeAktif' => $periodeAktif,
            ]);
        }

        return view('livewire.sekretaris-pac.arsip-berkas-pac.index', [
            'berkasList' => $berkasList,
            'periodeAktif' => $periodeAktif,
            'stats' => $stats,
        ]);
    }
}
