<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Arsip Surat PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola dan lihat arsip surat masuk & keluar PAC</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Surat</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['total'] }}</h3>
            </div>
            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                <i class="fas fa-envelope text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Surat Masuk</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['masuk'] }}</h3>
            </div>
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                <i class="fas fa-inbox text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Surat Keluar</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $stats['keluar'] }}</h3>
            </div>
            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                <i class="fas fa-paper-plane text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Surat</label>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Nomor surat, pengirim/penerima..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat</label>
                <select wire:model.live="filterJenis"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua</option>
                    <option value="masuk">Surat Masuk</option>
                    <option value="keluar">Surat Keluar</option>
                </select>
            </div>
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="export" wire:loading.attr="disabled"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm disabled:opacity-50">
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
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Tambah Surat
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
       <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
    <h3 class="text-lg font-semibold text-gray-800">Daftar Arsip Surat PAC</h3>
    <div class="flex items-center gap-2">
        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">
            <i class="fas fa-lock mr-1"></i>Data Terenkripsi
        </span>

        <!-- Tombol Export -->
        <button wire:click="export" wire:loading.attr="disabled"
            class="text-xs px-3 py-1 bg-green-600 text-white rounded-full hover:bg-green-700 transition disabled:opacity-50">
            <span wire:loading.remove wire:target="export">
                <i class="fas fa-download mr-1"></i>Export
            </span>
            <span wire:loading wire:target="export">
                <i class="fas fa-spinner fa-spin mr-1"></i>
            </span>
        </button>
    </div>
</div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No. Surat</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Jenis</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Perihal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Deskripsi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Pengirim/Penerima</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($surats as $index => $surat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $surats->firstItem() + $index }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">{{ $surat->no_surat }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">{{ $surat->tanggal->format('d M Y') }}</td>
                            <td class="py-3 px-4 whitespace-nowrap overflow-hidden text-ellipsis">
                                @if ($surat->jenis_surat === 'masuk')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-inbox mr-1"></i>Masuk
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-paper-plane mr-1"></i>Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ Str::limit($surat->perihal, 40) }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ Str::limit($surat->deskripsi, 40) }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $surat->pengirim_penerima }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="detail('{{ $surat->id }}')" class="text-blue-600 hover:text-blue-800 transition" title="Detail"><i class="fas fa-eye"></i></button>
                                    <button wire:click="edit('{{ $surat->id }}')" class="text-yellow-600 hover:text-yellow-800 transition" title="Edit"><i class="fas fa-edit"></i></button>
                                    @if ($surat->file)
                                        <a href="{{ route('pac.arsip-surat.view-file', $surat->id) }}" target="_blank" class="text-green-600 hover:text-green-800 transition" title="Download"><i class="fas fa-download"></i></a>
                                    @endif
                                    <button onclick="confirmDelete('{{ $surat->id }}', '{{ $surat->no_surat }}')" class="text-red-600 hover:text-red-800 transition" title="Hapus"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                <p>Belum ada data surat</p>
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
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <button wire:click="$set('page', {{ $surats->currentPage() - 1 }})" wire:loading.attr="disabled" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition"><i class="fas fa-chevron-left"></i></button>
                        @endif

                        @foreach ($surats->getUrlRange(1, $surats->lastPage()) as $page => $url)
                            @if ($page == $surats->currentPage())
                                <span class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg font-medium">{{ $page }}</span>
                            @else
                                <button wire:click="$set('page', {{ $page }})" wire:loading.attr="disabled" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">{{ $page }}</button>
                            @endif
                        @endforeach

                        @if ($surats->hasMorePages())
                            <button wire:click="$set('page', {{ $surats->currentPage() + 1 }})" wire:loading.attr="disabled" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition"><i class="fas fa-chevron-right"></i></button>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(id, noSurat) {
    Swal.fire({
        title: 'Hapus Surat?',
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
