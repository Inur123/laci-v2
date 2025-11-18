<?php

namespace App\Livewire\SekretarisPac;

use App\Models\Surat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Arsip Surat - PAC')]
class ArsipSurat extends Component
{
    use WithPagination, WithFileUploads;

    public $action = 'index';
    public $arsipId;
    public $search = '';
    public $filterJenis = '';
    public $page = 1; // Tambahkan property page

    // Form properties
    public $no_surat;
    public $jenis_surat;
    public $tanggal;
    public $pengirim_penerima;
    public $deskripsi;
    public $file;
    public $oldFile;
    public $perihal;

    protected $rules = [
        'no_surat' => 'required|string|max:255',
        'jenis_surat' => 'required|in:masuk,keluar',
        'tanggal' => 'required|date',
        'pengirim_penerima' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf|max:5120',
        'perihal' => 'required|string|max:255',
    ];

    protected $messages = [
        'no_surat.required' => 'Nomor surat harus diisi',
        'jenis_surat.required' => 'Jenis surat harus dipilih',
        'jenis_surat.in' => 'Jenis surat tidak valid',
        'perihal.required' => 'Perihal harus diisi',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
        'pengirim_penerima.required' => 'Pengirim/Penerima harus diisi',
        'file.mimes' => 'File harus berformat PDF',
        'file.max' => 'Ukuran file maksimal 5MB',
    ];

    // Hapus method-method ini karena tidak diperlukan
    // public function gotoPage($page)
    // {
    //     $this->setPage($page);
    // }
    //
    // public function previousPage()
    // {
    //     $this->setPage($this->getPage() - 1);
    // }
    //
    // public function nextPage()
    // {
    //     $this->setPage($this->getPage() + 1);
    // }

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

    public function create()
    {
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'perihal']);
        $this->action = 'create';
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'no_surat' => $this->no_surat,
            'jenis_surat' => $this->jenis_surat,
            'tanggal' => $this->tanggal,
            'pengirim_penerima' => $this->pengirim_penerima,
            'deskripsi' => $this->deskripsi,
            'perihal' => $this->perihal,
        ];

        // Enkripsi file jika ada
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
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:5120',
            'perihal' => 'required|string|max:255',
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

        // Enkripsi file baru jika ada
        if ($this->file) {
            // Hapus file lama
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
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'arsipId', 'oldFile','perihal']);
    }

    public function detail($id)
    {
        $this->arsipId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'arsipId', 'oldFile','perihal']);
    }

    public function delete($id)
    {
        $surat = Surat::where('user_id', Auth::id())->find($id);

        if ($surat) {
            // Hapus file terenkripsi
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

    // 🔥 METHOD BARU: Ambil Stats untuk Card
    private function getStats()
    {
        $allSurats = Surat::where('user_id', Auth::id())->get();

        return [
            'total' => $allSurats->count(),
            'masuk' => $allSurats->where('jenis_surat', 'masuk')->count(),
            'keluar' => $allSurats->where('jenis_surat', 'keluar')->count(),
        ];
    }

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-pac.arsip-surat.create'),
            'edit' => view('livewire.sekretaris-pac.arsip-surat.edit', [
                'surat' => Surat::where('user_id', Auth::id())->findOrFail($this->arsipId)
            ]),
            'detail' => view('livewire.sekretaris-pac.arsip-surat.detail', [
                'surat' => Surat::where('user_id', Auth::id())->findOrFail($this->arsipId)
            ]),
            default => view('livewire.sekretaris-pac.arsip-surat.index', [
                'surats' => $this->getFilteredSurats(),
                'stats' => $this->getStats() // 🔥 Kirim stats ke view
            ]),
        };
    }

    private function getFilteredSurats()
    {
        // 🔒 HANYA AMBIL DATA SURAT MILIK USER YANG LOGIN
        $query = Surat::with('user')
            ->where('user_id', Auth::id())
            ->latest();

        $allSurats = $query->get();

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
        $currentPage = $this->page; // Gunakan property page
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
