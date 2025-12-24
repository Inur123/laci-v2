{{-- filepath: resources/views/livewire/sekretaris-pac/referensi-surat/index.blade.php --}}
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Referensi Surat PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Daftar seluruh pengajuan surat dari semua user PAC</p>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Cari Nama User -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama User</label>
                <input type="text" wire:model.live.debounce.500ms="searchName" placeholder="Nama user..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <!-- Tombol Refresh -->
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="$refresh"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg
                hover:bg-green-700 transition text-sm cursor-pointer">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>

        </div>
    </div>


    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        {{-- Header --}}
        <div
            class="p-4 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Referensi Surat PAC</h3>
            <div class="flex items-center gap-2">
                <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">
                    <i class="fas fa-lock mr-1"></i>Data Terenkripsi
                </span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto min-w-full">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No. Surat</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Penerima</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Keperluan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">User</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengajuans as $index => $surat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $pengajuans->firstItem() + $index }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ Str::limit($surat->no_surat, 25) }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ $surat->tanggal ? $surat->tanggal->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ Str::limit($surat->penerima, 25) }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ Str::limit($surat->keperluan, 40) }}
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if ($surat->status === 'pending')
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif($surat->status === 'diterima')
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Diterima
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                        <i class="fas fa-times-circle mr-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ $surat->user->name ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <button wire:click="showDetail('{{ $surat->id }}')"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition cursor-pointer">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                <p>Belum ada data referensi surat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($pengajuans->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $pengajuans->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $pengajuans->lastItem() }}</span>
                        dari <span class="font-medium">{{ $pengajuans->total() }}</span> hasil
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Prev --}}
                        @if ($pengajuans->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $pengajuans->currentPage() - 1 }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        @php
                            $current = $pengajuans->currentPage();
                            $last = $pengajuans->lastPage();

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

                        {{-- First + dots --}}
                        @if ($start > 1)
                            <button wire:click="$set('page', 1)" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                1
                            </button>
                            @if ($start > 2)
                                <span class="px-3 py-2 text-sm text-gray-400">...</span>
                            @endif
                        @endif

                        {{-- Window pages --}}
                        @for ($p = $start; $p <= $end; $p++)
                            @if ($p == $current)
                                <span class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg font-medium">{{ $p }}</span>
                            @else
                                <button wire:click="$set('page', {{ $p }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    {{ $p }}
                                </button>
                            @endif
                        @endfor

                        {{-- Dots + last --}}
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <span class="px-3 py-2 text-sm text-gray-400">...</span>
                            @endif
                            <button wire:click="$set('page', {{ $last }})" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                {{ $last }}
                            </button>
                        @endif

                        {{-- Next --}}
                        @if ($pengajuans->hasMorePages())
                            <button wire:click="$set('page', {{ $pengajuans->currentPage() + 1 }})"
                                wire:loading.attr="disabled"
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

    <!-- Modal Detail (Redesigned) -->
    @if ($showModal && $selectedSurat)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4"
            wire:click="closeDetail">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl h-[95vh] sm:h-auto sm:max-h-[90vh] flex flex-col overflow-hidden"
                wire:click.stop>

                <!-- Modal Header dengan Gradient -->
                <div
                    class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between flex-shrink-0 shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                            <i class="fas fa-envelope-open-text text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-white">Detail Referensi Surat</h3>
                            <p class="text-blue-100 text-xs sm:text-sm">{{ $selectedSurat->no_surat }}</p>
                        </div>
                    </div>
                    <button wire:click="closeDetail"
                        class="text-white/80 hover:text-white transition p-2 hover:bg-white/10 rounded-lg cursor-pointer">
                        <i class="fas fa-times text-lg sm:text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1">
                    <!-- Status Badge -->
                    <div class="flex">
                        @if ($selectedSurat->status === 'pending')
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 shadow-lg">
                                <i class="fas fa-clock mr-2"></i>Pending
                            </span>
                        @elseif($selectedSurat->status === 'diterima')
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 shadow-lg">
                                <i class="fas fa-check-circle mr-2"></i>Diterima
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800 shadow-lg">
                                <i class="fas fa-times-circle mr-2"></i>Ditolak
                            </span>
                        @endif
                    </div>

                    <!-- Info User Pengaju -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="bg-purple-500 p-2 rounded-lg">
                                <i class="fas fa-user-circle text-white text-sm"></i>
                            </div>
                            <h4 class="text-sm font-semibold text-purple-900">Informasi User Pengaju</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-xs text-purple-600 font-medium mb-1">Nama User</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $selectedSurat->user->name ?? '-' }}
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-xs text-purple-600 font-medium mb-1">Email</p>
                                <p class="text-xs font-semibold text-gray-800 break-all">
                                    {{ $selectedSurat->user->email ?? '-' }}</p>
                            </div>

                        </div>
                    </div>

                    <!-- Info Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Penerima -->
                        <div
                            class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-500 p-2 rounded-lg">
                                    <i class="fas fa-user-tag text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-orange-600 font-medium mb-1">Penerima</p>
                                    <p class="font-semibold text-gray-800 capitalize">{{ $selectedSurat->penerima }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-blue-500 p-2 rounded-lg">
                                    <i class="fas fa-calendar text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-blue-600 font-medium mb-1">Tanggal Surat</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ $selectedSurat->tanggal ? $selectedSurat->tanggal->format('d F Y') : '-' }}
                                    </p>
                                    @if ($selectedSurat->tanggal)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $selectedSurat->tanggal->diffForHumans() }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                        <div class="flex items-start gap-3">
                            <div class="bg-green-500 p-2 rounded-lg">
                                <i class="fas fa-clipboard-list text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-green-600 font-medium mb-1">Keperluan Surat</p>
                                <p class="font-semibold text-gray-800">{{ $selectedSurat->keperluan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    @if ($selectedSurat->deskripsi)
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-gray-600 p-2 rounded-lg">
                                    <i class="fas fa-align-left text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-600 font-medium mb-2">Deskripsi Lengkap</p>
                                    <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap">
                                        {{ $selectedSurat->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- File -->
                    @if ($selectedSurat->file)
                        <div
                            class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border border-indigo-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="bg-indigo-500 p-2 rounded-lg">
                                        <i class="fas fa-file-pdf text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-indigo-600 font-medium">File Surat</p>
                                        <p class="text-sm text-gray-700 font-medium">Dokumen tersedia</p>
                                        <p class="text-xs text-indigo-600 mt-1">
                                            <i class="fas fa-shield-alt mr-1"></i>Terenkripsi AES-256
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('pac.pengajuan-pac.view-file', $selectedSurat->id) }}"
                                    target="_blank"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow-lg hover:shadow-xl">
                                    <i class="fas fa-external-link-alt mr-2"></i>Buka
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Timeline -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-clock text-gray-400 text-sm"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Dibuat</p>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $selectedSurat->created_at->format('d F Y, H:i') }}</p>
                                    <p class="text-xs text-gray-500">{{ $selectedSurat->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="border-t border-gray-200"></div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-history text-gray-400 text-sm"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Terakhir Diupdate</p>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $selectedSurat->updated_at->format('d F Y, H:i') }}</p>
                                    <p class="text-xs text-gray-500">{{ $selectedSurat->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Penolakan -->
                    @if ($selectedSurat->status === 'ditolak' && $selectedSurat->catatan)
                        <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-red-900 mb-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Catatan Penolakan
                            </h4>
                            <div class="bg-white rounded-lg p-3 border border-red-200">
                                <p class="text-sm text-red-800 leading-relaxed">{{ $selectedSurat->catatan }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
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
