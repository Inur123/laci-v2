<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/kalender-kegiatan/create.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah Kegiatan Baru</h1>
            <p class="text-sm text-gray-600 mt-1">Tambahkan kegiatan baru ke kalender</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Judul -->
                <div class="md:col-span-2 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="judul"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
                        placeholder="Rapat Koordinasi Pengurus">
                    @error('judul')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal & Waktu Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" wire:model="tanggal_mulai"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal & Waktu Selesai (Opsional)
                    </label>
                    <input type="datetime-local" wire:model="tanggal_selesai"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                    @error('tanggal_selesai')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" wire:model="lokasi"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
                        placeholder="Kantor PC IPNU">
                    @error('lokasi')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Warna Kalender <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" wire:model.live="warna"
                            class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                        <input type="text" wire:model="warna"
                            class="flex-1 px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
                            placeholder="#3788d8" maxlength="7">
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <button type="button" wire:click="$set('warna', '#3788d8')"
                            class="w-8 h-8 rounded-full bg-[#3788d8] border-2 border-gray-300 hover:border-gray-400 transition cursor-pointer"
                            title="Biru"></button>
                        <button type="button" wire:click="$set('warna', '#22c55e')"
                            class="w-8 h-8 rounded-full bg-[#22c55e] border-2 border-gray-300 hover:border-gray-400 transition cursor-pointer"
                            title="Hijau"></button>
                        <button type="button" wire:click="$set('warna', '#ef4444')"
                            class="w-8 h-8 rounded-full bg-[#ef4444] border-2 border-gray-300 hover:border-gray-400 transition cursor-pointer"
                            title="Merah"></button>
                        <button type="button" wire:click="$set('warna', '#f59e0b')"
                            class="w-8 h-8 rounded-full bg-[#f59e0b] border-2 border-gray-300 hover:border-gray-400 transition cursor-pointer"
                            title="Kuning"></button>
                        <button type="button" wire:click="$set('warna', '#8b5cf6')"
                            class="w-8 h-8 rounded-full bg-[#8b5cf6] border-2 border-gray-300 hover:border-gray-400 transition cursor-pointer"
                            title="Ungu"></button>
                        <button type="button" wire:click="$set('warna', '#ec4899')"
                            class="w-8 h-8 rounded-full bg-[#ec4899] border-2 border-gray-300 hover:border-gray-400 transition cursor-pointer"
                            title="Pink"></button>
                    </div>
                    @error('warna')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi/Detail Kegiatan
                    </label>
                    <textarea wire:model="deskripsi" rows="4"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
                        placeholder="Masukkan detail kegiatan..."></textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Preview Card -->
            @if($judul || $tanggal_mulai)
                <div class="mt-6 p-4 border-2 border-dashed rounded-lg" style="border-color: {{ $warna }};">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <div class="border-l-4 p-4 rounded-r" style="border-color: {{ $warna }}; background-color: {{ $warna }}20;">
                        <h4 class="font-semibold text-gray-800 mb-1">{{ $judul ?: 'Judul Kegiatan' }}</h4>
                        @if($tanggal_mulai)
                            <p class="text-sm text-gray-600 mb-1">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d M Y, H:i') }} WIB
                                @if($tanggal_selesai)
                                    - {{ \Carbon\Carbon::parse($tanggal_selesai)->format('H:i') }} WIB
                                @endif
                            </p>
                        @endif
                        @if($lokasi)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $lokasi }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" wire:click="back"
                    class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm sm:text-base cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm sm:text-base cursor-pointer">
                    <i class="fas fa-save mr-2"></i>Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
