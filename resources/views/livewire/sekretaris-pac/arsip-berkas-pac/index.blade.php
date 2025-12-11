<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Arsip Berkas PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola dan lihat arsip berkas pac</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Berkas PAC</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['total'] }}</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Berkas</label>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Nama berkas, catatan..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
            </div>
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="export" wire:loading.attr="disabled"
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
            </div>
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="create"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>Tambah Berkas
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Arsip Berkas PAC</h3>
            <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">
                <i class="fas fa-lock mr-1"></i>Data Terenkripsi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Berkas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($berkasList as $index => $berkas)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $berkasList->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                                {{ Str::title(Str::limit($berkas->nama, 40)) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 hidden sm:table-cell whitespace-nowrap">
                                {{ $berkas->tanggal?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-3 text-lg">
                                    <button wire:click="showDetail('{{ $berkas->id }}')"
                                        class="text-green-600 hover:text-green-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="edit('{{ $berkas->id }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="confirmDelete('{{ $berkas->id }}', '{{ $berkas->nama }}')"
                                        class="text-red-600 hover:text-red-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada data berkas pac</p>
                                @if ($search)
                                    <p class="text-sm mt-2">Coba ubah kata kunci pencarian Anda</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($berkasList->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $berkasList->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $berkasList->lastItem() }}</span>
                        dari <span class="font-medium">{{ $berkasList->total() }}</span> hasil
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($berkasList->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $berkasList->currentPage() - 1 }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        @foreach ($berkasList->getUrlRange(1, $berkasList->lastPage()) as $page => $url)
                            @if ($page == $berkasList->currentPage())
                                <span class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg font-medium">{{ $page }}</span>
                            @else
                                <button wire:click="$set('page', {{ $page }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        @if ($berkasList->hasMorePages())
                            <button wire:click="$set('page', {{ $berkasList->currentPage() + 1 }})"
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
    @if ($showDetailModal && $selectedBerkas)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4"
            wire:click="closeDetail">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-full sm:max-w-2xl md:max-w-3xl h-[95vh] sm:h-auto sm:max-h-[90vh] flex flex-col overflow-hidden"
                wire:click.stop>
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-purple-600 to-purple-700 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between flex-shrink-0 shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                            <i class="fas fa-folder-open text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-white">Detail Berkas PAC</h3>
                            <p class="text-purple-100 text-xs sm:text-sm">{{ $selectedBerkas->nama }}</p>
                        </div>
                    </div>
                    <button wire:click="closeDetail"
                        class="text-white/80 hover:text-white transition p-2 hover:bg-white/10 rounded-lg cursor-pointer">
                        <i class="fas fa-times text-lg sm:text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Berkas -->
                        <div class="md:col-span-2 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-green-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-green-500 p-2 rounded-lg">
                                    <i class="fas fa-folder text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-green-600 font-medium mb-1">Nama Berkas</p>
                                    <p class="font-semibold text-gray-800">{{ $selectedBerkas->nama }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-green-500 p-2 rounded-lg">
                                    <i class="fas fa-calendar text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-green-600 font-medium mb-1">Tanggal</p>
                                    <p class="font-semibold text-gray-800">{{ $selectedBerkas->tanggal?->format('d F Y') ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Periode -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-500 p-2 rounded-lg">
                                    <i class="fas fa-calendar-check text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-orange-600 font-medium mb-1">Periode</p>
                                    <p class="font-semibold text-gray-800">{{ $selectedBerkas->periode->nama ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    @if ($selectedBerkas->catatan)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-start gap-3">
                                <div class="bg-gray-400 p-2 rounded-lg flex-shrink-0">
                                    <i class="fas fa-comment text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-600 font-medium mb-2">Catatan</p>
                                    <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $selectedBerkas->catatan }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Dibuat Oleh -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                        <div class="flex items-start gap-3">
                            <div class="bg-purple-500 p-2 rounded-lg">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-purple-600 font-medium mb-1">Dibuat Oleh</p>
                                <p class="font-semibold text-gray-800">{{ $selectedBerkas->user->name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- File -->
                    @if ($selectedBerkas->file_path)
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border border-indigo-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="bg-indigo-500 p-2 rounded-lg">
                                        <i class="fas fa-file-pdf text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-indigo-600 font-medium">File Berkas</p>
                                        <p class="text-sm text-gray-700 font-medium">Dokumen tersedia</p>
                                        <p class="text-xs text-gray-500 mt-1">Klik untuk membuka di tab baru</p>
                                    </div>
                                </div>
                                <a href="{{ route('pac.arsip-berkas-pac.view-file', $selectedBerkas->id) }}"
                                    target="_blank"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow-lg hover:shadow-xl flex items-center gap-2">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span class="hidden sm:inline">Buka File</span>
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
                                    <p class="text-sm font-medium text-gray-800">{{ $selectedBerkas->created_at->format('d F Y, H:i') }}</p>
                                    <p class="text-xs text-gray-500">{{ $selectedBerkas->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-200"></div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-history text-gray-400 text-sm"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Terakhir Diupdate</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $selectedBerkas->updated_at->format('d F Y, H:i') }}</p>
                                    <p class="text-xs text-gray-500">{{ $selectedBerkas->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
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

<script>
    function confirmDelete(id, nomor) {
        Swal.fire({
            title: 'Hapus Berkas?',
            html: `Berkas <strong>${nomor}</strong> akan dihapus secara permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', id);
            }
        });
    }
</script>
