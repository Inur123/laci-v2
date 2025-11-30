<div>
    <!-- Header -->
    <div class="mb-6 flex flex-row items-center justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Kegiatan</h1>
            <p class="text-sm text-gray-600 mt-1 break-words">{{ $kegiatan->judul }}</p>
        </div>

        <button wire:click="back"
            class="text-white bg-gray-600 hover:bg-gray-700 transition rounded-lg px-3 sm:px-4 py-2 whitespace-nowrap cursor-pointer">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>
    </div>


    <!-- Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Detail Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Informasi Kegiatan</h2>

                <!-- Event Card Preview -->
                <div class="mb-6 border-l-4 p-4 rounded-r"
                    style="border-color: {{ $kegiatan->warna }}; background-color: {{ $kegiatan->warna }}20;">
                    <div class="flex items-start justify-between mb-2">
                        @if ($kegiatan->isOngoing())
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-medium">Sedang
                                Berlangsung</span>
                        @elseif($kegiatan->isPast())
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">Selesai</span>
                        @else
                            <span
                                class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs font-medium">Mendatang</span>
                        @endif
                        <div class="w-6 h-6 rounded-full" style="background-color: {{ $kegiatan->warna }};"></div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $kegiatan->judul }}</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p>
                            <i class="fas fa-calendar mr-2"></i>
                            {{ $kegiatan->tanggal_mulai->format('d F Y') }}
                        </p>
                        <p>
                            <i class="fas fa-clock mr-2"></i>
                            {{ $kegiatan->tanggal_mulai->format('H:i') }} WIB
                            @if ($kegiatan->tanggal_selesai)
                                - {{ $kegiatan->tanggal_selesai->format('H:i') }} WIB
                            @endif
                        </p>
                        @if ($kegiatan->lokasi)
                            <p>
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $kegiatan->lokasi }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Deskripsi/Detail</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1 whitespace-pre-wrap break-words">
                            {{ $kegiatan->deskripsi ?? '-' }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Durasi</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1">
                            @if ($kegiatan->tanggal_selesai)
                                {{ $kegiatan->tanggal_mulai->diffForHumans($kegiatan->tanggal_selesai, true) }}
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Dibuat Oleh</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1">{{ $kegiatan->user->name }}</p>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-500">Tanggal Dibuat</label>
                        <p class="text-sm sm:text-base text-gray-800 mt-1">
                            {{ $kegiatan->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions & Info -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Status Kegiatan</h2>

                <div class="space-y-3">
                    @if ($kegiatan->isOngoing())
                        <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                                <span class="text-sm font-medium text-green-700">Sedang Berlangsung</span>
                            </div>
                        </div>
                    @elseif($kegiatan->isPast())
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-gray-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-700">Kegiatan Selesai</span>
                            </div>
                        </div>
                    @else
                        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                                <span class="text-sm font-medium text-yellow-700">Mendatang</span>
                            </div>
                            <p class="text-xs text-yellow-600 mt-1">
                                {{ $kegiatan->tanggal_mulai->diffForHumans() }}
                            </p>
                        </div>
                    @endif

                    <div class="text-center text-xs text-gray-500 pt-2 border-t">
                        Terakhir diupdate: {{ $kegiatan->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Aksi</h2>

                <div class="space-y-2 sm:space-y-3">
                    <button wire:click="edit('{{ $kegiatan->id }}')"
                        class="w-full bg-yellow-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm sm:text-base cursor-pointer">
                        <i class="fas fa-edit mr-2"></i>Edit Kegiatan
                    </button>

                    <!-- Tombol Hapus dengan SweetAlert -->
                    <button
                        onclick="confirmDeleteKegiatan('{{ $kegiatan->id }}', '{{ addslashes($kegiatan->judul) }}')"
                        class="w-full bg-red-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm sm:text-base cursor-pointer">
                        <i class="fas fa-trash mr-2"></i>Hapus Kegiatan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 untuk Konfirmasi Hapus -->
<script>
    function confirmDeleteKegiatan(id, judul) {
        Swal.fire({
            title: 'Hapus Kegiatan?',
            html: `Kegiatan <strong>${judul}</strong> akan dihapus secara permanen!`,
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
