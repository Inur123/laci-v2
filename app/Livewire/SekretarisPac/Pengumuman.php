<?php

namespace App\Livewire\SekretarisPac;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Pengumuman as PengumumanModel;

#[Layout('components.layouts.sekretaris-pac')]
#[Title('Pengumuman')]
class Pengumuman extends Component
{
    public $search = '';

    // custom pagination (tanpa query string)
    public $page = 1;

    // modal detail
    public $showDetailModal = false;
    public $selectedPengumuman = null;

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_pac') {
            abort(403, 'Akses ditolak');
        }
    }

    public function resetPageCustom()
    {
        $this->page = 1;
    }

    public function updatingSearch()
    {
        $this->resetPageCustom();
    }

    /**
     * ✅ Query utama: hanya pengumuman yang memang dikirim ke PAC ini
     * via tabel pengumuman_recipients (user_id PAC).
     */
    private function baseQuery()
    {
        $user = Auth::user();
        $search = trim($this->search);

        return PengumumanModel::query()
            ->whereNotNull('sent_at')
            ->whereHas('recipients', function ($q) use ($user) {
                $q->where('user_id', $user->id);
                // kalau mau hanya yang benar-benar sukses terkirim ke user ini:
                // $q->where('status', 'sent');
            })
            ->with(['user:id,name,email'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('judul', 'like', "%{$search}%")
                        ->orWhere('isi', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('sent_at')
            ->orderByDesc('created_at');
    }

    private function getStats()
    {
        $total = (clone $this->baseQuery())->count();

        return [
            'total' => $total,
            'terkirim' => $total,
        ];
    }

    private function getFilteredItems()
    {
        $perPage = 10;
        $currentPage = max(1, (int) $this->page);

        $query = $this->baseQuery();

        $total = (clone $query)->count();

        $items = (clone $query)
            ->forPage($currentPage, $perPage)
            ->get();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
    }

    public function showDetail($id)
    {
        $user = Auth::user();

        // ✅ Pastikan detail hanya boleh buka pengumuman yang memang dikirim ke user ini
        $this->selectedPengumuman = PengumumanModel::query()
            ->whereNotNull('sent_at')
            ->whereHas('recipients', function ($q) use ($user) {
                $q->where('user_id', $user->id);
                // optional:
                // $q->where('status', 'sent');
            })
            ->with(['user:id,name,email'])
            ->findOrFail($id);

        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedPengumuman = null;
    }

    public function render()
    {
        return view('livewire.sekretaris-pac.pengumuman.index', [
            'items' => $this->getFilteredItems(),
            'stats' => $this->getStats(),
        ]);
    }
}
