<?php

namespace App\Livewire\SekretarisCabang;

use App\Models\Surat;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Arsip Surat')]
class ArsipSurat extends Component
{
    use WithPagination, WithFileUploads;

    public $action = 'index';
    public $arsipId;
    public $search = '';
    public $filterJenis = '';

    // Form properties
    public $no_surat;
    public $jenis_surat;
    public $tanggal;
    public $pengirim_penerima;
    public $deskripsi;
    public $file;
    public $oldFile;

    protected $rules = [
        'no_surat' => 'required|string|max:255|unique:surat,no_surat',
        'jenis_surat' => 'required|in:masuk,keluar',
        'tanggal' => 'required|date',
        'pengirim_penerima' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf|max:5120', // Hanya PDF, max 5MB
    ];

    protected $messages = [
        'no_surat.required' => 'Nomor surat harus diisi',
        'no_surat.unique' => 'Nomor surat sudah digunakan',
        'jenis_surat.required' => 'Jenis surat harus dipilih',
        'jenis_surat.in' => 'Jenis surat tidak valid',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
        'pengirim_penerima.required' => 'Pengirim/Penerima harus diisi',
        'file.mimes' => 'File harus berformat PDF',
        'file.max' => 'Ukuran file maksimal 5MB',
    ];

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function create()
    {
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file']);
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
        ];

        // Upload file jika ada
        if ($this->file) {
            $data['file'] = $this->file->store('surat', 'public');
        }

        Surat::create($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Surat berhasil ditambahkan!'
        ]);

        $this->action = 'index';
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file']);
    }

    public function edit($id)
    {
        $surat = Surat::findOrFail($id);

        $this->arsipId = $id;
        $this->no_surat = $surat->no_surat;
        $this->jenis_surat = $surat->jenis_surat;
        $this->tanggal = $surat->tanggal->format('Y-m-d');
        $this->pengirim_penerima = $surat->pengirim_penerima;
        $this->deskripsi = $surat->deskripsi;
        $this->oldFile = $surat->file;

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate([
            'no_surat' => 'required|string|max:255|unique:surat,no_surat,' . $this->arsipId,
            'jenis_surat' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'pengirim_penerima' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:5120', // Hanya PDF, max 5MB
        ]);

        $surat = Surat::findOrFail($this->arsipId);

        $data = [
            'no_surat' => $this->no_surat,
            'jenis_surat' => $this->jenis_surat,
            'tanggal' => $this->tanggal,
            'pengirim_penerima' => $this->pengirim_penerima,
            'deskripsi' => $this->deskripsi,
        ];

        // Upload file baru jika ada
        if ($this->file) {
            // Hapus file lama
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }

            $data['file'] = $this->file->store('surat', 'public');
        }

        $surat->update($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Surat berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'arsipId', 'oldFile']);
    }

    public function detail($id)
    {
        $this->arsipId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['no_surat', 'jenis_surat', 'tanggal', 'pengirim_penerima', 'deskripsi', 'file', 'arsipId', 'oldFile']);
    }

    public function delete($id)
    {
        $surat = Surat::find($id);

        if ($surat) {
            // Hapus file jika ada
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }

            $surat->delete();

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => 'Surat berhasil dihapus!'
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

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.arsip-surat.create'),
            'edit' => view('livewire.sekretaris-cabang.arsip-surat.edit', [
                'surat' => Surat::findOrFail($this->arsipId)
            ]),
            'detail' => view('livewire.sekretaris-cabang.arsip-surat.detail', [
                'surat' => Surat::findOrFail($this->arsipId)
            ]),
            default => view('livewire.sekretaris-cabang.arsip-surat.index', [
                'surats' => Surat::query()
                    ->when($this->search, function($query) {
                        $query->where('no_surat', 'like', '%' . $this->search . '%')
                              ->orWhere('pengirim_penerima', 'like', '%' . $this->search . '%')
                              ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                    })
                    ->when($this->filterJenis, function($query) {
                        $query->where('jenis_surat', $this->filterJenis);
                    })
                    ->latest()
                    ->paginate(10)
            ]),
        };
    }
}
