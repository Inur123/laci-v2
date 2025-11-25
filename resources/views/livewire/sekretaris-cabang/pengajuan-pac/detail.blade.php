<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
        <i class="fas fa-envelope text-blue-600"></i>
        Detail Pengajuan Surat PAC
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <!-- No Surat -->
        <div>
            <p class="text-sm text-gray-500 mb-1">No Surat</p>
            <p class="font-semibold text-gray-800">{{ $detail['no_surat'] }}</p>
        </div>
        <!-- Penerima -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Penerima</p>
            <p class="font-semibold text-gray-800">{{ $detail['penerima'] }}</p>
        </div>
        <!-- Tanggal -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Tanggal</p>
            <p class="font-semibold text-gray-800">{{ $detail['tanggal_formatted'] }}</p>
        </div>
        <!-- Keperluan -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Keperluan</p>
            <p class="font-semibold text-gray-800">{{ $detail['keperluan'] }}</p>
        </div>
        <!-- Deskripsi -->
        <div class="md:col-span-2">
            <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
            <p class="font-semibold text-gray-800">{{ $detail['deskripsi'] }}</p>
        </div>
        <!-- File Surat -->
        @if ($detail['has_file'])
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500 mb-1">File Surat</p>
                <a href="{{ route('cabang.pengajuan-pac.file', $detail['id']) }}" target="_blank"
                    class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition font-medium text-sm">
                    <i class="fas fa-file-alt mr-2"></i>Lihat File
                </a>
            </div>
        @endif
        <!-- Status -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Status</p>
            <span
                class="px-2 py-1 rounded-full text-xs font-medium
                {{ $detail['status'] === 'pending' ? 'bg-yellow-100 text-yellow-700' : ($detail['status'] === 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                {{ ucfirst($detail['status']) }}
            </span>
        </div>
        <!-- Tanggal dibuat -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Dibuat</p>
            <p class="font-semibold text-gray-800">{{ $detail['created_at_formatted'] }}</p>
        </div>
        <!-- Tanggal diupdate -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Diupdate</p>
            <p class="font-semibold text-gray-800">{{ $detail['updated_at_formatted'] }}</p>
        </div>
        <!-- Pengaju -->
        <div>
            <p class="text-sm text-gray-500 mb-1">Pengaju</p>
            <p class="font-semibold text-gray-800">{{ $detail['user']['name'] }} ({{ $detail['user']['email'] }})</p>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex justify-between mt-6" wire:key="action-buttons-{{ $detail['id'] }}">
    <!-- Kembali / Batal di kiri -->
    <button wire:click="$set('detailId', null)" type="button"
        class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </button>

    <!-- Tombol Terima & Tolak di kanan -->
    @if ($detail['status'] === 'pending')
        <div class="flex gap-3">
            <!-- Terima -->
            <button type="button" onclick="confirmApprove('{{ $detail['id'] }}')"
                wire:loading.attr="disabled" wire:target="approve"
                class="relative px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-75 disabled:cursor-not-allowed">

                <span wire:loading.remove wire:target="approve" class="flex items-center">
                    <i class="fas fa-check mr-2"></i>Terima
                </span>

                <span wire:loading wire:target="approve" class="flex items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...
                </span>
            </button>

            <!-- Tolak -->
            <button type="button" onclick="confirmReject('{{ $detail['id'] }}')"
                wire:loading.attr="disabled" wire:target="reject"
                class="relative px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-75 disabled:cursor-not-allowed">

                <span wire:loading.remove wire:target="reject" class="flex items-center">
                    <i class="fas fa-times mr-2"></i>Tolak
                </span>

                <span wire:loading wire:target="reject" class="flex items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...
                </span>
            </button>
        </div>
    @endif
</div>

<script>
function confirmApprove(id) {
    Swal.fire({
        title: 'Setujui Surat?',
        text: 'Surat ini akan disetujui dan diproses lebih lanjut.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#22c55e',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Setujui!',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-4 py-2 rounded-lg',
            cancelButton: 'px-4 py-2 rounded-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            @this.call('approve', id);
        }
    });
}

function confirmReject(id) {
    Swal.fire({
        title: 'Tolak Surat?',
        text: 'Surat ini akan ditolak dan tidak diproses.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-times mr-2"></i>Ya, Tolak!',
        cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-4 py-2 rounded-lg',
            cancelButton: 'px-4 py-2 rounded-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            @this.call('reject', id);
        }
    });
}
</script>

</div>
