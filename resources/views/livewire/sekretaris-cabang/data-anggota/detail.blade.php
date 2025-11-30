<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/data-anggota/detail.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Anggota</h1>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap anggota</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <!-- Avatar -->
                <div class="text-center mb-6">
                    <img src="{{ $anggota->avatar_url }}"
                        class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-100"
                        alt="{{ $anggota->nama_lengkap }}">
                    <h3 class="text-xl font-bold text-gray-800 mt-4">{{ $anggota->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-600">{{ $anggota->periode->nama }}</p>

                    @if ($anggota->jabatan)
                        <div class="mt-3">
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                {{ $anggota->jabatan }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Quick Info -->
                <div class="space-y-3 border-t border-gray-100 pt-4">
                    @if ($anggota->jenis_kelamin)
                        <div class="flex items-center text-sm">
                            <i
                                class="fas {{ $anggota->jenis_kelamin === 'Laki-laki' ? 'fa-male text-blue-600' : 'fa-female text-pink-600' }} w-6"></i>
                            <span class="text-gray-700">{{ $anggota->jenis_kelamin }}</span>
                        </div>
                    @endif

                    @if ($anggota->tanggal_lahir)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-birthday-cake text-purple-600 w-6"></i>
                            <span class="text-gray-700">
                                {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') }}
                                ({{ $anggota->umur }} tahun)
                            </span>
                        </div>
                    @endif

                    @if ($anggota->no_hp)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-phone text-green-600 w-6"></i>
                            <span class="text-gray-700">{{ $anggota->no_hp }}</span>
                        </div>
                    @endif

                    @if ($anggota->email)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-envelope text-red-600 w-6"></i>
                            <span class="text-gray-700 break-all">{{ $anggota->email }}</span>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="space-y-2 mt-6 border-t border-gray-100 pt-4">
                    <button wire:click="edit('{{ $anggota->id }}')"
                        class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm cursor-pointer">
                        <i class="fas fa-edit mr-2"></i>Edit Data
                    </button>

                    <button wire:click="back"
                        class="w-full bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 hover:text-gray-800 transition text-sm cursor-pointer flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </button>
                </div>

            </div>
        </div>

        <!-- Detail Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Identitas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-id-card text-blue-600 mr-2"></i>
                    Identitas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500">NIK</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">NIA</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->nia ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">No. RFID</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->no_rfid ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Periode</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->periode->nama }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Pribadi -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-green-600 mr-2"></i>
                    Data Pribadi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500">Nama Lengkap</label>
                        <p class="text-sm text-gray-800 mt-1 font-medium">{{ $anggota->nama_lengkap }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Jenis Kelamin</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Tempat Lahir</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->tempat_lahir ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Tanggal Lahir</label>
                        <p class="text-sm text-gray-800 mt-1">
                            @if ($anggota->tanggal_lahir)
                                {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d F Y') }}
                                <span class="text-xs text-gray-500">({{ $anggota->umur }} tahun)</span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs font-medium text-gray-500">Alamat Lengkap</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->alamat_lengkap ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Kontak -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-phone text-purple-600 mr-2"></i>
                    Kontak
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500">No. HP / WhatsApp</label>
                        <p class="text-sm text-gray-800 mt-1">
                            @if ($anggota->no_hp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $anggota->no_hp) }}"
                                    target="_blank" class="text-green-600 hover:text-green-700">
                                    <i class="fab fa-whatsapp mr-1"></i>{{ $anggota->no_hp }}
                                </a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Email</label>
                        <p class="text-sm text-gray-800 mt-1">
                            @if ($anggota->email)
                                <a href="mailto:{{ $anggota->email }}" class="text-blue-600 hover:text-blue-700">
                                    {{ $anggota->email }}
                                </a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                    Informasi Tambahan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500">Jabatan</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->jabatan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Hobi</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->hobi ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Dibuat Oleh</label>
                        <p class="text-sm text-gray-800 mt-1">{{ $anggota->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Tanggal Dibuat</label>
                        <p class="text-sm text-gray-800 mt-1">
                            {{ $anggota->created_at->format('d M Y, H:i') }}
                            <span class="text-xs text-gray-500">({{ $anggota->created_at->diffForHumans() }})</span>
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Terakhir Diupdate</label>
                        <p class="text-sm text-gray-800 mt-1">
                            {{ $anggota->updated_at->format('d M Y, H:i') }}
                            <span class="text-xs text-gray-500">({{ $anggota->updated_at->diffForHumans() }})</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-shield-alt text-blue-600 mt-1 mr-3"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">🔐 Data Terenkripsi</p>
                        <p>Semua data pribadi anggota ini telah dienkripsi untuk menjaga keamanan dan privasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
