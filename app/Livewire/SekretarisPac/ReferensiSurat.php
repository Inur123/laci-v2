<?php

namespace App\Livewire\SekretarisPac;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PengajuanSuratPac;
use Illuminate\Pagination\LengthAwarePaginator;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Referensi Surat - PAC')]
class ReferensiSurat extends Component
{
    use WithPagination;

    public $searchName = '';
    public $filterStatus = '';
    public $page = 1;

    // Properties untuk modal detail
    public $showModal = false;
    public $selectedSurat = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearchName()
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

    /**
     * Tampilkan detail surat
     */
    public function showDetail($suratId)
    {
        $this->selectedSurat = PengajuanSuratPac::with('user')->findOrFail($suratId);
        $this->showModal = true;
    }

    /**
     * Tutup modal detail
     */
    public function closeDetail()
    {
        $this->showModal = false;
        $this->selectedSurat = null;
    }

    public function render()
    {
        // Ambil semua data pengajuan surat terbaru
        $pengajuans = PengajuanSuratPac::with('user')->latest()->get();

        // Filter search di collection (karena terenkripsi)
        if ($this->searchName) {
            $search = strtolower($this->searchName); // agar case-insensitive

            $pengajuans = $pengajuans->filter(function($item) use ($search) {
                return str_contains(strtolower($item->user->name ?? ''), $search)
                    || str_contains(strtolower($item->no_surat ?? ''), $search)
                    || str_contains(strtolower($item->penerima ?? ''), $search)
                    || str_contains(strtolower($item->keperluan ?? ''), $search)
                    || str_contains(strtolower($item->deskripsi ?? ''), $search);
            });
        }

        // Filter status (sudah aman)
        if ($this->filterStatus) {
            $pengajuans = $pengajuans->filter(fn($item) => $item->status === $this->filterStatus);
        }

        // Pagination manual
        $page = $this->page ?? 1;
        $perPage = 10;
        $items = $pengajuans->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $items,
            $pengajuans->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.sekretaris-pac.referensi-surat.index', [
            'pengajuans' => $paginator
        ]);
    }
}
