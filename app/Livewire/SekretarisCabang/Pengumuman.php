<?php

namespace App\Livewire\SekretarisCabang;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Pengumuman as PengumumanModel;
use App\Models\PengumumanRecipient;
use App\Mail\PengumumanMail;

#[Layout('components.layouts.sekretaris-cabang')]
#[Title('Pengumuman')]
class Pengumuman extends Component
{
    use WithPagination;

    public $action = 'index';
    public $pengumumanId;

    public $search = '';
    public $filterStatus = '';

    // custom pagination (tanpa query string)
    public $page = 1;

    // form
    public $judul;
    public $isi;

    // modal detail
    public $showDetailModal = false;
    public $selectedPengumuman = null;

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'judul' => 'required|string|max:150',
        'isi'   => 'required|string|max:5000',
    ];

    protected $messages = [
        'judul.required' => 'Judul harus diisi',
        'isi.required'   => 'Isi pengumuman harus diisi',
    ];

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

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['judul', 'isi', 'pengumumanId']);
        $this->action = 'create';
    }

    public function back()
    {
        $this->action = 'index';
        $this->reset(['judul', 'isi', 'pengumumanId']);
    }

    public function save()
    {
        $user = Auth::user();

        if (!$user->periode_aktif_id) {
            $this->dispatch('flash', [
                'type' => 'error',
                'message' => 'Anda belum memiliki periode aktif! Silakan pilih periode terlebih dahulu.'
            ]);
            return;
        }

        $this->validate();

        PengumumanModel::create([
            'user_id' => $user->id,
            'periode_id' => $user->periode_aktif_id,
            'judul' => $this->judul,
            'isi' => $this->isi,
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Pengumuman berhasil dibuat (Draft). Klik "Kirim" di tabel untuk mengirim email.'
        ]);

        $this->action = 'index';
        $this->reset(['judul', 'isi', 'pengumumanId']);
    }

    public function edit($id)
    {
        $user = Auth::user();

        $p = PengumumanModel::where('user_id', $user->id)->findOrFail($id);

        if ($p->sent_at) {
            $this->dispatch('flash', [
                'type' => 'warning',
                'message' => 'Pengumuman sudah terkirim, tidak bisa diedit.'
            ]);
            return;
        }

        $this->pengumumanId = $p->id;
        $this->judul = $p->judul;
        $this->isi = $p->isi;

        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();

        $user = Auth::user();
        $p = PengumumanModel::where('user_id', $user->id)->findOrFail($this->pengumumanId);

        if ($p->sent_at) {
            $this->dispatch('flash', [
                'type' => 'warning',
                'message' => 'Pengumuman sudah terkirim, tidak bisa diupdate.'
            ]);
            return;
        }

        $p->update([
            'judul' => $this->judul,
            'isi' => $this->isi,
        ]);

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => 'Pengumuman berhasil diupdate!'
        ]);

        $this->action = 'index';
        $this->reset(['judul', 'isi', 'pengumumanId']);
    }

    /**
     * ✅ DESTROY: draft & terkirim boleh dihapus (hapus DB saja)
     * - hapus recipients dulu (aman untuk FK non-cascade)
     * - lalu hapus pengumuman
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $p = PengumumanModel::where('user_id', $user->id)->find($id);
        if (!$p) return;

        $judul = $p->judul;

        DB::transaction(function () use ($p) {
            PengumumanRecipient::where('pengumuman_id', $p->id)->delete();
            $p->delete();
        });

        // kalau modal detail lagi buka untuk item ini, tutup
        if ($this->showDetailModal && $this->selectedPengumuman && $this->selectedPengumuman->id === $id) {
            $this->closeDetail();
        }

        $this->dispatch('flash', [
            'type' => 'success',
            'message' => "Pengumuman '{$judul}' berhasil dihapus!"
        ]);
    }

    /**
     * ✅ Alias biar JS lama @this.call('delete', id) tetap jalan
     */
    public function delete($id)
    {
        return $this->destroy($id);
    }

    public function showDetail($id)
    {
        $user = Auth::user();

        $p = PengumumanModel::where('user_id', $user->id)
            ->with(['recipients' => function ($q) {
                $q->latest()->limit(300);
            }])
            ->findOrFail($id);

        $this->selectedPengumuman = $p;
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedPengumuman = null;
    }

    private function swalSendSuccess(string $title, string $message): void
    {
        $this->dispatch('pengumuman-terkirim', title: $title, message: $message);
    }

    private function swalSendFail(string $title, string $message, string $icon = 'error'): void
    {
        $this->dispatch('pengumuman-gagal', title: $title, message: $message, icon: $icon);
    }

    public function kirimEmail($id)
    {
        @set_time_limit(0);

        $pengirim = Auth::user();
        $p = PengumumanModel::where('user_id', $pengirim->id)->findOrFail($id);

        if ($p->sent_at) {
            $msg = 'Pengumuman ini sudah terkirim.';

            $this->dispatch('flash', ['type' => 'warning', 'message' => $msg]);
            $this->swalSendFail('Sudah terkirim', $msg, 'warning');
            return;
        }

        $periodeId = $p->periode_id;

        $q = User::query()
            ->where('role', 'sekretaris_pac')
            ->where('is_active', true)
            ->whereNotNull('email_verified_at')
            ->whereNotNull('email')
            ->whereNotNull('periode_aktif_id');

        // (Opsional - kalau memang harus 1 periode yang sama, aktifkan ini)
        // ->where('periode_aktif_id', $periodeId);

        $totalTarget = (clone $q)->count();

        Log::info('PENGUMUMAN_SEND_START', [
            'pengumuman_id' => $p->id,
            'pengirim_id' => $pengirim->id,
            'periode_id' => $periodeId,
            'total_target' => $totalTarget,
            'time' => now()->toDateTimeString(),
        ]);

        if ($totalTarget === 0) {
            $msg = 'Tidak ada penerima (PAC) yang aktif & email sudah verified pada periode ini.';

            $this->dispatch('flash', ['type' => 'warning', 'message' => $msg]);
            $this->swalSendFail('Tidak ada penerima', $msg, 'warning');
            return;
        }

        // ✅ bersihkan log lama (biar 1 pengumuman = 1 history pengiriman)
        PengumumanRecipient::where('pengumuman_id', $p->id)->delete();

        $sent = 0;
        $failed = 0;
        $namaPengirim = $pengirim->name ?? 'Sekretaris Cabang';

        try {
            $q->select('id', 'email')
                ->orderBy('id')
                ->chunk(100, function ($users) use (&$sent, &$failed, $p, $namaPengirim) {
                    $rows = [];
                    $ts = now();

                    foreach ($users as $u) {
                        try {
                            Mail::to($u->email)->send(
                                new PengumumanMail($p->judul, $p->isi, $namaPengirim)
                            );
                            $sent++;

                            $rows[] = [
                                'id' => (string) \Illuminate\Support\Str::uuid(),
                                'pengumuman_id' => $p->id,
                                'user_id' => $u->id,
                                'email' => $u->email,
                                'status' => 'sent',
                                'error_message' => null,
                                'sent_at' => $ts,
                                'created_at' => $ts,
                                'updated_at' => $ts,
                            ];
                        } catch (\Exception $e) {
                            $failed++;

                            Log::warning('PENGUMUMAN_SEND_FAILED', [
                                'pengumuman_id' => $p->id,
                                'target_user_id' => $u->id,
                                'target_email' => $u->email,
                                'error' => $e->getMessage(),
                            ]);

                            $rows[] = [
                                'id' => (string) \Illuminate\Support\Str::uuid(),
                                'pengumuman_id' => $p->id,
                                'user_id' => $u->id,
                                'email' => $u->email,
                                'status' => 'failed',
                                'error_message' => $e->getMessage(),
                                'sent_at' => null,
                                'created_at' => $ts,
                                'updated_at' => $ts,
                            ];
                        }
                    }

                    if (!empty($rows)) {
                        PengumumanRecipient::insert($rows);
                    }
                });
        } catch (\Throwable $e) {
            report($e);

            $msg = 'Terjadi kesalahan saat proses pengiriman. Cek log Laravel.';
            $this->dispatch('flash', ['type' => 'error', 'message' => $msg]);
            $this->swalSendFail('Gagal mengirim', $msg, 'error');
            return;
        }

        Log::info('PENGUMUMAN_SEND_FINISH', [
            'pengumuman_id' => $p->id,
            'total_target' => $totalTarget,
            'sent' => $sent,
            'failed' => $failed,
            'time' => now()->toDateTimeString(),
        ]);

        if ($sent === 0) {
            $p->update([
                'sent_to_count' => 0,
                'sent_at' => null,
            ]);

            $msg = "Gagal mengirim pengumuman. Berhasil: {$sent}, Gagal: {$failed}. Cek log Laravel.";
            $this->dispatch('flash', ['type' => 'error', 'message' => $msg]);
            $this->swalSendFail('Gagal mengirim', $msg, 'error');
            return;
        }

        $p->update([
            'sent_to_count' => $sent,
            'sent_at' => now(),
        ]);

        $msg = "Pengumuman terkirim. Target: {$totalTarget}, Berhasil: {$sent}, Gagal: {$failed}.";
        $this->dispatch('flash', ['type' => 'success', 'message' => $msg]);
        $this->swalSendSuccess('Terkirim', $msg);

        // ✅ kalau modal detail sedang buka, refresh data recipients juga
        if ($this->showDetailModal && $this->selectedPengumuman && $this->selectedPengumuman->id === $id) {
            $this->selectedPengumuman = PengumumanModel::with(['recipients' => function ($q) {
                $q->latest()->limit(300);
            }])->find($id);
        }
    }

    private function getStats()
    {
        $user = Auth::user();

        $query = PengumumanModel::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $all = $query->get();

        return [
            'total' => $all->count(),
            'draft' => $all->whereNull('sent_at')->count(),
            'terkirim' => $all->whereNotNull('sent_at')->count(),
        ];
    }

    private function getFilteredItems()
    {
        $user = Auth::user();

        $query = PengumumanModel::where('user_id', $user->id);

        if ($user->periode_aktif_id) {
            $query->where('periode_id', $user->periode_aktif_id);
        }

        $all = $query->latest()->get();

        $filtered = $all->filter(function ($p) {
            $matchSearch = true;
            $matchStatus = true;

            if ($this->search) {
                $s = strtolower($this->search);
                $matchSearch =
                    str_contains(strtolower($p->judul ?? ''), $s) ||
                    str_contains(strtolower($p->isi ?? ''), $s);
            }

            if ($this->filterStatus === 'draft') {
                $matchStatus = empty($p->sent_at);
            } elseif ($this->filterStatus === 'terkirim') {
                $matchStatus = !empty($p->sent_at);
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

    public function render()
    {
        return match ($this->action) {
            'create' => view('livewire.sekretaris-cabang.pengumuman.create'),
            'edit' => view('livewire.sekretaris-cabang.pengumuman.edit', [
                'pengumuman' => PengumumanModel::where('user_id', Auth::id())->findOrFail($this->pengumumanId)
            ]),
            default => view('livewire.sekretaris-cabang.pengumuman.index', [
                'items' => $this->getFilteredItems(),
                'stats' => $this->getStats(),
            ]),
        };
    }
}
