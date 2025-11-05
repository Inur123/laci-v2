<?php

namespace App\Livewire\SekretarisPac;

use App\Models\PengajuanSuratPac;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Pengajuan Surat - PAC')]
class PengajuanSurat extends Component
{
    use WithFileUploads;

    public $action = 'index';
    public $pengajuanId;
    public $search = '';
    public $no_surat;
    public $penerima;
    public $tanggal;
    public $keperluan;
    public $deskripsi;
    public $file;
    public $oldFile;
    public $status = 'pending';

    protected $rules = [
        'no_surat' => 'required|string|max:255',
        'penerima' => 'required|in:ipnu,ippnu,bersama',
        'tanggal' => 'required|date',
        'keperluan' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf|max:5120',
    ];

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }
    }

    public function create()
    {
        $this->reset(['no_surat', 'penerima', 'tanggal', 'keperluan', 'deskripsi', 'file', 'status']);
        $this->action = 'create';
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'no_surat' => $this->no_surat,
            'penerima' => $this->penerima,
            'tanggal' => $this->tanggal,
            'keperluan' => $this->keperluan,
            'deskripsi' => $this->deskripsi,
            'status' => 'pending',
        ];

        if ($this->file) {
            $data['file'] = PengajuanSuratPac::encryptAndStoreFile($this->file);
        }

        PengajuanSuratPac::create($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Pengajuan surat berhasil dikirim!'
        ]);

        $this->action = 'index';
        $this->reset(['no_surat', 'penerima', 'tanggal', 'keperluan', 'deskripsi', 'file', 'status']);
    }

  public function edit($id)
{
    $surat = PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($id);

    // Cegah edit jika status bukan pending
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

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Pengajuan surat berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['pengajuanId', 'no_surat', 'penerima', 'tanggal', 'keperluan', 'deskripsi', 'file', 'oldFile', 'status']);
    }

    public function detail($id)
    {
        $this->pengajuanId = $id;
        $this->action = 'detail';
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

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => 'Pengajuan surat berhasil dihapus!'
            ]);
        }
    }

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-pac.pengajuan-surat.create'),
            'edit' => view('livewire.sekretaris-pac.pengajuan-surat.edit', [
                'surat' => PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($this->pengajuanId)
            ]),
            'detail' => view('livewire.sekretaris-pac.pengajuan-surat.detail', [
                'surat' => PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($this->pengajuanId)
            ]),
            default => view('livewire.sekretaris-pac.pengajuan-surat.index', [
                'surats' => PengajuanSuratPac::where('user_id', Auth::id())->latest()->get()
            ]),
        };
    }
   public function download($id)
{
    $surat = PengajuanSuratPac::where('user_id', Auth::id())->findOrFail($id);

    if (!$surat->file) {
        $this->dispatch('flash', [
            'type' => 'error',
            'message' => 'File tidak tersedia!'
        ]);
        return;
    }

    try {
        $decrypted = $surat->decrypted_file; // Ini HARUS hasil decrypt
        $filename = $surat->no_surat . '.pdf';

        return response()->streamDownload(function () use ($decrypted) {
            echo $decrypted;
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    } catch (\Exception $e) {
        $this->dispatch('flash', [
            'type' => 'error',
            'message' => 'Gagal mengunduh file: ' . $e->getMessage()
        ]);
    }
}
}
