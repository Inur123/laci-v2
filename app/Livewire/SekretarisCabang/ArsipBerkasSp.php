<?php

namespace App\Livewire\SekretarisCabang;

use App\Models\ArsipBerkasSp as ModelArsipBerkasSp;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\SekretarisCabang\ArsipBerkasSpExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Arsip Berkas SP')]
class ArsipBerkasSp extends Component
{
    use WithFileUploads; // ✅ HAPUS WithPagination

    public $action = 'index';
    public $arsipId;
    public $search = '';
    public $page = 1;

    // Form properties
    public $nama;
    public $tanggal_mulai;
    public $tanggal_berakhir;
    public $catatan;
    public $file;
    public $oldFile;

    // Modal Detail
    public $showDetailModal = false;
    public $selectedBerkas = null;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        'catatan' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
    ];

    protected $messages = [
        'nama.required' => 'Nama berkas harus diisi',
        'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
        'tanggal_mulai.date' => 'Format tanggal tidak valid',
        'tanggal_berakhir.required' => 'Tanggal berakhir harus diisi',
        'tanggal_berakhir.date' => 'Format tanggal tidak valid',
        'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai',
        'file.mimes' => 'File harus berformat PDF, DOC, DOCX, XLS, atau XLSX',
        'file.max' => 'Ukuran file maksimal 10MB',
    ];

    // ✅ reset page custom (karena pakai $page manual)
    public function resetCustomPage()
    {
        $this->page = 1;
    }

    #[On('periodeChanged')]
    public function refreshData()
    {
        $this->resetCustomPage(); // ✅ bener-bener reset
    }

    public function updatingSearch()
    {
        $this->resetCustomPage();
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function create()
    {
        $this->reset(['nama', 'tanggal_mulai', 'tanggal_berakhir', 'catatan', 'file']);
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
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'catatan' => $this->catatan,
        ];

        if ($this->file) {
            $data['file_path'] = ModelArsipBerkasSp::encryptAndStoreFile($this->file);
        }

        ModelArsipBerkasSp::create($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Berkas SP berhasil ditambahkan!'
        ]);

        $this->action = 'index';
        $this->resetCustomPage();
        $this->reset(['nama', 'tanggal_mulai', 'tanggal_berakhir', 'catatan', 'file']);
    }

    public function edit($id)
    {
        $berkas = ModelArsipBerkasSp::where('user_id', Auth::id())->findOrFail($id);

        $this->arsipId = $id;
        $this->nama = $berkas->nama;
        $this->tanggal_mulai = $berkas->tanggal_mulai?->format('Y-m-d') ?? '';
        $this->tanggal_berakhir = $berkas->tanggal_berakhir?->format('Y-m-d') ?? '';
        $this->catatan = $berkas->catatan;
        $this->oldFile = $berkas->file_path;

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();

        $berkas = ModelArsipBerkasSp::where('user_id', Auth::id())->findOrFail($this->arsipId);

        $data = [
            'nama' => $this->nama,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'catatan' => $this->catatan,
        ];

        if ($this->file) {
            if ($this->oldFile && Storage::disk('local')->exists($this->oldFile)) {
                Storage::disk('local')->delete($this->oldFile);
            }
            $data['file_path'] = ModelArsipBerkasSp::encryptAndStoreFile($this->file);
        }

        $berkas->update($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Berkas SP berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->resetCustomPage();
        $this->reset(['nama', 'tanggal_mulai', 'tanggal_berakhir', 'catatan', 'file', 'arsipId', 'oldFile']);
    }

    public function showDetail($id)
    {
        $this->selectedBerkas = ModelArsipBerkasSp::findOrFail($id);
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
        $this->reset(['nama', 'tanggal_mulai', 'tanggal_berakhir', 'catatan', 'file', 'arsipId', 'oldFile']);
    }

    public function delete($id)
    {
        $berkas = ModelArsipBerkasSp::where('user_id', Auth::id())->find($id);

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

            // kalau hapus bikin halaman kosong, mundurin page
            if ($this->page > 1) {
                $this->page = max(1, $this->page - 1);
            }
        }
    }

    public function export()
    {
        $filename = 'Arsip_Berkas_SP_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new ArsipBerkasSpExport($this->search),
            $filename
        );
    }

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-cabang.arsip-berkas-sp.create'),
            'edit' => view('livewire.sekretaris-cabang.arsip-berkas-sp.edit', [
                'berkas' => ModelArsipBerkasSp::where('user_id', Auth::id())->findOrFail($this->arsipId),
            ]),
            default => view('livewire.sekretaris-cabang.arsip-berkas-sp.index', [
                'berkasList' => $this->getFilteredBerkas(),
                'stats' => $this->getStats()
            ]),
        };
    }

    private function getFilteredBerkas()
    {
        $user = Auth::user();

        $query = ModelArsipBerkasSp::with(['user', 'periode']);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        // ✅ lebih ringan: filtering search di query, bukan get()->filter()
        if ($this->search) {
            $s = '%' . strtolower($this->search) . '%';
            $query->where(function ($q) use ($s) {
                $q->whereRaw('LOWER(nama) LIKE ?', [$s])
                  ->orWhereRaw('LOWER(catatan) LIKE ?', [$s]);
            });
        }


        $perPage = 10;

        $total = $query->count();

        $items = $query->latest()
            ->skip(($this->page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $this->page,
            ['path' => request()->url()]
        );
    }

    private function getStats()
    {
        $user = Auth::user();
        $query = ModelArsipBerkasSp::query();

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return [
            'total' => $query->count(),
        ];
    }
}
