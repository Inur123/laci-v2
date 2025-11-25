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

    <!-- 🔥 Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
            <div class="flex items-end">
                <button wire:click="create"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
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
            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                No
            </th>
            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                No Surat
            </th>
            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Penerima
            </th>
            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden sm:table-cell">
                Tanggal
            </th>
            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Keperluan
            </th>
            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Status
            </th>
            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Aksi
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($surats as $index => $surat)
            <tr class="hover:bg-gray-50 transition-colors">
                <!-- No -->
                <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                    {{ $surats->firstItem() + $index }}
                </td>

                <!-- No Surat -->
                <td class="px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                    {{ $surat->no_surat }}
                </td>

                <!-- Penerima -->
                <td class="px-4 py-3 text-sm whitespace-nowrap">
                    @if($surat->penerima === 'ipnu')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-male mr-1"></i>IPNU
                        </span>
                    @elseif($surat->penerima === 'ippnu')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                            <i class="fas fa-female mr-1"></i>IPPNU
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <i class="fas fa-users mr-1"></i>Bersama
                        </span>
                    @endif
                </td>

                <!-- Tanggal (hidden di mobile) -->
                <td class="px-4 py-3 text-sm text-gray-700 hidden sm:table-cell whitespace-nowrap">
                    {{ $surat->tanggal?->format('d M Y') ?? '-' }}
                </td>

                <!-- Keperluan -->
                <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate" title="{{ $surat->keperluan }}">
                    {{ $surat->keperluan }}
                </td>

                <!-- Status -->
                <td class="px-4 py-3 text-sm whitespace-nowrap">
                    @if($surat->status === 'pending')
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

                <!-- Aksi → Ikon kecil seperti kode lama -->
                <td class="px-4 py-3 text-sm whitespace-nowrap">
                    <div class="flex items-center gap-3 text-lg">
                        <!-- Detail -->
                        <button wire:click="detail('{{ $surat->id }}')"
                            class="text-blue-600 hover:text-blue-800 transition-transform hover:scale-110"
                            title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Edit (hanya jika pending) -->
                        @if($surat->status === 'pending')
                            <button wire:click="edit('{{ $surat->id }}')"
                                class="text-yellow-600 hover:text-yellow-800 transition-transform hover:scale-110"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        @endif

                        <!-- Hapus -->
                        <button onclick="confirmDeletePengajuan('{{ $surat->id }}', '{{ $surat->no_surat }}')"
                            class="text-red-600 hover:text-red-800 transition-transform hover:scale-110"
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
                    @if($search || $filterStatus)
                        <p class="text-sm mt-2">Coba ubah filter atau kata kunci pencarian Anda</p>
                    @endif
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
        </div>

        <!-- Custom Pagination -->
        @if($surats->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Info -->
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $surats->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $surats->lastItem() }}</span>
                        dari <span class="font-medium">{{ $surats->total() }}</span> hasil
                    </div>

                    <!-- Pagination Buttons -->
                    <div class="flex items-center gap-2">
                        {{-- Previous Button --}}
                        @if ($surats->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $surats->currentPage() - 1 }})" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($surats->getUrlRange(1, $surats->lastPage()) as $page => $url)
                            @if ($page == $surats->currentPage())
                                <span class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="$set('page', {{ $page }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($surats->hasMorePages())
                            <button wire:click="$set('page', {{ $surats->currentPage() + 1 }})" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
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
            confirmButton: 'px-4 py-2 rounded-lg',
            cancelButton: 'px-4 py-2 rounded-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            @this.call('delete', id);
        }
    });
}
</script>
