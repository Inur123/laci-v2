<?php

namespace App\Livewire\SekretarisCabang;

use App\Models\Surat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\SekretarisCabang\ArsipSuratExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Arsip Surat')]
class ArsipSurat extends Component
{
    use WithPagination, WithFileUploads;

    public $action = 'index';
    public $arsipId;
    public $search = '';
    public $filterJenis = '';
    public $page = 1;

    // Form properties
    public $no_surat;
    public $jenis_surat;
    public $tanggal;
    public $pengirim_penerima;
    public $deskripsi;
    public $file;
    public $oldFile;
    public $perihal;

    // Modal Detail
    public $showDetailModal = false;
    public $selectedSurat = null;

    protected $rules = [
        'no_surat' => 'required|string|max:255',
        'jenis_surat' => 'required|in:masuk,keluar',
        'tanggal' => 'required|date',
        'pengirim_penerima' => 'required|string|max:255',
        'perihal' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
    ];

    protected $messages = [
        'no_surat.required' => 'Nomor surat harus diisi',
        'jenis_surat.required' => 'Jenis surat harus dipilih',
        'jenis_surat.in' => 'Jenis surat tidak valid',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
        'pengirim_penerima.required' => 'Pengirim/Penerima harus diisi',
        'file.mimes' => 'File harus berformat PDF, DOC, DOCX, XLS, XLSX, PPT, atau PPTX',
        'file.max' => 'Ukuran file maksimal 10MB',
    ];

    public function resetPage()
    {
        $this->page = 1;
    }

    #[On('periodeChanged')]
    public function refreshData()
    {
        // Refresh data saat periode berubah
        $this->resetPage();
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }

        // Set filter jenis dari query parameter jika ada
        if (request()->has('jenis') && in_array(request()->get('jenis'), ['masuk', 'keluar'])) {
            $this->filterJenis = request()->get('jenis');
        }
    }

    public function create()
    {
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'perihal']);
        $this->action = 'create';
    }

    public function save()
    {
        // Validasi: User harus memiliki periode aktif
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
            'no_surat' => $this->no_surat,
            'jenis_surat' => $this->jenis_surat,
            'tanggal' => $this->tanggal,
            'pengirim_penerima' => $this->pengirim_penerima,
            'deskripsi' => $this->deskripsi,
            'perihal' => $this->perihal,
        ];

        if ($this->file) {
            $data['file'] = Surat::encryptAndStoreFile($this->file);
        }

        Surat::create($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Surat berhasil ditambahkan!'
        ]);

        $this->action = 'index';
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'perihal']);
    }

    public function edit($id)
    {
        $surat = Surat::where('user_id', Auth::id())->findOrFail($id);

        $this->arsipId = $id;
        $this->no_surat = $surat->no_surat;
        $this->jenis_surat = $surat->jenis_surat;
        $this->tanggal = $surat->tanggal->format('Y-m-d');
        $this->pengirim_penerima = $surat->pengirim_penerima;
        $this->deskripsi = $surat->deskripsi;
        $this->oldFile = $surat->file;
        $this->perihal = $surat->perihal;

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate([
            'no_surat' => 'required|string|max:255',
            'jenis_surat' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'pengirim_penerima' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $surat = Surat::where('user_id', Auth::id())->findOrFail($this->arsipId);

        $data = [
            'no_surat' => $this->no_surat,
            'jenis_surat' => $this->jenis_surat,
            'tanggal' => $this->tanggal,
            'pengirim_penerima' => $this->pengirim_penerima,
            'deskripsi' => $this->deskripsi,
            'perihal' => $this->perihal,
        ];

        if ($this->file) {
            if ($this->oldFile && Storage::disk('local')->exists($this->oldFile)) {
                Storage::disk('local')->delete($this->oldFile);
            }
            $data['file'] = Surat::encryptAndStoreFile($this->file);
        }

        $surat->update($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Surat berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'arsipId', 'oldFile', 'perihal']);
    }

    // Tampilkan detail dalam modal
    public function showDetail($id)
    {
        $this->selectedSurat = Surat::where('user_id', Auth::id())->findOrFail($id);
        $this->showDetailModal = true;
    }

    // Tutup modal detail
    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedSurat = null;
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'arsipId', 'oldFile', 'perihal']);
    }

    public function delete($id)
    {
        $surat = Surat::where('user_id', Auth::id())->find($id);

        if ($surat) {
            if ($surat->file && Storage::disk('local')->exists($surat->file)) {
                Storage::disk('local')->delete($surat->file);
            }

            $noSurat = $surat->no_surat;
            $surat->delete();

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => "Surat {$noSurat} berhasil dihapus!"
            ]);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterJenis()
    {
        $this->resetPage();
    }

    private function getStats()
    {
        $user = Auth::user();
        $query = Surat::where('user_id', $user->id);

        // Filter berdasarkan periode aktif
        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $allSurats = $query->get();

        return [
            'total' => $allSurats->count(),
            'masuk' => $allSurats->where('jenis_surat', 'masuk')->count(),
            'keluar' => $allSurats->where('jenis_surat', 'keluar')->count(),
        ];
    }

    public function export()
    {
        $filename = 'Arsip_Surat_Cabang_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new ArsipSuratExport($this->search, $this->filterJenis),
            $filename
        );
    }

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-cabang.arsip-surat.create'),
            'edit' => view('livewire.sekretaris-cabang.arsip-surat.edit', [
                'surat' => Surat::where('user_id', Auth::id())->findOrFail($this->arsipId)
            ]),
            default => view('livewire.sekretaris-cabang.arsip-surat.index', [
                'surats' => $this->getFilteredSurats(),
                'stats' => $this->getStats()
            ]),
        };
    }

    private function getFilteredSurats()
    {
        $user = Auth::user();

        $query = Surat::with('user')
            ->where('user_id', $user->id);

        // Filter berdasarkan periode aktif
        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $allSurats = $query->latest()->get();

        $filtered = $allSurats->filter(function ($surat) {
            $matchSearch = true;
            $matchJenis = true;

            if ($this->search) {
                $searchLower = strtolower($this->search);
                $matchSearch = str_contains(strtolower($surat->no_surat), $searchLower) ||
                    str_contains(strtolower($surat->pengirim_penerima ?? ''), $searchLower) ||
                    str_contains(strtolower($surat->deskripsi ?? ''), $searchLower);
            }

            if ($this->filterJenis) {
                $matchJenis = $surat->jenis_surat === $this->filterJenis;
            }

            return $matchSearch && $matchJenis;
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
