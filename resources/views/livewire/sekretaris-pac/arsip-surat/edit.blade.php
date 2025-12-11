<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-pac/arsip-surat/edit.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Surat</h1>
                <p class="text-sm text-gray-600 mt-1">Perbarui informasi surat</p>
            </div>

        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form wire:submit.prevent="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- No Surat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="no_surat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('no_surat') border-red-500 @enderror">
                    @error('no_surat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Surat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="jenis_surat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('jenis_surat') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        <option value="masuk">Surat Masuk</option>
                        <option value="keluar">Surat Keluar</option>
                    </select>
                    @error('jenis_surat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="tanggal"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('tanggal') border-red-500 @enderror">
                    @error('tanggal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pengirim/Penerima -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pengirim/Penerima <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="pengirim_penerima"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('pengirim_penerima') border-red-500 @enderror">
                    @error('pengirim_penerima')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea wire:model="deskripsi" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                            placeholder="Masukkan deskripsi"></textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Perihal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Perihal</label>
                        <input type="text" wire:model="perihal"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('perihal') border-red-500 @enderror"
                            placeholder="Perihal / singkat isi surat">
                        @error('perihal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <!-- File Upload -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        File Surat (Opsional - Max 10MB)
                    </label>

                    <!-- Current File Info -->
                    @if ($oldFile)
                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center text-green-700">
                                <i class="fas fa-file-alt text-2xl mr-3"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">File saat ini tersedia</p>
                                    <p class="text-xs text-green-600">File terenkripsi dengan aman</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-green-500 transition">
                        <input type="file" wire:model="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Kosongkan jika tidak ingin mengubah file. Maksimal 10MB. Format: PDF, Word, Excel, PowerPoint.
                        </p>
                    </div>
                    @error('file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Upload Progress -->
                    <div wire:loading wire:target="file" class="mt-3">
                        <div class="flex items-center text-green-600">
                            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="text-sm">Mengupload file baru...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="button" wire:click="back"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition cursor-pointer"
                    wire:loading.attr="disabled" wire:target="update">
                    <span wire:loading.remove wire:target="update">
                        <i class="fas fa-save mr-2"></i>Update Surat
                    </span>
                    <span wire:loading wire:target="update">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Mengupdate...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
