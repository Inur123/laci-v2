<?php

namespace App\Livewire\SekretarisPac;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PengajuanSuratPac;
use App\Mail\PengajuanTerkirimMail;
use Illuminate\Support\Facades\Log;
use App\Mail\PengajuanSuratBaruMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\SekretarisPac\ArsipPengajuanSuratExport;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Pengajuan Surat - PAC')]
class PengajuanSurat extends Component
{
    use WithFileUploads, WithPagination;

    public $action = 'index';
    public $pengajuanId;
    public $search = '';
    public $filterStatus = '';
    public $page = 1;
    public $no_surat;
    public $penerima;
    public $tanggal;
    public $keperluan;
    public $deskripsi;
    public $file;
    public $oldFile;
    public $status = 'pending';

    // Modal untuk detail
    public $showDetailModal = false;
    public $selectedSurat = null;

    protected $rules = [
        'no_surat' => 'required|string|max:255',
        'penerima' => 'required|in:ipnu,ippnu,bersama',
        'tanggal' => 'required|date',
        'keperluan' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
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

    #[On('pengajuanPacUpdated')]
    public function handlePengajuanUpdate()
    {
        // Realtime refresh saat ada perubahan dari Cabang (approve/reject)
        $this->resetPage();
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }
    }

    private function getStats()
    {
        $user = Auth::user();
        $query = PengajuanSuratPac::where('user_id', $user->id);

        // Filter berdasarkan periode PAC (periode_id_pac)
        if ($user->periode_aktif_id) {
            $query->where('periode_id_pac', $user->periode_aktif_id);
        }

        $allSurats = $query->get();

        return [
            'total' => $allSurats->count(),
            'pending' => $allSurats->where('status', 'pending')->count(),
            'diterima' => $allSurats->where('status', 'diterima')->count(),
            'ditolak' => $allSurats->where('status', 'ditolak')->count(),
        ];
    }

    public function create()
    {
        $this->reset(['no_surat', 'penerima', 'tanggal', 'keperluan', 'deskripsi', 'file', 'status']);
        $this->action = 'create';
    }

    public function save()
    {
        $user = Auth::user();
        // Validasi: User harus memiliki periode aktif
        if (!$user->periode_aktif_id) {
            $this->dispatch('flash', [
                'type' => 'error',
                'message' => 'Anda belum memiliki periode aktif! Silakan pilih periode terlebih dahulu.'
            ]);
            return;
        }

        $this->validate();

        // Ambil periode aktif Cabang saat ini
        $cabang = \App\Models\User::where('role', 'sekretaris_cabang')->first();
        $periodeIdCabang = ($cabang && $cabang->periode_aktif_id) ? $cabang->periode_aktif_id : null;

        // Jika Cabang tidak punya periode aktif, beri warning tapi tetap simpan
        if (!$periodeIdCabang) {
            Log::warning('Pengajuan dibuat tanpa periode Cabang aktif', [
                'pac_user_id' => $user->id,
                'pac_periode_id' => $user->periode_aktif_id
            ]);
        }

        $data = [
            'user_id'   => Auth::id(),
            'periode_id_pac' => $user->periode_aktif_id, // Periode PAC saat mengirim
            'periode_id' => $periodeIdCabang, // Periode Cabang saat PAC mengirim (bisa null)
            'no_surat'  => $this->no_surat,
            'penerima'  => $this->penerima,
            'tanggal'   => $this->tanggal,
            'keperluan' => $this->keperluan,
            'deskripsi' => $this->deskripsi,
            'status'    => 'pending',
        ];

        if ($this->file) {
            $data['file'] = PengajuanSuratPac::encryptAndStoreFile($this->file);
        }

        $pengajuan = PengajuanSuratPac::create($data)->load('user');

        // Kirim email
        Mail::to('zainurroziqin38@gmail.com')->queue(new PengajuanSuratBaruMail($pengajuan));
        Mail::to($pengajuan->user->email)->queue(new PengajuanTerkirimMail($pengajuan));

        // Dispatch event untuk realtime update di Cabang
        $this->dispatch('pengajuanPacUpdated');

        $this->dispatch('flash', [
            'type'    => 'success',
            'message' => 'Pengajuan berhasil dikirim! Notifikasi telah dikirim ke email Anda.'
        ]);

        $this->action = 'index';
        $this->reset(['no_surat', 'penerima', 'tanggal', 'keperluan', 'deskripsi', 'file', 'status']);
    }

    public function edit($id)
    {
        $surat = PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($id);

        if ($surat->status !== 'pending') {
            $this->dispatch('flash', [
                'type' => 'error',
                'message' => 'Pengajuan surat sudah diproses dan tidak bisa diedit!'
            ]);
            return;
        }

        $this->pengajuanId = $id;
        $this->no_surat = $surat->no_surat;
        $this->penerima = $surat->penerima;
        $this->tanggal = $surat->tanggal ? $surat->tanggal->format('Y-m-d') : '';
        $this->keperluan = $surat->keperluan;
        $this->deskripsi = $surat->deskripsi;
        $this->oldFile = $surat->file;
        $this->status = $surat->status;

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();

        $surat = PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($this->pengajuanId);

        $data = [
            'no_surat' => $this->no_surat,
            'penerima' => $this->penerima,
            'tanggal' => $this->tanggal,
            'keperluan' => $this->keperluan,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
        ];

        if ($this->file) {
            if ($this->oldFile && Storage::disk('local')->exists($this->oldFile)) {
                Storage::disk('local')->delete($this->oldFile);
            }
            $data['file'] = PengajuanSuratPac::encryptAndStoreFile($this->file);
        }

        $surat->update($data);

        // Dispatch event untuk realtime update di Cabang
        $this->dispatch('pengajuanPacUpdated');

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Pengajuan surat berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['pengajuanId', 'no_surat', 'penerima', 'tanggal', 'keperluan', 'deskripsi', 'file', 'oldFile', 'status']);
    }

    // Tampilkan detail dalam modal
    public function showDetail($id)
    {
        $this->selectedSurat = PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($id);
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
        $this->reset(['pengajuanId', 'no_surat', 'penerima', 'tanggal', 'keperluan', 'deskripsi', 'file', 'oldFile', 'status']);
    }

    public function delete($id)
    {
        $surat = PengajuanSuratPac::where('user_id', Auth::id())->find($id);

        if ($surat) {
            if ($surat->file && Storage::disk('local')->exists($surat->file)) {
                Storage::disk('local')->delete($surat->file);
            }
            $surat->delete();

            // Dispatch event untuk realtime update di Cabang
            $this->dispatch('pengajuanPacUpdated');

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => 'Pengajuan surat berhasil dihapus!'
            ]);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-pac.pengajuan-surat.create'),
            'edit' => view('livewire.sekretaris-pac.pengajuan-surat.edit', [
                'surat' => PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($this->pengajuanId)
            ]),
            default => view('livewire.sekretaris-pac.pengajuan-surat.index', [
                'surats' => $this->getFilteredSurats(),
                'stats' => $this->getStats()
            ]),
        };
    }

    private function getFilteredSurats()
    {
        $user = Auth::user();

        $query = PengajuanSuratPac::where('user_id', $user->id);

        // Filter berdasarkan periode PAC (periode_id_pac)
        if ($user->periode_aktif_id) {
            $query->where('periode_id_pac', $user->periode_aktif_id);
        }

        $allData = $query->latest()->get();

        $filtered = $allData->filter(function ($surat) {
            $matchSearch = true;
            $matchStatus = true;

            if ($this->search) {
                $searchLower = strtolower($this->search);
                $matchSearch = str_contains(strtolower($surat->no_surat ?? ''), $searchLower) ||
                    str_contains(strtolower($surat->keperluan ?? ''), $searchLower) ||
                    str_contains(strtolower($surat->penerima ?? ''), $searchLower);
            }

            if ($this->filterStatus) {
                $matchStatus = $surat->status === $this->filterStatus;
            }

            return $matchSearch && $matchStatus;
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
    public function export()
{
    $filename = 'Arsip_Pengajuan_Surat_PAC_' . now()->format('Y-m-d_His') . '.xlsx';
    return Excel::download(
        new ArsipPengajuanSuratExport($this->search, $this->filterStatus),
        $filename
    );
}
}
