<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header with Gradient -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Detail Pengajuan Surat</h2>
                    <p class="text-blue-100 text-sm">{{ $detail['no_surat'] }}</p>
                </div>
            </div>
            <!-- Status Badge -->
            <span
                class="px-4 py-2 rounded-full text-sm font-semibold shadow-lg
                {{ $detail['status'] === 'pending'
                    ? 'bg-yellow-600 text-white'
                    : ($detail['status'] === 'diterima'
                        ? 'bg-green-600 text-white'
                        : 'bg-red-600 text-white') }}">
                <i class="fas fa-circle text-xs mr-1"></i>
                {{ ucfirst($detail['status']) }}
            </span>
        </div>
    </div>

    <!-- Content -->
    <div class="p-6">
        <!-- Info Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Penerima Card -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <div class="flex items-start gap-3">
                    <div class="bg-purple-500 p-2 rounded-lg">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-purple-600 font-medium mb-1">Penerima</p>
                        <p class="font-semibold text-gray-800">{{ $detail['penerima'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Tanggal Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <div class="flex items-start gap-3">
                    <div class="bg-blue-500 p-2 rounded-lg">
                        <i class="fas fa-calendar text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-blue-600 font-medium mb-1">Tanggal Surat</p>
                        <p class="font-semibold text-gray-800">{{ $detail['tanggal_formatted'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Keperluan Card -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                <div class="flex items-start gap-3">
                    <div class="bg-orange-500 p-2 rounded-lg">
                        <i class="fas fa-tag text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-orange-600 font-medium mb-1">Keperluan</p>
                        <p class="font-semibold text-gray-800">{{ $detail['keperluan'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Pengaju Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <div class="flex items-start gap-3">
                    <div class="bg-green-500 p-2 rounded-lg">
                        <i class="fas fa-user-check text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-green-600 font-medium mb-1">Pengaju</p>
                        <p class="font-semibold text-gray-800">{{ $detail['user']['name'] }}</p>
                        <p class="text-xs text-gray-600 mt-0.5">{{ $detail['user']['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi Section -->
        <div class="bg-gray-50 rounded-lg p-5 mb-6 border border-gray-200">
            <div class="flex items-start gap-3">
                <div class="bg-gray-600 p-2 rounded-lg">
                    <i class="fas fa-align-left text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-600 font-medium mb-2">Deskripsi</p>
                    <p class="text-gray-800 leading-relaxed">{{ $detail['deskripsi'] }}</p>
                </div>
            </div>
        </div>

        <!-- File & Timeline Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- File Surat -->
            @if ($detail['has_file'])
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border border-indigo-200">
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
                        <a href="{{ route('cabang.pengajuan-pac.file', $detail['id']) }}" target="_blank"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-external-link-alt mr-2"></i>Buka
                        </a>
                    </div>
                </div>
            @endif

            <!-- Timeline Info -->
            <div
                class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200 {{ $detail['has_file'] ? '' : 'md:col-span-2' }}">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-clock text-gray-400 text-sm"></i>
                        <div>
                            <p class="text-xs text-gray-500">Dibuat</p>
                            <p class="text-sm font-medium text-gray-800">{{ $detail['created_at_formatted'] }}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200"></div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-history text-gray-400 text-sm"></i>
                        <div>
                            <p class="text-xs text-gray-500">Terakhir Diupdate</p>
                            <p class="text-sm font-medium text-gray-800">{{ $detail['updated_at_formatted'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 pt-4 border-t border-gray-200"
            wire:key="action-buttons-{{ $detail['id'] }}">

            <!-- Kembali Button -->
            <button wire:click="$set('detailId', null)" type="button"
                class="order-2 sm:order-1 px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition font-medium cursor-pointer">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>

            <!-- Action Buttons (Terima & Tolak) -->
            @if ($detail['status'] === 'pending')
                <div class="order-1 sm:order-2 flex flex-col sm:flex-row gap-3">
                    <!-- Tolak Button -->
                    <button type="button" onclick="confirmReject('{{ $detail['id'] }}')" wire:loading.attr="disabled"
                        wire:target="reject"
                        class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-lg hover:shadow-xl disabled:opacity-75 disabled:cursor-not-allowed cursor-pointer">
                        <span wire:loading.remove wire:target="reject" class="flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Tolak
                        </span>
                        <span wire:loading wire:target="reject" class="flex items-center justify-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Memproses...
                        </span>
                    </button>

                    <!-- Terima Button -->
                    <button type="button" onclick="confirmApprove('{{ $detail['id'] }}')" wire:loading.attr="disabled"
                        wire:target="approve"
                        class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-lg hover:shadow-xl disabled:opacity-75 disabled:cursor-not-allowed cursor-pointer">
                        <span wire:loading.remove wire:target="approve" class="flex items-center justify-center">
                            <i class="fas fa-check mr-2"></i>Terima
                        </span>
                        <span wire:loading wire:target="approve" class="flex items-center justify-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Memproses...
                        </span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- SweetAlert Scripts -->
<script>
    function confirmApprove(id) {
        Swal.fire({
            title: 'Setujui Surat?',
            html: '<p class="text-gray-600">Surat ini akan disetujui dan diproses lebih lanjut.</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Setujui!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-medium shadow-lg',
                cancelButton: 'px-6 py-2.5 rounded-lg font-medium'
            },
            buttonsStyling: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('approve', id);
            }
        });
    }

    function confirmReject(id) {
        Swal.fire({
            title: 'Tolak Surat?',
            html: '<p class="text-gray-600">Surat ini akan ditolak dan tidak diproses.</p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-times mr-2"></i>Ya, Tolak!',
            cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'px-6 py-2.5 rounded-lg font-medium shadow-lg',
                cancelButton: 'px-6 py-2.5 rounded-lg font-medium'
            },
            buttonsStyling: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('reject', id);
            }
        });
    }
</script>
