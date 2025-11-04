<?php

namespace App\Livewire\SekretarisCabang\DataAnggota;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Anggota as AnggotaModel;
use App\Models\Periode as PeriodeModel;
use App\Models\User;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Data Anggota')]
class Anggota extends Component
{
    use WithPagination, WithFileUploads;

    public $action = 'index';
    public $anggotaId;
    public $search = '';
    public $filterPeriode = '';
    public $filterUser = '';

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

    protected $rules = [
        'periode_id' => 'required|exists:periodes,id',
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
        'periode_id.required' => 'Periode harus dipilih',
        'periode_id.exists' => 'Periode tidak valid',
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

    public function mount()
    {
        if (Auth::user()->role !== 'sekretaris_cabang') {
            abort(403, 'Akses ditolak');
        }
    }

    // Computed Properties
    #[Computed]
    public function totalAnggota()
    {
        return AnggotaModel::count();
    }

    #[Computed]
    public function anggotaLakiLaki()
    {
        return AnggotaModel::all()->filter(function($anggota) {
            return $anggota->jenis_kelamin === 'Laki-laki';
        })->count();
    }

    #[Computed]
    public function anggotaPerempuan()
    {
        return AnggotaModel::all()->filter(function($anggota) {
            return $anggota->jenis_kelamin === 'Perempuan';
        })->count();
    }

    #[Computed]
    public function periodeList()
    {
        return PeriodeModel::latest()->get();
    }

    #[Computed]
    public function userList()
    {
        // Filter: Hanya user yang aktif, email verified, dan punya anggota
        return User::whereHas('anggotas')
            ->where('is_active', true)  // ✅ Hanya user aktif
            ->whereNotNull('email_verified_at')  // ✅ Email sudah verified
            ->orderBy('role', 'desc')  // Cabang dulu, baru PAC
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function anggotaBySekretarisPac()
    {
        return AnggotaModel::whereHas('user', function($query) {
            $query->where('role', 'sekretaris_pac');
        })->count();
    }

    #[Computed]
    public function anggotaBySekretarisCabang()
    {
        return AnggotaModel::whereHas('user', function($query) {
            $query->where('role', 'sekretaris_cabang');
        })->count();
    }

    public function create()
    {
        $this->reset([
            'periode_id', 'nik', 'nia', 'email', 'foto', 'nama_lengkap',
            'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat_lengkap',
            'no_hp', 'hobi', 'jabatan', 'no_rfid'
        ]);
        $this->action = 'create';
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'periode_id' => $this->periode_id,
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

        // Enkripsi foto jika ada
        if ($this->foto) {
            $data['foto'] = AnggotaModel::encryptAndStoreFoto($this->foto);
        }

        AnggotaModel::create($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Data anggota berhasil ditambahkan!'
        ]);

        $this->action = 'index';
        $this->reset([
            'periode_id', 'nik', 'nia', 'email', 'foto', 'nama_lengkap',
            'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat_lengkap',
            'no_hp', 'hobi', 'jabatan', 'no_rfid'
        ]);
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
        $this->tanggal_lahir = $anggota->tanggal_lahir;
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
            'periode_id' => $this->periode_id,
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

        // Enkripsi foto baru jika ada
        if ($this->foto) {
            // Hapus foto lama
            if ($this->fotoLama && Storage::disk('local')->exists($this->fotoLama)) {
                Storage::disk('local')->delete($this->fotoLama);
            }

            $data['foto'] = AnggotaModel::encryptAndStoreFoto($this->foto);
        }

        $anggota->update($data);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Data anggota berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset([
            'anggotaId', 'periode_id', 'nik', 'nia', 'email', 'foto', 'fotoLama',
            'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
            'alamat_lengkap', 'no_hp', 'hobi', 'jabatan', 'no_rfid'
        ]);
    }

    public function detail($id)
    {
        $this->anggotaId = $id;
        $this->action = 'detail';
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset([
            'anggotaId', 'periode_id', 'nik', 'nia', 'email', 'foto', 'fotoLama',
            'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
            'alamat_lengkap', 'no_hp', 'hobi', 'jabatan', 'no_rfid'
        ]);
    }

    public function delete($id)
    {
        $anggota = AnggotaModel::find($id);

        if ($anggota) {
            // Hapus foto terenkripsi
            if ($anggota->foto && Storage::disk('local')->exists($anggota->foto)) {
                Storage::disk('local')->delete($anggota->foto);
            }

            $anggota->delete();

            $this->dispatch('flash', [
                'type' => 'success',
                'message' => 'Data anggota berhasil dihapus!'
            ]);
        }
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

    public function render()
    {
        return match($this->action) {
            'create' => view('livewire.sekretaris-cabang.data-anggota.create'),
            'edit' => view('livewire.sekretaris-cabang.data-anggota.edit', [
                'anggota' => AnggotaModel::findOrFail($this->anggotaId)
            ]),
            'detail' => view('livewire.sekretaris-cabang.data-anggota.detail', [
                'anggota' => AnggotaModel::findOrFail($this->anggotaId)
            ]),
            default => view('livewire.sekretaris-cabang.data-anggota.index', [
                'anggotas' => $this->getFilteredAnggotas()
            ]),
        };
    }

    // Method untuk filter & search encrypted data
    private function getFilteredAnggotas()
    {
        // Jika ada search, ambil semua data dulu (tanpa pagination)
        if ($this->search) {
            $query = AnggotaModel::with(['periode', 'user'])
                ->when($this->filterPeriode, function($q) {
                    $q->where('periode_id', $this->filterPeriode);
                })
                ->when($this->filterUser, function($q) {
                    $q->where('user_id', $this->filterUser);
                })
                ->latest()
                ->get();

            // Filter setelah decrypt
            $filtered = $query->filter(function($anggota) {
                $searchLower = strtolower($this->search);

                return stripos($anggota->nama_lengkap ?? '', $searchLower) !== false ||
                       stripos($anggota->nik ?? '', $searchLower) !== false ||
                       stripos($anggota->nia ?? '', $searchLower) !== false ||
                       stripos($anggota->email ?? '', $searchLower) !== false ||
                       stripos($anggota->no_hp ?? '', $searchLower) !== false ||
                       stripos($anggota->tempat_lahir ?? '', $searchLower) !== false ||
                       stripos($anggota->jabatan ?? '', $searchLower) !== false;
            });

            // Manual pagination
            $perPage = 10;
            $currentPage = request()->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;

            return new \Illuminate\Pagination\LengthAwarePaginator(
                $filtered->slice($offset, $perPage)->values(),
                $filtered->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        // Jika tidak ada search, pagination biasa
        return AnggotaModel::with(['periode', 'user'])
            ->when($this->filterPeriode, function($query) {
                $query->where('periode_id', $this->filterPeriode);
            })
            ->when($this->filterUser, function($query) {
                $query->where('user_id', $this->filterUser);
            })
            ->latest()
            ->paginate(10);
    }
}
