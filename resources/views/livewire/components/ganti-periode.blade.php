<div x-data="{ open: @entangle('showModal') }">
    <!-- Button Trigger -->
    <button @click="open = true"
            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition cursor-pointer">
        <i class="fas fa-calendar-alt text-green-600"></i>
        <span class="hidden md:inline">{{ auth()->user()->periodeAktif->nama ?? 'Pilih Periode' }}</span>
        <i class="fas fa-chevron-down text-xs"></i>
    </button>

    <!-- Modal -->
    <div x-show="open"
         x-cloak
         class="fixed inset-0 z-[9999] overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true"
         style="display: none;">

        <!-- Backdrop with Blur -->
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="open = false"></div>

        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4" @click="open = false">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:max-w-lg sm:w-full"
                 @click.stop>

                <!-- Header -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-calendar-alt text-green-600 mr-2"></i>
                            Ganti Periode
                        </h3>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition cursor-pointer">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Success Message -->
                    @if (session()->has('success'))
                        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Warning Peringatan -->
                    <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-semibold text-yellow-800 mb-1">⚠️ PERHATIAN PENTING!</h4>
                                @if(auth()->user()->role === 'sekretaris_cabang')
                                    <p class="text-xs text-yellow-700 leading-relaxed">
                                        Penggantian periode akan <strong>mempengaruhi semua data</strong>:
                                        <strong>Arsip Surat Keluar/Masuk, Berkas PAC, Berkas Cabang, Data Anggota, Pengajuan PAC, dan Kalender Kegiatan.</strong>
                                        <br><strong>Jangan asal ganti periode aktif!</strong> Pastikan periode yang dipilih sudah benar.
                                    </p>
                                @else
                                    <p class="text-xs text-yellow-700 leading-relaxed">
                                        Penggantian periode akan <strong>mempengaruhi semua data</strong>:
                                        <strong>Arsip Surat Keluar/Masuk, Data Anggota, Pengajuan Surat, dan Referensi Surat.</strong>
                                        <br><strong>Jangan asal ganti periode aktif!</strong> Pastikan periode yang dipilih sudah benar.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Periode List -->
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse($periodes as $periode)
                            <button
                                onclick="confirmGantiPeriode('{{ $periode->id }}', '{{ $periode->nama }}', {{ $periodeAktif == $periode->id ? 'true' : 'false' }})"
                                class="w-full text-left px-4 py-3 rounded-lg border transition cursor-pointer
                                       {{ $periodeAktif == $periode->id
                                          ? 'border-green-500 bg-green-50 text-green-700 shadow-sm'
                                          : 'border-gray-200 hover:border-green-300 hover:bg-gray-50' }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">{{ $periode->nama }}</p>
                                    </div>
                                    @if($periodeAktif == $periode->id)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">
                                                Aktif
                                            </span>
                                            <i class="fas fa-check text-green-600"></i>
                                        </div>
                                    @endif
                                </div>
                            </button>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-calendar-times text-4xl mb-3"></i>
                                <p>Belum ada periode tersedia</p>
                                <p class="text-sm mt-1">Silakan buat periode terlebih dahulu</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button @click="open = false"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmGantiPeriode(id, namaPeriode, isAktif) {
        // Jika periode sudah aktif, tidak perlu konfirmasi
        if (isAktif) {
            Swal.fire({
                title: 'Periode Sudah Aktif',
                html: `Periode <strong>${namaPeriode}</strong> sudah menjadi periode aktif saat ini.`,
                icon: 'info',
                confirmButtonColor: '#10b981',
                confirmButtonText: '<i class="fas fa-check mr-2"></i>OK',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'px-6 py-2.5 rounded-lg font-medium shadow-lg'
                }
            });
            return;
        }

        Swal.fire({
            title: 'Ganti Periode?',
            html: `Anda akan mengganti periode aktif ke <strong>${namaPeriode}</strong>.<br><br>
                   <div class="text-left bg-yellow-50 p-3 rounded-lg border border-yellow-200 mt-2">
                       <small class="text-yellow-800">
                           <i class="fas fa-exclamation-triangle mr-1"></i>
                           <strong>Perhatian:</strong> Penggantian periode akan mempengaruhi semua data yang ditampilkan.
                       </small>
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Ganti Periode!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-medium shadow-lg',
                cancelButton: 'px-6 py-2.5 rounded-lg font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('gantiPeriode', id);
            }
        });
    }
</script>
