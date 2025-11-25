<?php

namespace App\Livewire\SekretarisCabang;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PengajuanSuratPac;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Pengajuan PAC')]
class PengajuanPac extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $detailId = null;
    public $detailData = null;
    public $page = 1;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }
    public function resetPage()
    {
        $this->page = 1;
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function detail($id)
    {
        try {
            $surat = PengajuanSuratPac::with('user')->findOrFail($id);
            $this->detailId = $id;
            $this->detailData = [
                'id' => $surat->id,
                'no_surat' => $surat->no_surat,
                'penerima' => $surat->penerima,
                'tanggal' => $surat->tanggal,
                'tanggal_formatted' => $surat->tanggal ? $surat->tanggal->format('d F Y') : '-',
                'keperluan' => $surat->keperluan,
                'deskripsi' => $surat->deskripsi ?? '-',
                'status' => $surat->status,
                'has_file' => !empty($surat->file),
                'file' => $surat->file ?? null,
                'created_at_formatted' => $surat->created_at ? $surat->created_at->format('d F Y H:i') : '-',
                'updated_at_formatted' => $surat->updated_at ? $surat->updated_at->format('d F Y H:i') : '-',
                'user' => [
                    'id' => $surat->user->id ?? null,
                    'name' => $surat->user->name ?? '-',
                    'email' => $surat->user->email ?? '-',
                ]
            ];
            $this->dispatch('openDetailModal', data: $this->detailData);
        } catch (\Exception $e) {
            $this->dispatch('flash', ['type' => 'error', 'message' => 'Data tidak ditemukan!']);
        }
    }

    public function approve($id)
    {
        $this->setStatus($id, 'diterima', 'Surat berhasil disetujui!');
    }
    public function reject($id)
    {
        $this->setStatus($id, 'ditolak', 'Surat berhasil ditolak!');
    }

    private function setStatus($id, $status, $message)
    {
        try {
            $surat = PengajuanSuratPac::findOrFail($id);
            if ($surat->status === 'pending') {
                $surat->status = $status;
                $surat->last_status_changed_at = now();
                $surat->save();
                $this->dispatch('flash', ['type' => 'success', 'message' => $message]);
                if ($this->detailId == $id) $this->detail($id);
            } else {
                $this->dispatch('flash', ['type' => 'warning', 'message' => 'Surat sudah diproses sebelumnya!']);
            }
        } catch (\Exception $e) {
            $this->dispatch('flash', ['type' => 'error', 'message' => 'Terjadi kesalahan saat memproses surat!']);
        }
    }

    public function render()
    {
        $allStats = PengajuanSuratPac::with('user')->latest()->get();
        $total = $allStats->count();
        $pending = $allStats->filter(fn($s) => $s->status === 'pending')->count();
        $diterima = $allStats->filter(fn($s) => $s->status === 'diterima')->count();
        $all = $allStats;

        if ($this->search) {
            $search = strtolower($this->search);
            $all = $all->filter(
                fn($item) =>
                str_contains(strtolower($item->no_surat), $search)
                    || str_contains(strtolower($item->keperluan), $search)
            );
        }

        if ($this->filterStatus) {
            $all = $all->filter(fn($item) => $item->status === $this->filterStatus);
        }

        $perPage = 10;
        $items = $all->slice(($this->page - 1) * $perPage, $perPage)->values();
        $pengajuans = new LengthAwarePaginator($items, $all->count(), $perPage, $this->page, ['path' => request()->url()]);

        if ($this->detailId && $this->detailData) {
            return view('livewire.sekretaris-cabang.pengajuan-pac.detail', ['detail' => $this->detailData]);
        }

        return view('livewire.sekretaris-cabang.pengajuan-pac.index', [
            'pengajuans' => $pengajuans,
            'total' => $total,
            'pending' => $pending,
            'diterima' => $diterima,
        ]);
    }
}
