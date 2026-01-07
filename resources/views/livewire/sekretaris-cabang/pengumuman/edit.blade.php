<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Pengumuman</h1>
            <p class="text-sm text-gray-600 mt-1">Edit pengumuman: {{ $pengumuman->judul }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <form wire:submit="update">
            <div class="grid grid-cols-1 gap-4 sm:gap-6">
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="judul"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                    @error('judul')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Isi Pengumuman <span class="text-red-500">*</span>
                    </label>

                    <div wire:ignore>
                        <textarea id="isiEditor" class="w-full"></textarea>
                    </div>

                    @error('isi')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" wire:click="back"
                    class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm sm:text-base cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm sm:text-base cursor-pointer">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
