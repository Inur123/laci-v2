<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/arsip-surat/edit.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Surat</h1>
            <p class="text-sm text-gray-600 mt-1">Edit data surat {{ $surat->no_surat }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <form wire:submit="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Nomor Surat -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="no_surat"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                    @error('no_surat')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Surat -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="jenis_surat"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                        <option value="">Pilih Jenis</option>
                        <option value="masuk">Surat Masuk</option>
                        <option value="keluar">Surat Keluar</option>
                    </select>
                    @error('jenis_surat')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="tanggal"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                    @error('tanggal')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pengirim/Penerima -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pengirim/Penerima <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="pengirim_penerima"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                    @error('pengirim_penerima')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Deskripsi -->
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea wire:model="deskripsi" rows="4"
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
                            placeholder="Masukkan deskripsi"></textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Perihal -->
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Perihal</label>
                        <input type="text" wire:model="perihal"
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base"
                            placeholder="Perihal / singkat isi surat">
                        @error('perihal')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- File Upload -->
                <div class="md:col-span-2 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload File Baru (Opsional - Max 10MB)
                    </label>

                    @if ($surat->file)
                        <div
                            class="mb-3 p-3 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border border-gray-200">

                            <div class="flex items-center gap-3">
                                <div class="bg-blue-500 p-2 rounded-lg">
                                    <i class="fas fa-file-alt text-white text-lg"></i>
                                </div>
                                <div>
                                    <span class="text-xs sm:text-sm text-gray-800 font-medium block">
                                        {{ $surat->original_filename }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-lock mr-1"></i>Terenkripsi
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('cabang.arsip-surat.view-file', $surat->id) }}" target="_blank"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-xs sm:text-sm font-medium shadow hover:shadow-lg whitespace-nowrap">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                    @endif

                    <input type="file" wire:model="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                        class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Kosongkan jika tidak ingin mengubah file. Format: PDF, Word, Excel, PowerPoint.
                    </p>
                    @error('file')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="file" class="mt-2 text-xs sm:text-sm text-blue-600">
                        <i class="fas fa-spinner fa-spin mr-1"></i>Mengupload file...
                    </div>
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
