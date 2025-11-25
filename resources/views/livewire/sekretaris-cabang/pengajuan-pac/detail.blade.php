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
    <div class="mt-8 flex gap-2">
        <button wire:click="$set('detailId', null)"
            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </button>
        @if ($detail['status'] === 'pending')
            <button onclick="confirmApprove('{{ $detail['id'] }}')"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                <i class="fas fa-check mr-1"></i>Terima
            </button>
            <button onclick="confirmReject('{{ $detail['id'] }}')"
                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                <i class="fas fa-times mr-1"></i>Tolak
            </button>
        @endif
    </div>
</div>
