<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengumuman</h1>
        <p class="text-sm text-gray-600 mt-1">Daftar pengumuman dari Sekretaris Cabang</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
                    <p class="text-gray-500 text-sm">Terkirim</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['terkirim'] }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-paper-plane text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pengumuman</label>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Judul atau isi..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Pengumuman</h3>
            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                <i class="fas fa-filter mr-1"></i>Pengumuman untuk Anda
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden md:table-cell">Pengirim</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Terkirim</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
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

                            <td class="px-4 py-3 text-sm text-gray-700 hidden md:table-cell whitespace-nowrap">
                                {{ $p->user?->name ?? '-' }}
                                <div class="text-xs text-gray-500">{{ $p->user?->email ?? '' }}</div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $p->sent_at?->format('d M Y H:i') ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-3 text-lg">
                                    <button wire:click="showDetail('{{ $p->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada pengumuman</p>
                                @if($search)
                                    <p class="text-sm mt-2">Coba ubah kata kunci pencarian Anda</p>
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
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        @php
                            $current = $items->currentPage();
                            $last = $items->lastPage();

                            $start = max(1, $current - 2);
                            $end = min($last, $current + 2);

                            if (($end - $start) < 4) {
                                if ($start == 1) {
                                    $end = min($last, $start + 4);
                                } elseif ($end == $last) {
                                    $start = max(1, $end - 4);
                                }
                            }
                        @endphp

                        {{-- first page + dots --}}
                        @if ($start > 1)
                            <button wire:click="$set('page', 1)"
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
                                <button wire:click="$set('page', {{ $pg }})"
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

                            <button wire:click="$set('page', {{ $last }})"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                {{ $last }}
                            </button>
                        @endif

                        {{-- Next --}}
                        @if ($items->hasMorePages())
                            <button wire:click="$set('page', {{ $items->currentPage() + 1 }})"
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

                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between flex-shrink-0 shadow-lg">
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
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 shadow-lg">
                            <i class="fas fa-check mr-2"></i>Terkirim
                        </span>
                    </div>

                    {{-- Pengirim --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <p class="text-xs text-gray-600 font-medium mb-2">Pengirim (Sekretaris Cabang)</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $selectedPengumuman->user?->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $selectedPengumuman->user?->email ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                        <p class="text-xs text-gray-600 font-medium mb-2">Isi Pengumuman</p>
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $selectedPengumuman->isi }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-clock text-gray-400 text-sm"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Dibuat</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $selectedPengumuman->created_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            <div class="flex items-center gap-3">
                                <i class="fas fa-paper-plane text-gray-400 text-sm"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Terkirim</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $selectedPengumuman->sent_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 flex justify-end flex-shrink-0 shadow-lg">
                    <button wire:click="closeDetail"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition cursor-pointer">
                        <i class="fas fa-times mr-2"></i>Tutup
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
