<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/arsip-surat/index.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Arsip Surat</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola dan lihat arsip surat masuk & keluar</p>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Surat</label>
                <input type="text" wire:model.live="search" placeholder="Nomor surat, pengirim/penerima..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat</label>
                <select wire:model.live="filterJenis"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua</option>
                    <option value="masuk">Surat Masuk</option>
                    <option value="keluar">Surat Keluar</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="create"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Surat
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Surat</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ \App\Models\Surat::count() }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-envelope text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Surat Masuk</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ \App\Models\Surat::masuk()->count() }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-inbox text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Surat Keluar</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ \App\Models\Surat::keluar()->count() }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-paper-plane text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Arsip Surat</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No. Surat</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Jenis</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Deskripsi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Pengirim/Penerima</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($surats as $index => $surat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $surats->firstItem() + $index }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $surat->no_surat }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $surat->tanggal->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                @if($surat->jenis_surat === 'masuk')
                                    <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Masuk</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">Keluar</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ Str::limit($surat->deskripsi, 40) }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $surat->pengirim_penerima }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="detail('{{ $surat->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="edit('{{ $surat->id }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($surat->file)
                                        <a href="{{ asset('storage/' . $surat->file) }}" target="_blank"
                                            class="text-green-600 hover:text-green-800 transition" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @endif
                                    <button wire:click="delete('{{ $surat->id }}')"
                                        wire:confirm="Apakah Anda yakin ingin menghapus surat ini?"
                                        class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                <p>Belum ada data surat</p>
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
                            <button wire:click="previousPage" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($surats->getUrlRange(1, $surats->lastPage()) as $page => $url)
                            @if ($page == $surats->currentPage())
                                <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg font-medium shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($surats->hasMorePages())
                            <button wire:click="nextPage" wire:loading.attr="disabled"
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
