<!-- filepath: resources/views/livewire/sekretaris-pac/pengajuan-surat/create.blade.php -->
<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Ajukan Surat Baru</h1>
            <p class="text-sm text-gray-600 mt-1">Isi data pengajuan surat</p>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Surat</label>
                    <input type="text" wire:model.defer="no_surat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm"
                        placeholder="Nomor surat">
                    @error('no_surat')
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penerima</label>
                    <select wire:model.defer="penerima"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                        <option value="">Pilih Penerima</option>
                        <option value="ipnu">IPNU</option>
                        <option value="ippnu">IPPNU</option>
                        <option value="bersama">Bersama</option>
                    </select>
                    @error('penerima')
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Surat</label>
                    <input type="date" wire:model.defer="tanggal"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('tanggal')
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                    <input type="text" wire:model.defer="keperluan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm"
                        placeholder="Keperluan surat">
                    @error('keperluan')
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea wire:model.defer="deskripsi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm" rows="2"
                        placeholder="Deskripsi tambahan"></textarea>
                    @error('deskripsi')
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        File Surat
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-green-500 transition">
                        <input type="file" wire:model="file"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                            id="fileInput"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Maksimal 10MB. Format: PDF, Word (DOC/DOCX), Excel (XLS/XLSX), PowerPoint (PPT/PPTX). File akan dienkripsi secara otomatis.
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
                            <span class="text-sm">Mengupload file...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="relative px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-75 disabled:cursor-not-allowed cursor-pointer">

                    <!-- Teks Normal -->
                    <span wire:loading.remove wire:target="save" class="flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Ajukan Surat
                    </span>

                    <!-- Loading State -->
                    <span wire:loading wire:target="save" class="flex items-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Mengirim...
                    </span>
                </button>

                <button type="button" wire:click="back"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                    <i class="fas fa-arrow-left mr-2"></i>Batal
                </button>
            </div>
        </form>
    </div>
</div>
