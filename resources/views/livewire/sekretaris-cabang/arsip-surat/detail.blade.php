<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/arsip-surat/detail.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Surat</h1>
            <p class="text-sm text-gray-600 mt-1 break-all">Informasi lengkap surat {{ $surat->no_surat }}</p>
        </div>
        <button wire:click="back" class="text-gray-600 hover:text-gray-800 self-start sm:self-center">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Detail Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Informasi Surat</h2>

                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Nomor Surat</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1 break-all">{{ $surat->no_surat }}</p>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Jenis Surat</label>
                        <div class="mt-1">
                            @if($surat->jenis_surat === 'masuk')
                                <span class="inline-block px-2 sm:px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs sm:text-sm font-medium">
                                    <i class="fas fa-inbox mr-1"></i>Surat Masuk
                                </span>
                            @else
                                <span class="inline-block px-2 sm:px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs sm:text-sm font-medium">
                                    <i class="fas fa-paper-plane mr-1"></i>Surat Keluar
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Tanggal</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1">{{ $surat->tanggal->format('d F Y') }}</p>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">
                            {{ $surat->jenis_surat === 'masuk' ? 'Pengirim' : 'Penerima' }}
                        </label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1 break-words">{{ $surat->pengirim_penerima }}</p>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Deskripsi/Perihal</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1 whitespace-pre-wrap break-words">{{ $surat->deskripsi ?? '-' }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Dibuat Oleh</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1">{{ $surat->user->name }}</p>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Tanggal Dibuat</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1">{{ $surat->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- File & Actions -->
        <div class="space-y-4 sm:space-y-6">
            <!-- File -->
            @if($surat->file)
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">File Lampiran</h2>

                    <div class="border border-gray-200 rounded-lg p-3 sm:p-4 text-center">
                        <i class="fas fa-file-pdf text-red-500 text-3xl sm:text-4xl mb-2 sm:mb-3"></i>
                        <p class="text-xs sm:text-sm text-gray-700 mb-2 sm:mb-3 break-all px-2">{{ basename($surat->file) }}</p>

                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ asset('storage/' . $surat->file) }}" target="_blank"
                                class="flex-1 bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-blue-700 transition text-xs sm:text-sm">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                            <a href="{{ asset('storage/' . $surat->file) }}" download
                                class="flex-1 bg-green-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-green-700 transition text-xs sm:text-sm">
                                <i class="fas fa-download mr-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">File Lampiran</h2>
                    <div class="text-center text-gray-500 py-6 sm:py-8">
                        <i class="fas fa-file-slash text-3xl sm:text-4xl mb-2"></i>
                        <p class="text-xs sm:text-sm">Tidak ada file lampiran</p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Aksi</h2>

                <div class="space-y-2 sm:space-y-3">
                    <button wire:click="edit('{{ $surat->id }}')"
                        class="w-full bg-yellow-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm sm:text-base">
                        <i class="fas fa-edit mr-2"></i>Edit Surat
                    </button>

                    <button wire:click="delete('{{ $surat->id }}')"
                        wire:confirm="Apakah Anda yakin ingin menghapus surat ini?"
                        class="w-full bg-red-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm sm:text-base">
                        <i class="fas fa-trash mr-2"></i>Hapus Surat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
