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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama User</label>
                <input type="text" wire:model.live.debounce.500ms="searchName" placeholder="Nama user..."
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
                <button wire:click="$refresh"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
   <div class="bg-white rounded-lg shadow overflow-hidden">
    {{-- Header --}}
    <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Referensi Surat PAC</h3>
        <div class="flex items-center gap-2">
            <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">
                <i class="fas fa-lock mr-1"></i>Data Terenkripsi
            </span>
            {{-- Jika ada tombol export, bisa ditambahkan di sini --}}
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
                            @if($surat->status === 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @elseif($surat->status === 'diterima')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
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
        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition">
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
    @if($pengajuans->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $pengajuans->firstItem() }}</span>
                    sampai <span class="font-medium">{{ $pengajuans->lastItem() }}</span>
                    dari <span class="font-medium">{{ $pengajuans->total() }}</span> hasil
                </div>

                <div class="flex items-center gap-2">
                    {{-- Previous --}}
                    @if ($pengajuans->onFirstPage())
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <button wire:click="$set('page', {{ $pengajuans->currentPage() - 1 }})"
                            wire:loading.attr="disabled"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($pengajuans->getUrlRange(1, $pengajuans->lastPage()) as $page => $url)
                        @if ($page == $pengajuans->currentPage())
                            <span class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg font-medium">{{ $page }}</span>
                        @else
                            <button wire:click="$set('page', {{ $page }})" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($pengajuans->hasMorePages())
                        <button wire:click="$set('page', {{ $pengajuans->currentPage() + 1 }})"
                            wire:loading.attr="disabled"
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


    <!-- Modal Detail -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4" wire:click="closeDetail">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl xl:max-w-5xl h-[95vh] sm:h-auto sm:max-h-[90vh] flex flex-col overflow-hidden" wire:click.stop>
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between flex-shrink-0 shadow-sm">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">Detail Surat</h3>
                    <button wire:click="closeDetail" class="text-gray-400 hover:text-gray-600 transition p-1">
                        <i class="fas fa-times text-lg sm:text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                @if($selectedSurat)
                    <div class="p-4 sm:p-6 space-y-4 sm:space-y-6 overflow-y-auto flex-1">
                        <!-- Info User -->
                        <div class="bg-blue-50 rounded-lg p-3 sm:p-4">
                            <h4 class="text-xs sm:text-sm font-semibold text-blue-900 mb-2 sm:mb-3 flex items-center">
                                <i class="fas fa-user-circle mr-2"></i>Informasi User Pengaju
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div>
                                    <p class="text-xs text-blue-700 mb-1">Nama User</p>
                                    <p class="text-sm font-medium text-blue-900 break-words">{{ $selectedSurat->user->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-700 mb-1">Email</p>
                                    <p class="text-xs sm:text-sm font-medium text-blue-900 break-all">{{ $selectedSurat->user->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-700 mb-1">Role</p>
                                    <p class="text-sm font-medium text-blue-900">{{ ucwords(str_replace('_', ' ', $selectedSurat->user->role ?? '-')) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-700 mb-1">User ID</p>
                                    <p class="text-[10px] sm:text-xs font-mono text-blue-800 break-all">{{ $selectedSurat->user_id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Surat Lengkap -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-3 sm:p-4 border border-green-200">
                            <h4 class="text-xs sm:text-sm font-semibold text-green-900 mb-3 sm:mb-4 flex items-center">
                                <i class="fas fa-envelope-open-text mr-2"></i>Detail Lengkap Surat
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div class="bg-white rounded-lg p-2 sm:p-3">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">
                                        <i class="fas fa-hashtag mr-1"></i>No. Surat
                                    </label>
                                    <p class="text-sm font-bold text-gray-900 break-words">{{ $selectedSurat->no_surat }}</p>
                                </div>
                                <div class="bg-white rounded-lg p-2 sm:p-3">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">
                                        <i class="fas fa-calendar-alt mr-1"></i>Tanggal Surat
                                    </label>
                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $selectedSurat->tanggal ? $selectedSurat->tanggal->format('d F Y') : '-' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $selectedSurat->tanggal ? $selectedSurat->tanggal->diffForHumans() : '' }}
                                    </p>
                                </div>
                                <div class="bg-white rounded-lg p-2 sm:p-3">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">
                                        <i class="fas fa-user-tag mr-1"></i>Penerima
                                    </label>
                                    <p class="text-sm font-bold text-gray-900 break-words">{{ $selectedSurat->penerima }}</p>
                                </div>
                                <div class="bg-white rounded-lg p-2 sm:p-3">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">
                                        <i class="fas fa-flag mr-1"></i>Status
                                    </label>
                                    <div class="mt-1">
                                        @if($selectedSurat->status === 'pending')
                                            <span class="inline-flex items-center px-2 sm:px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @elseif($selectedSurat->status === 'diterima')
                                            <span class="inline-flex items-center px-2 sm:px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                <i class="fas fa-check-circle mr-1"></i>Diterima
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 sm:px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                                            </span>
                                        @endif
                                    </div>
                                    @if($selectedSurat->last_status_changed_at)
                                        <p class="text-xs text-gray-500 mt-2">
                                            <i class="fas fa-history mr-1"></i>
                                            Diubah: {{ $selectedSurat->last_status_changed_at->format('d M Y, H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Keperluan -->
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide flex items-center mb-2">
                                <i class="fas fa-clipboard-list mr-2"></i>Keperluan Surat
                            </label>
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-3 sm:p-4 border border-gray-200">
                                <p class="text-sm text-gray-900 leading-relaxed break-words">{{ $selectedSurat->keperluan }}</p>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        @if($selectedSurat->deskripsi)
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide flex items-center mb-2">
                                    <i class="fas fa-align-left mr-2"></i>Deskripsi Lengkap
                                </label>
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-3 sm:p-4 border border-gray-200">
                                    <p class="text-sm text-gray-900 leading-relaxed whitespace-pre-wrap break-words">{{ $selectedSurat->deskripsi }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- File Pendukung -->
                        @if($selectedSurat->file)
                            <div class="bg-indigo-50 border-2 border-indigo-200 rounded-lg p-3 sm:p-4">
                                <label class="text-xs font-medium text-indigo-700 uppercase tracking-wide flex items-center mb-3">
                                    <i class="fas fa-paperclip mr-2"></i>File Pendukung Terenkripsi
                                </label>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                    <div class="flex items-start gap-2 sm:gap-3 w-full sm:w-auto">
                                        <div class="bg-indigo-100 rounded-lg p-2 sm:p-3 flex-shrink-0">
                                            <i class="fas fa-file-pdf text-xl sm:text-2xl text-indigo-600"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-indigo-900">Dokumen Pengajuan</p>
                                            <p class="text-xs text-indigo-700 mt-1">Format: PDF Terenkripsi</p>
                                            <p class="text-xs text-indigo-600 mt-1">
                                                <i class="fas fa-shield-alt mr-1"></i>File disimpan dengan enkripsi AES-256
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('pac.pengajuan-pac.view-file', $selectedSurat->id) }}"
                                       target="_blank"
                                       class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                        <i class="fas fa-external-link-alt mr-2"></i>Buka File
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 sm:p-4">
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Tidak ada file pendukung yang dilampirkan
                                </p>
                            </div>
                        @endif

                        <!-- Catatan (jika ditolak) -->
                        @if($selectedSurat->status === 'ditolak' && $selectedSurat->catatan)
                            <div class="bg-red-50 border-2 border-red-200 rounded-lg p-3 sm:p-4">
                                <h4 class="text-sm font-semibold text-red-900 mb-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Catatan Penolakan
                                </h4>
                                <div class="bg-white rounded-lg p-3 border border-red-200">
                                    <p class="text-sm text-red-800 leading-relaxed break-words">{{ $selectedSurat->catatan }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Metadata & ID -->
                        <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                            <h4 class="text-xs font-semibold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
                                <i class="fas fa-database mr-2"></i>Metadata Sistem
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3 text-xs">
                                <div class="bg-white rounded p-2">
                                    <p class="text-gray-500 mb-1">ID Surat</p>
                                    <p class="font-mono text-[10px] sm:text-xs text-gray-800 break-all">{{ $selectedSurat->id }}</p>
                                </div>
                                <div class="bg-white rounded p-2">
                                    <p class="text-gray-500 mb-1">
                                        <i class="fas fa-calendar-plus mr-1"></i>Dibuat
                                    </p>
                                    <p class="text-gray-800 font-medium">{{ $selectedSurat->created_at->format('d M Y, H:i:s') }}</p>
                                    <p class="text-gray-500 mt-1">{{ $selectedSurat->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="bg-white rounded p-2">
                                    <p class="text-gray-500 mb-1">
                                        <i class="fas fa-calendar-check mr-1"></i>Terakhir Diperbarui
                                    </p>
                                    <p class="text-gray-800 font-medium">{{ $selectedSurat->updated_at->format('d M Y, H:i:s') }}</p>
                                    <p class="text-gray-500 mt-1">{{ $selectedSurat->updated_at->diffForHumans() }}</p>
                                </div>
                                <div class="bg-white rounded p-2">
                                    <p class="text-gray-500 mb-1">
                                        <i class="fas fa-table mr-1"></i>Tabel Database
                                    </p>
                                    <p class="font-mono text-gray-800">pengajuan_surat_pac</p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Enkripsi -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-2 sm:p-3">
                            <p class="text-xs text-green-800 flex items-center">
                                <i class="fas fa-lock mr-2 flex-shrink-0"></i>
                                <span>Semua data surat ini tersimpan dengan enkripsi <strong>AES-256-CBC</strong> untuk keamanan maksimal</span>
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Modal Footer -->
                <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 flex justify-end flex-shrink-0 shadow-sm">
                    <button wire:click="closeDetail"
                        class="w-full sm:w-auto px-6 py-2 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
