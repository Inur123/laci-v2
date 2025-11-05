<!-- filepath: resources/views/livewire/sekretaris-pac/pengajuan-surat/index.blade.php -->
<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengajuan Surat PAC</h1>
            <p class="text-sm text-gray-600 mt-1">Daftar pengajuan surat yang Anda buat</p>
        </div>
        <button wire:click="create"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
            <i class="fas fa-plus mr-2"></i>Ajukan Surat
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Pengajuan Surat</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">No Surat</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Penerima</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Keperluan</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($surats as $index => $surat)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-sm text-gray-800 font-semibold">{{ $surat->no_surat }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700 capitalize">{{ $surat->penerima }}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">
                            {{ $surat->tanggal ? $surat->tanggal->format('d M Y') : '-' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $surat->keperluan }}</td>
                        <td class="py-3 px-4 text-sm">
                            @if($surat->status === 'pending')
                            <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">Pending</span>
                            @elseif($surat->status === 'diterima')
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs">Diterima</span>
                            @elseif($surat->status === 'ditolak')
                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs">Ditolak</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <button wire:click="detail('{{ $surat->id }}')"
                                    class="text-green-600 hover:text-green-800 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($surat->status === 'pending')
                                <button wire:click="edit('{{ $surat->id }}')"
                                    class="text-yellow-600 hover:text-yellow-800 transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endif
                                <button onclick="confirmDeletePengajuan('{{ $surat->id }}', '{{ $surat->no_surat }}')"
                                    class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                            <i class="fas fa-envelope-open-text text-4xl mb-2 block"></i>
                            <p>Belum ada pengajuan surat</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDeletePengajuan(id, noSurat) {
    Swal.fire({
        title: 'Hapus Pengajuan Surat?',
        html: `Surat <strong>${noSurat}</strong> akan dihapus secara permanen!`,
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
