<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/data-anggota/periode/create.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah Periode Baru</h1>
            <p class="text-sm text-gray-600 mt-1">Tambahkan periode kepengurusan baru</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <form wire:submit="save">
            <div class="space-y-6">
                <!-- Nama Periode -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Periode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="nama"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
                        placeholder="Contoh: Periode 2023-2025">
                    @error('nama')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        Gunakan format yang jelas, misalnya: "Periode 2023-2025" atau "Kepengurusan 2023-2025"
                    </p>
                </div>

                <!-- Preview Card -->
                @if($nama)
                    <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-lg">
                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-gray-800 text-lg">{{ $nama }}</h4>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-calendar mr-1"></i>
                                Dibuat: {{ now()->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" wire:click="back"
                    class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm sm:text-base cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm sm:text-base cursor-pointer">
                    <i class="fas fa-save mr-2"></i>Simpan Periode
                </button>
            </div>
        </form>
    </div>
</div>
