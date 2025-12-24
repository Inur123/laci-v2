<!-- filepath: resources/views/livewire/sekretaris-pac/data-anggota/periode/create.blade.php -->
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Periode</h1>
        <p class="text-sm text-gray-600 mt-1">Isi data periode kepengurusan baru</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Periode</label>
                <input type="text" wire:model.defer="nama"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                    placeholder="Contoh: 2024-2025">
                @error('nama')
                    <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition cursor-pointer">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button" wire:click="back"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </button>
            </div>
        </form>
    </div>
</div>
