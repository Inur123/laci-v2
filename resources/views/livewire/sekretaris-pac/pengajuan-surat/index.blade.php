<!-- filepath: resources/views/livewire/sekretaris-pac/pengajuan-surat/index.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengajuan Surat PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Daftar pengajuan surat yang Anda buat</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Total Pengajuan</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $stats['total'] }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-envelope text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Pending</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $stats['pending'] }}</h3>
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
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $stats['diterima'] }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-check-circle text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Ditolak</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $stats['ditolak'] }}</h3>
                </div>
                <div class="bg-red-100 text-red-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-times-circle text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Surat</label>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="No surat, keperluan, penerima..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="export" wire:loading.attr="disabled"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm disabled:opacity-50 cursor-pointer">
                    <span wire:loading.remove wire:target="export">
                        <i class="fas fa-file-excel mr-2"></i>Export Excel
                    </span>
                    <span wire:loading wire:target="export">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Mengunduh...
                    </span>
                </button>
            </div>
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="create"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg
               hover:bg-blue-700 transition text-sm
               flex items-center justify-center cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>Ajukan Surat
                </button>
            </div>

        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Pengajuan Surat</h3>
            <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">
                <i class="fas fa-lock mr-1"></i>Data Terenkripsi
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                            No
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            No Surat
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Penerima
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden sm:table-cell">
                            Tanggal
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Keperluan
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($surats as $index => $surat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $surats->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                                {{ $surat->no_surat }}
                            </td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                @if ($surat->penerima === 'ipnu')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-male mr-1"></i>IPNU
                                    </span>
                                @elseif($surat->penerima === 'ippnu')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                        <i class="fas fa-female mr-1"></i>IPPNU
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-users mr-1"></i>Bersama
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 hidden sm:table-cell whitespace-nowrap">
                                {{ $surat->tanggal?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate"
                                title="{{ $surat->keperluan }}">
                                {{ $surat->keperluan }}
                            </td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                @if ($surat->status === 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif($surat->status === 'diterima')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Diterima
                                    </span>
                                @elseif($surat->status === 'ditolak')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-3 text-lg">
                                    <!-- Detail -->
                                    <button wire:click="showDetail('{{ $surat->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Edit (hanya jika pending) -->
                                    @if ($surat->status === 'pending')
                                        <button wire:click="edit('{{ $surat->id }}')"
                                            class="text-yellow-600 hover:text-yellow-800 transition-transform hover:scale-110 cursor-pointer"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif

                                    <!-- Hapus -->
                                    <button
                                        onclick="confirmDeletePengajuan('{{ $surat->id }}', '{{ $surat->no_surat }}')"
                                        class="text-red-600 hover:text-red-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-envelope-open-text text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada pengajuan surat</p>
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
        @if ($surats->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $surats->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $surats->lastItem() }}</span>
                        dari <span class="font-medium">{{ $surats->total() }}</span> hasil
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($surats->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $surats->currentPage() - 1 }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        @foreach ($surats->getUrlRange(1, $surats->lastPage()) as $page => $url)
                            @if ($page == $surats->currentPage())
                                <span class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="$set('page', {{ $page }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        @if ($surats->hasMorePages())
                            <button wire:click="$set('page', {{ $surats->currentPage() + 1 }})"
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

    <!-- Modal Detail -->
    @if ($showDetailModal && $selectedSurat)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4"
            wire:click="closeDetail">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl h-[95vh] sm:h-auto sm:max-h-[90vh] flex flex-col overflow-hidden"
                wire:click.stop>
                <!-- Modal Header -->
                <div
                    class="sticky top-0 bg-gradient-to-r from-green-600 to-green-700 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between flex-shrink-0 shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                            <i class="fas fa-envelope text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-white">Detail Pengajuan Surat</h3>
                            <p class="text-green-100 text-xs sm:text-sm">{{ $selectedSurat->no_surat }}</p>
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

                    <!-- Info Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Penerima -->
                        <div
                            class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-purple-500 p-2 rounded-lg">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-purple-600 font-medium mb-1">Penerima</p>
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
                                        {{ $selectedSurat->tanggal?->format('d F Y') ?? '-' }}</p>
                                    @if ($selectedSurat->tanggal)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $selectedSurat->tanggal->diffForHumans() }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div
                        class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                        <div class="flex items-start gap-3">
                            <div class="bg-orange-500 p-2 rounded-lg">
                                <i class="fas fa-tag text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-orange-600 font-medium mb-1">Keperluan</p>
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
                                    <p class="text-xs text-gray-600 font-medium mb-2">Deskripsi</p>
                                    <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">
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

<script>
    function confirmDeletePengajuan(id, noSurat) {
        Swal.fire({
            title: 'Hapus Pengajuan Surat?',
            html: `Surat <strong>${noSurat}</strong> akan dihapus secara permanen!`,
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
</script>
