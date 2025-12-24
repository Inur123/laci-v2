<?php


namespace App\Livewire\SekretarisCabang;

use App\Models\Kegiatan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Kalender Kegiatan')]
class KalenderKegiatan extends Component
{
    use WithPagination;

    public $action = 'index';
    public $kegiatanId;
    public $search = '';
    public $filterStatus = '';
    public $currentMonth;
    public $currentYear;

    // Form properties
    public $judul;
    public $deskripsi;
    public $lokasi;
    public $warna = '#3788d8';
    public $tanggal_mulai;
    public $tanggal_selesai;

    protected $rules = [
        'judul' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'lokasi' => 'nullable|string|max:255',
        'warna' => 'required|string|regex:/^#([A-Fa-f0-9]{6})$/',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
    ];

    protected $messages = [
        'judul.required' => 'Judul kegiatan harus diisi',
        'warna.required' => 'Warna harus dipilih',
        'warna.regex' => 'Format warna tidak valid',
        'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
        'tanggal_mulai.date' => 'Format tanggal tidak valid',
        'tanggal_selesai.date' => 'Format tanggal tidak valid',
        'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
    ];

    #[On('periodeChanged')]
    public function refreshData()
    {
        // Refresh data saat periode berubah
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }

        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    // Computed Properties untuk Stats
    #[Computed]
    public function totalKegiatan()
    {
        $user = Auth::user();
        $query = Kegiatan::query();

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    #[Computed]
    public function kegiatanBulanIni()
    {
        $user = Auth::user();
        $query = Kegiatan::inMonth(now()->year, now()->month);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    #[Computed]
    public function kegiatanMendatang()
    {
        $user = Auth::user();
        $query = Kegiatan::upcoming();

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    #[Computed]
    public function kegiatanSelesai()
    {
        $user = Auth::user();
        $query = Kegiatan::past();

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->count();
    }

    #[Computed]
    public function upcomingEvents()
    {
        $user = Auth::user();
        $query = Kegiatan::upcoming()->take(5);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        return $query->get();
    }

    public function create()
    {
        $this->reset(['judul', 'deskripsi', 'lokasi', 'warna', 'tanggal_mulai', 'tanggal_selesai']);
        $this->warna = '#3788d8';
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

        Kegiatan::create([
            'user_id' => Auth::id(),
            'periode_id' => Auth::user()->periode_aktif_id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'lokasi' => $this->lokasi,
            'warna' => $this->warna,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Kegiatan berhasil ditambahkan!'
        ]);

        $this->action = 'index';
        $this->reset(['judul', 'deskripsi', 'lokasi', 'warna', 'tanggal_mulai', 'tanggal_selesai']);
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $this->kegiatanId = $id;
        $this->judul = $kegiatan->judul;
        $this->deskripsi = $kegiatan->deskripsi;
        $this->lokasi = $kegiatan->lokasi;
        $this->warna = $kegiatan->warna;
        $this->tanggal_mulai = $kegiatan->tanggal_mulai->format('Y-m-d\TH:i');
        $this->tanggal_selesai = $kegiatan->tanggal_selesai?->format('Y-m-d\TH:i');

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();

        $kegiatan = Kegiatan::findOrFail($this->kegiatanId);

        $kegiatan->update([
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'lokasi' => $this->lokasi,
            'warna' => $this->warna,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Kegiatan berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['judul', 'deskripsi', 'lokasi', 'warna', 'tanggal_mulai', 'tanggal_selesai', 'kegiatanId']);
    }

    public function detail($id)
    {
        $this->kegiatanId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['judul', 'deskripsi', 'lokasi', 'warna', 'tanggal_mulai', 'tanggal_selesai', 'kegiatanId']);
    }

    public function delete($id)
    {
        $kegiatan = Kegiatan::find($id);

        if ($kegiatan) {
            $kegiatan->delete();

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => 'Kegiatan berhasil dihapus!'
            ]);
        }
    }

    public function previousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        }
    }

    public function nextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
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
        $user = Auth::user();

        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.kalender-kegiatan.create'),
            'edit' => view('livewire.sekretaris-cabang.kalender-kegiatan.edit', [
                'kegiatan' => Kegiatan::findOrFail($this->kegiatanId)
            ]),
            'detail' => view('livewire.sekretaris-cabang.kalender-kegiatan.detail', [
                'kegiatan' => Kegiatan::findOrFail($this->kegiatanId)
            ]),
            default => view('livewire.sekretaris-cabang.kalender-kegiatan.index', [
                'kegiatans' => Kegiatan::query()
                    ->when($user->periode_aktif_id, function($query) use ($user) {
                        $query->where('periode_id', $user->periode_aktif_id);
                    })
                    ->when($this->search, function($query) {
                        $query->where('judul', 'like', '%' . $this->search . '%')
                              ->orWhere('lokasi', 'like', '%' . $this->search . '%')
                              ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                    })
                    ->when($this->filterStatus === 'upcoming', function($query) {
                        $query->upcoming();
                    })
                    ->when($this->filterStatus === 'past', function($query) {
                        $query->past();
                    })
                    ->latest('tanggal_mulai')
                    ->paginate(10),
                'calendarEvents' => Kegiatan::query()
                    ->when($user->periode_aktif_id, function($query) use ($user) {
                        $query->where('periode_id', $user->periode_aktif_id);
                    })
                    ->inMonth($this->currentYear, $this->currentMonth)
                    ->get()
            ]),
        };
    }
}
