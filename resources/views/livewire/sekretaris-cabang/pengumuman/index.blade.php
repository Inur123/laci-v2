<div>
    {{-- ===================== --}}
    {{-- CSS PROGRESS INDETERMINATE (dipakai juga oleh Swal) --}}
    {{-- ===================== --}}
    <style>
        @keyframes indeterminateBar {
            0% {
                transform: translateX(-120%);
                width: 40%;
            }

            50% {
                transform: translateX(10%);
                width: 60%;
            }

            100% {
                transform: translateX(260%);
                width: 40%;
            }
        }

        .progress-indeterminate {
            animation: indeterminateBar 1.2s infinite ease-in-out;
        }
    </style>

    {{-- ===================== --}}
    {{-- TEMPLATE SWAL PROGRESS (biar class tailwind aman dari purge) --}}
    {{-- ===================== --}}
    <template id="swal-progress-template">
        <div class="text-left">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-paper-plane text-green-600"></i>
                </div>
                <div>
                    <p class="text-base font-semibold text-gray-800">Sedang mengirim pengumuman...</p>
                    <p class="text-xs text-gray-500">Jangan tutup halaman sampai selesai.</p>
                </div>
            </div>

            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-2 bg-green-600 progress-indeterminate"></div>
            </div>

            <p class="mt-4 text-xs text-gray-500 leading-relaxed">
                Sistem sedang mengirim email ke Sekretaris PAC yang aktif & email terverifikasi.
                Proses ini bisa memakan waktu beberapa saat.
            </p>
        </div>
    </template>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengumuman</h1>
        <p class="text-sm text-gray-600 mt-1">Buat pengumuman (draft) lalu kirim ke email Sekretaris PAC</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pengumuman</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['total'] }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-bullhorn text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Draft</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['draft'] }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-pencil-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Terkirim</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['terkirim'] }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-paper-plane text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pengumuman</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Judul atau isi..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua</option>
                    <option value="draft">Draft</option>
                    <option value="terkirim">Terkirim</option>
                </select>
            </div>

            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="create" wire:loading.attr="disabled" wire:target="kirimEmail"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>Buat Pengumuman
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Pengumuman</h3>
            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                <i class="fas fa-filter mr-1"></i>Periode Aktif
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                            No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden sm:table-cell">
                            Terkirim</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $index => $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $items->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-3 text-sm">
                                <div class="font-semibold text-gray-800 whitespace-nowrap">
                                    {{ \Illuminate\Support\Str::limit($p->judul, 40) }}
                                </div>
                                <div class="text-xs text-gray-500 max-w-xl truncate" title="{{ $p->isi }}">
                                    {{ \Illuminate\Support\Str::limit($p->isi, 80) }}
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                @if ($p->sent_at)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>Terkirim
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-pencil-alt mr-1"></i>Draft
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 hidden sm:table-cell whitespace-nowrap">
                                @if ($p->sent_at)
                                    {{ $p->sent_at->format('d M Y H:i') }}
                                    <span class="text-xs text-gray-500">({{ $p->sent_to_count }})</span>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-3 text-lg">
                                    {{-- Detail selalu ada --}}
                                    <button wire:click="showDetail('{{ $p->id }}')" wire:loading.attr="disabled"
                                        wire:target="kirimEmail"
                                        class="text-blue-600 hover:text-blue-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- Tombol Kirim + Edit hanya untuk draft --}}
                                    @if (!$p->sent_at)
                                        <button
                                            onclick="confirmSend('{{ $p->id }}', @js($p->judul))"
                                            wire:loading.attr="disabled" wire:target="kirimEmail"
                                            class="text-green-600 hover:text-green-800 transition-transform hover:scale-110 cursor-pointer"
                                            title="Kirim Email">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>

                                        <button wire:click="edit('{{ $p->id }}')" wire:loading.attr="disabled"
                                            wire:target="kirimEmail"
                                            class="text-yellow-600 hover:text-yellow-800 transition-transform hover:scale-110 cursor-pointer"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif

                                    {{-- Hapus selalu ada (draft/terkirim) --}}
                                    <button
                                        onclick="confirmDelete('{{ $p->id }}', @js($p->judul))"
                                        wire:loading.attr="disabled" wire:target="kirimEmail"
                                        class="text-red-600 hover:text-red-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada data pengumuman</p>
                                @if ($search || $filterStatus)
                                    <p class="text-sm mt-2">Coba ubah filter atau kata kunci pencarian Anda</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($items->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $items->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $items->lastItem() }}</span>
                        dari <span class="font-medium">{{ $items->total() }}</span> hasil
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Prev --}}
                        @if ($items->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $items->currentPage() - 1 }})"
                                wire:loading.attr="disabled" wire:target="kirimEmail"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        @php
                            $current = $items->currentPage();
                            $last = $items->lastPage();

                            $start = max(1, $current - 2);
                            $end = min($last, $current + 2);

                            if ($end - $start < 4) {
                                if ($start == 1) {
                                    $end = min($last, $start + 4);
                                } elseif ($end == $last) {
                                    $start = max(1, $end - 4);
                                }
                            }
                        @endphp

                        {{-- first page + dots --}}
                        @if ($start > 1)
                            <button wire:click="$set('page', 1)" wire:loading.attr="disabled"
                                wire:target="kirimEmail"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                1
                            </button>

                            @if ($start > 2)
                                <span class="px-3 py-2 text-sm text-gray-400">...</span>
                            @endif
                        @endif

                        {{-- page window --}}
                        @for ($pg = $start; $pg <= $end; $pg++)
                            @if ($pg == $current)
                                <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg font-medium">
                                    {{ $pg }}
                                </span>
                            @else
                                <button wire:click="$set('page', {{ $pg }})" wire:loading.attr="disabled"
                                    wire:target="kirimEmail"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    {{ $pg }}
                                </button>
                            @endif
                        @endfor

                        {{-- dots + last page --}}
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <span class="px-3 py-2 text-sm text-gray-400">...</span>
                            @endif

                            <button wire:click="$set('page', {{ $last }})" wire:loading.attr="disabled"
                                wire:target="kirimEmail"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                {{ $last }}
                            </button>
                        @endif

                        {{-- Next --}}
                        @if ($items->hasMorePages())
                            <button wire:click="$set('page', {{ $items->currentPage() + 1 }})"
                                wire:loading.attr="disabled" wire:target="kirimEmail"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Detail -->
    @if ($showDetailModal && $selectedPengumuman)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4"
            wire:click="closeDetail">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl h-[95vh] sm:h-auto sm:max-h-[90vh] flex flex-col overflow-hidden"
                wire:click.stop>

                <div
                    class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between flex-shrink-0 shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                            <i class="fas fa-bullhorn text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-white">Detail Pengumuman</h3>
                            <p class="text-blue-100 text-xs sm:text-sm">{{ $selectedPengumuman->judul }}</p>
                        </div>
                    </div>
                    <button wire:click="closeDetail"
                        class="text-white/80 hover:text-white transition p-2 hover:bg-white/10 rounded-lg cursor-pointer">
                        <i class="fas fa-times text-lg sm:text-xl"></i>
                    </button>
                </div>

                <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1">
                    <div class="flex flex-wrap gap-2">
                        @if ($selectedPengumuman->sent_at)
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 shadow-lg">
                                <i class="fas fa-check mr-2"></i>Terkirim
                            </span>
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 shadow-lg">
                                <i class="fas fa-users mr-2"></i>{{ $selectedPengumuman->sent_to_count }} penerima
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 shadow-lg">
                                <i class="fas fa-pencil-alt mr-2"></i>Draft
                            </span>
                        @endif
                    </div>

                    {{--  FIX BAGIAN ISI PENGUMUMAN --}}
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                        <p class="text-xs text-gray-600 font-medium mb-2">Isi Pengumuman</p>

                        @php
                            $isi = $selectedPengumuman->isi ?? '';

                            // deteksi HTML
                            $isHtml = $isi !== strip_tags($isi);

                            // hapus conditional comment outlook (mso)
                            $cleanHtml = preg_replace('/<!--\[if.*?\[endif\]-->/is', '', $isi);

                            // kalau ada body, ambil hanya isi <body>
                            if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $cleanHtml, $m)) {
                                $cleanHtml = $m[1];
                            }
                        @endphp

                        @if ($isHtml)
                            <div class="prose max-w-none text-gray-800">
                                {!! $cleanHtml !!}
                            </div>
                        @else
                            <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">
                                {!! nl2br(e($isi)) !!}
                            </p>
                        @endif
                    </div>

                    {{--  Tambahan: List email penerima --}}
                    @if ($selectedPengumuman->sent_at)
                        @php
                            $recipients = $selectedPengumuman->recipients ?? collect();
                            $sentCount = $recipients->where('status', 'sent')->count();
                            $failCount = $recipients->where('status', 'failed')->count();
                        @endphp

                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm font-semibold text-gray-800">Riwayat Pengiriman (max 300)</p>
                                <div class="text-xs text-gray-500">
                                    Terkirim: <span class="font-semibold text-green-700">{{ $sentCount }}</span>
                                    • Gagal: <span class="font-semibold text-red-700">{{ $failCount }}</span>
                                </div>
                            </div>

                            @if ($recipients->isEmpty())
                                <p class="text-sm text-gray-500">Belum ada data penerima.</p>
                            @else
                                <div class="max-h-72 overflow-y-auto border border-gray-100 rounded-lg">
                                    <table class="min-w-full text-sm">
                                        <thead class="bg-gray-50 sticky top-0">
                                            <tr>
                                                <th class="text-left px-3 py-2">Email</th>
                                                <th class="text-left px-3 py-2 w-28">Status</th>
                                                <th class="text-left px-3 py-2">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach ($recipients as $r)
                                                <tr>
                                                    <td class="px-3 py-2 text-gray-700 whitespace-nowrap">
                                                        {{ $r->email }}
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        @if ($r->status === 'sent')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                                <i class="fas fa-check mr-1"></i>Sent
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">
                                                                <i class="fas fa-times mr-1"></i>Failed
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 py-2 text-gray-500">
                                                        @if ($r->status === 'failed')
                                                            {{ \Illuminate\Support\Str::limit($r->error_message, 140) }}
                                                        @else
                                                            {{ $r->sent_at?->format('d M Y H:i') ?? '-' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-clock text-gray-400 text-sm"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Dibuat</p>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $selectedPengumuman->created_at->format('d F Y, H:i') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $selectedPengumuman->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <div class="flex items-center gap-3">
                                <i class="fas fa-history text-gray-400 text-sm"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Terakhir Diupdate</p>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $selectedPengumuman->updated_at->format('d F Y, H:i') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $selectedPengumuman->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @if ($selectedPengumuman->sent_at)
                                <div class="border-t border-gray-200"></div>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-paper-plane text-gray-400 text-sm"></i>
                                    <div>
                                        <p class="text-xs text-gray-500">Terkirim</p>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $selectedPengumuman->sent_at->format('d F Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div
                    class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 flex justify-end flex-shrink-0 shadow-lg">
                    <button wire:click="closeDetail"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition cursor-pointer">
                        <i class="fas fa-times mr-2"></i>Tutup
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>

<script>
    function confirmDelete(id, judul) {
        Swal.fire({
            title: 'Hapus Pengumuman?',
            html: `Pengumuman <strong>${judul}</strong> akan dihapus secara permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-medium shadow-lg',
                cancelButton: 'px-6 py-2.5 rounded-lg font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', id);
            }
        });
    }

    function confirmSend(id, judul) {
        Swal.fire({
            title: 'Kirim Pengumuman?',
            html: `Pengumuman <strong>${judul}</strong> akan dikirim ke email Sekretaris PAC (verified). Setelah terkirim, pengumuman akan terkunci.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-paper-plane mr-2"></i>Ya, Kirim!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-medium shadow-lg',
                cancelButton: 'px-6 py-2.5 rounded-lg font-medium'
            }
        }).then((result) => {
            if (!result.isConfirmed) return;

            const tpl = document.getElementById('swal-progress-template');

            Swal.fire({
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                width: 520,
                backdrop: true,
                customClass: {
                    popup: 'rounded-xl shadow-2xl',
                    htmlContainer: 'm-0'
                },
                html: tpl ? tpl.innerHTML : 'Sedang mengirim...',

                didOpen: () => {
                    @this.call('kirimEmail', id);
                }
            });
        });
    }

    // Listener event Livewire v3: tutup swal loading + tampilkan hasil
    document.addEventListener('livewire:init', () => {
        if (window.__pengumumanSwalListenerInstalled) return;
        window.__pengumumanSwalListenerInstalled = true;

        //  Tutup swal progress kapan pun disuruh livewire
        Livewire.on('close-progress', () => {
            Swal.close();
        });

        Livewire.on('pengumuman-terkirim', (payload = {}) => {
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: payload.title ?? 'Berhasil',
                text: payload.message ?? 'Pengumuman berhasil dikirim.'
            });
        });

        Livewire.on('pengumuman-gagal', (payload = {}) => {
            Swal.close();
            Swal.fire({
                icon: payload.icon ?? 'error',
                title: payload.title ?? 'Gagal',
                text: payload.message ?? 'Pengiriman gagal. Silakan coba lagi.'
            });
        });
    });
</script>
<script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin">
</script>

<script>
    document.addEventListener('livewire:init', () => {

        function initTinyMCE() {
            if (typeof tinymce === "undefined") return;

            const el = document.querySelector('#isiEditor');
            if (!el) return;

            if (tinymce.get('isiEditor')) return;

            const componentEl = el.closest('[wire\\:id]');
            if (!componentEl) return;

            const componentId = componentEl.getAttribute('wire:id');
            const component = Livewire.find(componentId);
            if (!component) return;

            tinymce.init({
                selector: '#isiEditor',
                height: 400,
                menubar: true,
                plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount help emoticons',
                toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | fullscreen preview | image media link codesample',

                setup: function(editor) {

                    editor.on('init', function() {
                        const isi = component.get('isi') || '';
                        editor.setContent(isi);
                    });

                    editor.on('change keyup paste', function() {
                        component.set('isi', editor.getContent());
                    });
                }
            });
        }

        initTinyMCE();

        Livewire.hook('morph.updated', () => {
            initTinyMCE();
        });

        Livewire.on('set-editor-content', (content) => {
            if (tinymce.get('isiEditor')) {
                tinymce.get('isiEditor').setContent(content || '');
            } else {
                initTinyMCE();
                setTimeout(() => {
                    tinymce.get('isiEditor')?.setContent(content || '');
                }, 200);
            }
        });

        Livewire.on('destroy-editor', () => {
            if (tinymce.get('isiEditor')) {
                tinymce.get('isiEditor').remove();
            }
        });

    });
</script>
