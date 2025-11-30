<!-- filepath: resources/views/livewire/sekretaris-pac/data-anggota/edit.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Data Anggota</h1>
            <p class="text-sm text-gray-600 mt-1">Edit data {{ $anggota->nama_lengkap }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <form wire:submit.prevent="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Anggota</label>
                    <div class="flex items-center gap-4">
                        @if ($foto)
                            <img src="{{ $foto->temporaryUrl() }}" class="w-24 h-24 rounded-full object-cover">
                        @elseif($fotoLama)
                            <img src="{{ $anggota->decrypted_foto }}" class="w-24 h-24 rounded-full object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-3xl text-gray-400"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="foto" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                            @error('foto')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Max 2MB, format: JPG, PNG (Terenkripsi)</p>
                        </div>
                    </div>
                </div>

                <!-- Periode -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Periode <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="periode_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                        <option value="">Pilih Periode</option>
                        @foreach ($this->periodeList as $periode)
                            <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="nama_lengkap"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" wire:model="nik"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('nik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIA</label>
                    <input type="text" wire:model="nia"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('nia')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" wire:model="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                    <input type="text" wire:model="no_hp"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('no_hp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" wire:model="tempat_lahir"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('tempat_lahir')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" wire:model="tanggal_lahir"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('tanggal_lahir')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select wire:model="jenis_kelamin"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                    <input type="text" wire:model="jabatan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('jabatan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hobi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hobi</label>
                    <input type="text" wire:model="hobi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('hobi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No RFID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. RFID</label>
                    <input type="text" wire:model="no_rfid"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                    @error('no_rfid')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea wire:model="alamat_lengkap" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm"></textarea>
                    @error('alamat_lengkap')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="button" wire:click="back"
                    class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm cursor-pointer">
                    <i class="fas fa-save mr-2"></i>Update Anggota
                </button>
            </div>
        </form>
    </div>
</div>
