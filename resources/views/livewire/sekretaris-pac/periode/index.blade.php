<!-- filepath: resources/views/livewire/sekretaris-pac/data-anggota/periode/index.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Periode Kepengurusan</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola periode kepengurusan organisasi</p>
    </div>

    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Total Periode</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->totalPeriode }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Dibuat Bulan Ini</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->periodeBulanIni }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-plus-circle text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Update Terakhir</p>
                    <h3 class="text-sm sm:text-base font-bold mt-1 text-gray-800">{{ $this->updateTerakhir }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-clock text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Cari Periode -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Periode</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Nama periode..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
            </div>

            <!-- Tombol Tambah Periode -->
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="create"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg
                hover:bg-green-700 transition text-sm cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>Tambah Periode
                </button>
            </div>

        </div>
    </div>


    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Periode</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama Periode</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Dibuat Oleh</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal Dibuat</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($periodes as $index => $periode)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                {{ $periodes->firstItem() + $index }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-800">{{ $periode->nama }}</span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">{{ $periode->user->name }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                {{ $periode->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <button wire:click="edit('{{ $periode->id }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition whitespace-nowrap cursor-pointer"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        onclick="confirmDeletePeriode('{{ $periode->id }}', '{{ $periode->nama }}')"
                                        class="text-red-600 hover:text-red-800 transition whitespace-nowrap cursor-pointer"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                <p>Belum ada data periode</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 🔥 Custom Pagination (Tanpa URL Parameter) -->
        @if ($periodes->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Info -->
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $periodes->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $periodes->lastItem() }}</span>
                        dari <span class="font-medium">{{ $periodes->total() }}</span> hasil
                    </div>

                    <!-- Pagination Buttons -->
                    <div class="flex items-center gap-2">
                        {{-- Previous Button --}}
                        @if ($periodes->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $periodes->currentPage() - 1 }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($periodes->getUrlRange(1, $periodes->lastPage()) as $page => $url)
                            @if ($page == $periodes->currentPage())
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

                        {{-- Next Button --}}
                        @if ($periodes->hasMorePages())
                            <button wire:click="$set('page', {{ $periodes->currentPage() + 1 }})"
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

<script>
    function confirmDeletePeriode(id, namaPeriode) {
        Swal.fire({
            title: 'Hapus Periode?',
            html: `Periode <strong>${namaPeriode}</strong> akan dihapus secara permanen!<br><br>
                   <div class="text-left bg-yellow-50 p-3 rounded-lg border border-yellow-200 mt-2">
                       <small class="text-yellow-800">
                           <i class="fas fa-exclamation-triangle mr-1"></i>
                           <strong>Perhatian:</strong> Periode tidak dapat dihapus jika sedang Anda gunakan sebagai periode aktif.
                       </small>
                   </div>`,
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
