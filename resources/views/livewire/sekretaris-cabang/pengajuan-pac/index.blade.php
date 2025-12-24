<!-- filepath: resources/views/livewire/sekretaris-cabang/pengajuan-pac/index.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengajuan Surat PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola pengajuan surat dari seluruh PAC</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Total Pengajuan</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $total }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-envelope-open-text text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Pending</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $pending }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-clock text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Diterima</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $diterima }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-check-circle text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Excel -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Export Pengajuan (PAC)</label>
                <select wire:model="exportUserId"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua Pengajuan</option>
                    @foreach ($this->exportUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <form wire:submit.prevent="export" class="w-full">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                        <span wire:loading.remove wire:target="export">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </span>
                        <span wire:loading wire:target="export">
                            <i class="fas fa-spinner fa-spin"></i>
                            Mengunduh...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Surat</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="No Surat atau Keperluan..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="$refresh"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm cursor-pointer">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Pengajuan Surat PAC</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No Surat</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pengirim</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Penerima</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Keperluan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengajuans as $index => $surat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $pengajuans->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                                {{ $surat->no_surat }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold mr-2">
                                        {{ strtoupper(substr($surat->user->name ?? '?', 0, 2)) }}
                                    </div>
                                    <span class="font-medium">{{ $surat->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 capitalize whitespace-nowrap">
                                {{ $surat->penerima }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 hidden sm:table-cell whitespace-nowrap">
                                {{ $surat->tanggal?->format('d M Y') ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate" title="{{ $surat->keperluan }}">
                                {{ $surat->keperluan }}
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                @if ($surat->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif($surat->status === 'diterima')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Diterima
                                    </span>
                                @elseif($surat->status === 'ditolak')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <button wire:click="detail('{{ $surat->id }}')"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition cursor-pointer">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span class="hidden sm:inline">Lihat</span>
                                    <span class="sm:hidden">Detail</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-envelope-open-text text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada pengajuan surat PAC</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination (WINDOWED) -->
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

                            {{-- Windowed page numbers --}}
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

                            {{-- first page + dots --}}
                            @if ($start > 1)
                                <button wire:click="$set('page', 1)" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    1
                                </button>
                                @if ($start > 2)
                                    <span class="px-3 py-2 text-sm text-gray-400">...</span>
                                @endif
                            @endif

                            {{-- window --}}
                            @for ($p = $start; $p <= $end; $p++)
                                @if ($p == $current)
                                    <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg font-medium">
                                        {{ $p }}
                                    </span>
                                @else
                                    <button wire:click="$set('page', {{ $p }})" wire:loading.attr="disabled"
                                        class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        {{ $p }}
                                    </button>
                                @endif
                            @endfor

                            {{-- dots + last --}}
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
    </div>
</div>

<script>
    function confirmApprove(id) {
        Swal.fire({
            title: 'Setujui Surat?',
            text: 'Surat ini akan disetujui dan diproses lebih lanjut.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Setujui!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: { confirmButton: 'px-4 py-2 rounded-lg', cancelButton: 'px-4 py-2 rounded-lg' }
        }).then((result) => {
            if (result.isConfirmed) @this.call('approve', id);
        });
    }

    function confirmReject(id) {
        Swal.fire({
            title: 'Tolak Surat?',
            text: 'Surat ini akan ditolak dan tidak diproses.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-times mr-2"></i>Ya, Tolak!',
            cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
            reverseButtons: true,
            customClass: { confirmButton: 'px-4 py-2 rounded-lg', cancelButton: 'px-4 py-2 rounded-lg' }
        }).then((result) => {
            if (result.isConfirmed) @this.call('reject', id);
        });
    }
</script>
