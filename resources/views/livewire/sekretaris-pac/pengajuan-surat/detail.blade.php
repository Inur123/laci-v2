<!-- filepath: resources/views/livewire/sekretaris-pac/arsip-surat/detail.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Surat</h1>
                <p class="text-sm text-gray-600 mt-1">Informasi lengkap surat</p>
            </div>
            <button wire:click="back" class="text-gray-600 hover:text-gray-800 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Badge Jenis Surat -->
        <div class="mb-6">
            @if($surat->jenis_surat === 'masuk')
                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm font-medium">
                    <i class="fas fa-inbox mr-2"></i>Surat Masuk
                </span>
            @else
                <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium">
                    <i class="fas fa-paper-plane mr-2"></i>Surat Keluar
                </span>
            @endif
        </div>

        <!-- Detail Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- No Surat -->
            <div class="border-b border-gray-200 pb-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Surat</label>
                <p class="text-lg font-semibold text-gray-900">{{ $surat->no_surat }}</p>
            </div>

            <!-- Tanggal -->
            <div class="border-b border-gray-200 pb-4">
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Surat</label>
                <p class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-calendar-alt text-green-600 mr-2"></i>
                    {{ $surat->tanggal->format('d F Y') }}
                </p>
            </div>

            <!-- Pengirim/Penerima -->
            <div class="border-b border-gray-200 pb-4 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">
                    {{ $surat->jenis_surat === 'masuk' ? 'Pengirim' : 'Penerima' }}
                </label>
                <p class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-user text-green-600 mr-2"></i>
                    {{ $surat->pengirim_penerima }}
                </p>
            </div>

            <!-- Deskripsi -->
            <div class="border-b border-gray-200 pb-4 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi/Perihal</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-line">{{ $surat->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>

            <!-- Status Surat -->
            <div class="border-b border-gray-200 pb-4 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-2">Status</label>
                <p class="text-lg font-semibold text-gray-900">
                    @if($surat->status === 'pending')
                        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">Pending</span>
                    @elseif($surat->status === 'diterima')
                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs">Diterima</span>
                    @elseif($surat->status === 'ditolak')
                        <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs">Ditolak</span>
                    @else
                        <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs">{{ $surat->status }}</span>
                    @endif
                </p>
            </div>

            <!-- File Attachment -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-3">File Lampiran</label>
                @if($surat->file)
                    <div class="border-2 border-green-200 rounded-lg p-4 bg-green-50">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-3 rounded-lg">
                                    <i class="fas fa-file-pdf text-3xl text-red-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-900">File Surat (PDF)</p>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-lock text-green-600 mr-1"></i>
                                        File terenkripsi dengan aman
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('pac.pengajuan-pac.view-file', $surat->id) }}" target="_blank"
   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
    <i class="fas fa-download mr-2"></i>Download
</a>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <i class="fas fa-file-excel text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Tidak ada file lampiran</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Metadata -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Sistem</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-user-circle text-green-600 mr-2"></i>
                    <span class="font-medium mr-2">Dibuat oleh:</span>
                    <span>{{ $surat->user->name }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-clock text-green-600 mr-2"></i>
                    <span class="font-medium mr-2">Dibuat pada:</span>
                    <span>{{ $surat->created_at->format('d M Y, H:i') }}</span>
                </div>
                @if($surat->updated_at != $surat->created_at)
                    <div class="flex items-center text-sm text-gray-600 md:col-span-2">
                        <i class="fas fa-edit text-green-600 mr-2"></i>
                        <span class="font-medium mr-2">Terakhir diupdate:</span>
                        <span>{{ $surat->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between gap-3 mt-6 pt-6 border-t border-gray-200">
            <button wire:click="back"
                class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            @if($surat->status === 'pending')
                <button wire:click="edit('{{ $surat->id }}')"
                    class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit Surat
                </button>
            @endif
        </div>
    </div>
</div>
