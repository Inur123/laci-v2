<?php

namespace App\Livewire\SekretarisCabang\DataAnggota;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota as AnggotaModel;
use App\Models\Periode as PeriodeModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\SekretarisCabang\DataAnggotaExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Data Anggota')]
class Anggota extends Component
{
    use WithFileUploads;

    public $action = 'index';
    public $anggotaId;
    public $search = '';
    public $filterPeriode = '';
    public $filterUser = '';
    public $page = 1; // Custom pagination

    // Form properties
    public $periode_id;
    public $nik;
    public $nia;
    public $email;
    public $foto;
    public $fotoLama;
    public $nama_lengkap;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat_lengkap;
    public $no_hp;
    public $hobi;
    public $jabatan;
    public $no_rfid;
    public $exportUserId = null;

    protected $rules = [
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'nik' => 'nullable|string|max:16',
        'nia' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'foto' => 'nullable|image|max:2048',
        'tempat_lahir' => 'nullable|string|max:255',
        'tanggal_lahir' => 'nullable|date',
        'alamat_lengkap' => 'nullable|string',
        'no_hp' => 'nullable|string|max:15',
        'hobi' => 'nullable|string|max:255',
        'jabatan' => 'nullable|string|max:255',
        'no_rfid' => 'nullable|string|max:20',
    ];

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap harus diisi',
        'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter',
        'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
        'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
        'foto.image' => 'File harus berupa gambar',
        'foto.max' => 'Ukuran foto maksimal 2MB',
        'email.email' => 'Format email tidak valid',
        'nik.max' => 'NIK maksimal 16 karakter',
        'nia.max' => 'NIA maksimal 20 karakter',
        'no_hp.max' => 'No. HP maksimal 15 karakter',
    ];

    #[On('periodeChanged')]
    public function refreshData()
    {
        $this->page = 1;
    }

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    public function resetPage()
    {
        $this->page = 1;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterPeriode()
    {
        $this->resetPage();
    }
    public function updatingFilterUser()
    {
        $this->resetPage();
    }

    #[Computed]
    public function periodeList()
    {
        return PeriodeModel::where('user_id', Auth::id())->latest()->get();
    }

    #[Computed]
    public function userList()
    {
        return User::whereHas('anggotas')
            ->where('is_active', true)
            ->whereNotNull('email_verified_at')
            ->orderBy('role', 'desc')
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function statsAnggota()
    {
        $user = Auth::user();
        $query = AnggotaModel::query();

        if (!$this->filterPeriode && $user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        if ($this->filterPeriode) $query->where('periode_id', $this->filterPeriode);
        if ($this->filterUser) $query->where('user_id', $this->filterUser);
        $all = $query->get();

        return [
            'total' => $all->count(),
            'laki' => $all->where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => $all->where('jenis_kelamin', 'Perempuan')->count(),
            'pac' => $all->where('user.role', 'sekretaris_pac')->count(),
            'cab' => $all->where('user.role', 'sekretaris_cabang')->count(),
        ];
    }

    public function create()
    {
        $this->reset([
            'periode_id',
            'nik',
            'nia',
            'email',
            'foto',
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat_lengkap',
            'no_hp',
            'hobi',
            'jabatan',
            'no_rfid'
        ]);
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
            'nama_lengkap' => $this->nama_lengkap,
            'jenis_kelamin' => $this->jenis_kelamin,
            'nik' => $this->nik,
            'nia' => $this->nia,
            'email' => $this->email,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat_lengkap' => $this->alamat_lengkap,
            'no_hp' => $this->no_hp,
            'hobi' => $this->hobi,
            'jabatan' => $this->jabatan,
            'no_rfid' => $this->no_rfid,
        ];

        if ($this->foto) {
            $data['foto'] = AnggotaModel::encryptAndStoreFoto($this->foto);
        }

        AnggotaModel::create($data);

        $this->dispatch('flash', ['type' => 'success', 'message' => 'Data anggota berhasil ditambahkan!']);
        $this->action = 'index';
        $this->reset(['periode_id', 'nik', 'nia', 'email', 'foto', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat_lengkap', 'no_hp', 'hobi', 'jabatan', 'no_rfid']);
    }

    public function edit($id)
    {
        $anggota = AnggotaModel::findOrFail($id);
        $this->anggotaId = $id;
        $this->periode_id = $anggota->periode_id;
        $this->nik = $anggota->nik;
        $this->nia = $anggota->nia;
        $this->email = $anggota->email;
        $this->fotoLama = $anggota->foto;
        $this->nama_lengkap = $anggota->nama_lengkap;
        $this->tempat_lahir = $anggota->tempat_lahir;
        $this->tanggal_lahir = $anggota->tanggal_lahir?->format('Y-m-d');
        $this->jenis_kelamin = $anggota->jenis_kelamin;
        $this->alamat_lengkap = $anggota->alamat_lengkap;
        $this->no_hp = $anggota->no_hp;
        $this->hobi = $anggota->hobi;
        $this->jabatan = $anggota->jabatan;
        $this->no_rfid = $anggota->no_rfid;
        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();
        $anggota = AnggotaModel::findOrFail($this->anggotaId);
        $data = [
            'nama_lengkap' => $this->nama_lengkap,
            'jenis_kelamin' => $this->jenis_kelamin,
            'nik' => $this->nik,
            'nia' => $this->nia,
            'email' => $this->email,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat_lengkap' => $this->alamat_lengkap,
            'no_hp' => $this->no_hp,
            'hobi' => $this->hobi,
            'jabatan' => $this->jabatan,
            'no_rfid' => $this->no_rfid,
        ];

        if ($this->foto) {
            if ($this->fotoLama && Storage::disk('local')->exists($this->fotoLama)) {
                Storage::disk('local')->delete($this->fotoLama);
            }
            $data['foto'] = AnggotaModel::encryptAndStoreFoto($this->foto);
        }

        $anggota->update($data);

        $this->dispatch('flash', ['type' => 'success', 'message' => 'Data anggota berhasil diupdate!']);
        $this->action = 'index';
        $this->reset(['anggotaId', 'periode_id', 'nik', 'nia', 'email', 'foto', 'fotoLama', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat_lengkap', 'no_hp', 'hobi', 'jabatan', 'no_rfid']);
    }

    public function detail($id)
    {
        $this->anggotaId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['anggotaId', 'periode_id', 'nik', 'nia', 'email', 'foto', 'fotoLama', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat_lengkap', 'no_hp', 'hobi', 'jabatan', 'no_rfid']);
    }

    public function delete($id)
    {
        $anggota = AnggotaModel::find($id);
        if ($anggota) {
            if ($anggota->foto && Storage::disk('local')->exists($anggota->foto)) {
                Storage::disk('local')->delete($anggota->foto);
            }
            $anggota->delete();
            $this->dispatch('flash', ['type' => 'success', 'message' => 'Data anggota berhasil dihapus!']);
        }
    }

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-cabang.data-anggota.create'),
            'edit' => view('livewire.sekretaris-cabang.data-anggota.edit', [
                'anggota' => AnggotaModel::findOrFail($this->anggotaId)
            ]),
            'detail' => view('livewire.sekretaris-cabang.data-anggota.detail', [
                'anggota' => AnggotaModel::findOrFail($this->anggotaId)
            ]),
            default => view('livewire.sekretaris-cabang.data-anggota.index', [
                'anggotas' => $this->getFilteredAnggotas(),
            ]),
        };
    }

    private function getFilteredAnggotas()
    {
        $user = Auth::user();

        $query = AnggotaModel::with(['periode', 'user']);

        if ($user->periode_aktif_id && !$this->filterPeriode) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $query->when($this->filterPeriode, fn($q) => $q->where('periode_id', $this->filterPeriode))
            ->when($this->filterUser, fn($q) => $q->where('user_id', $this->filterUser));

        $allData = $query->latest()->get();

        $filtered = $allData;

        if ($this->search) {
            $searchLower = strtolower($this->search);
            $filtered = $allData->filter(
                fn($anggota) =>
                str_contains(strtolower($anggota->nama_lengkap ?? ''), $searchLower) ||
                    str_contains(strtolower($anggota->nik ?? ''), $searchLower) ||
                    str_contains(strtolower($anggota->nia ?? ''), $searchLower) ||
                    str_contains(strtolower($anggota->email ?? ''), $searchLower) ||
                    str_contains(strtolower($anggota->no_hp ?? ''), $searchLower) ||
                    str_contains(strtolower($anggota->tempat_lahir ?? ''), $searchLower) ||
                    str_contains(strtolower($anggota->jabatan ?? ''), $searchLower)
            );
        }

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
        $userName = null;

        if ($this->exportUserId) {
            $user = User::find($this->exportUserId);
            $userName = $user ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $user->name) : null;
        }

        $periodeId = $this->filterPeriode ?: null;

        $filename = 'Data_Anggota_' . ($userName ? $userName . '_' : 'Semua_') . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new DataAnggotaExport($this->exportUserId, $periodeId),
            $filename
        );
    }

    #[Computed]
    public function exportUsers()
    {
        return User::whereHas('anggotas')
            ->where('is_active', true)
            ->whereNotNull('email_verified_at')
            ->orderBy('name')
            ->get();
    }
}
