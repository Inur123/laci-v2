<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/data-user-pac/detail.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-row items-center justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Detail User PAC</h1>
            <p class="text-sm text-gray-600 mt-1 break-words">
                Informasi lengkap user {{ $user->name }}
            </p>
        </div>

        <button wire:click="back"
            class="text-white bg-gray-600 hover:bg-gray-700 transition rounded-lg px-3 sm:px-4 py-2 whitespace-nowrap cursor-pointer">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=3b82f6&color=fff"
                        class="w-24 h-24 sm:w-32 sm:h-32 rounded-full mx-auto mb-3 sm:mb-4" alt="Avatar">

                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-1 break-words px-2">{{ $user->name }}</h2>
                    <p class="text-xs sm:text-sm text-gray-600 mb-4 break-all px-2">{{ $user->email }}</p>

                    <!-- Status Badges -->
                    <div class="flex flex-wrap justify-center gap-2 mb-6">
                        @if ($user->is_active)
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Akun Aktif
                            </span>
                        @else
                            <span
                                class="inline-block px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">
                                <i class="fas fa-ban mr-1"></i>Akun Nonaktif
                            </span>
                        @endif

                        @if ($user->email_verified_at)
                            <span
                                class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                <i class="fas fa-envelope-circle-check mr-1"></i>Email Verified
                            </span>
                        @else
                            <span
                                class="inline-block px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Email Unverified
                            </span>
                        @endif

                        <span
                            class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-medium">
                            <i class="fas fa-user-shield mr-1"></i>Sekretaris PAC
                        </span>
                    </div>

                    <!-- Actions with SweetAlert -->
                    <div class="space-y-2">
                        <!-- Toggle Status Button -->
                        <button
                            onclick="confirmToggleStatus('{{ $user->id }}', '{{ addslashes($user->name) }}', {{ $user->is_active ? 'true' : 'false' }})"
                            class="w-full px-3 sm:px-4 py-2 {{ $user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition text-xs sm:text-sm flex items-center justify-center cursor-pointer">
                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }} mr-2"></i>
                            {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                        </button>

                        <!-- Reset Password Button -->
                        <button onclick="confirmResetPassword('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                            class="w-full px-3 sm:px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-xs sm:text-sm flex items-center justify-center cursor-pointer">
                            <i class="fas fa-key mr-2"></i>Reset Password
                        </button>
                        <button onclick="confirmDeleteUser('{{ $user->id }}', '{{ addslashes($user->name) }}')"
    class="w-full px-3 sm:px-4 py-2 bg-red-700 hover:bg-red-800 text-white rounded-lg transition text-xs sm:text-sm flex items-center justify-center cursor-pointer">
    <i class="fas fa-trash mr-2"></i>Hapus Akun
</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details & Activity -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Periode Filter -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-calendar-alt mr-1"></i>Filter Periode
                </label>

                <div class="space-y-3">
                    <select wire:model.live="selectedPeriodeId"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-white">
                        <option value="">Semua Periode</option>
                        @foreach ($availablePeriodes as $periode)
                            <option value="{{ $periode['id'] }}">
                                {{ $periode['label'] }}@if ($periode['is_active']) (AKTIF)@endif
                            </option>
                        @endforeach
                    </select>

                    @if ($selectedPeriodeId)
                        <button wire:click="$set('selectedPeriodeId', null)"
                            class="w-full px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>
                            <span>Reset Filter</span>
                        </button>
                    @endif
                </div>

                @php
                    $currentPeriode = $availablePeriodes->firstWhere('id', $selectedPeriodeId);
                @endphp

                @if ($selectedPeriodeId && $currentPeriode)
                    <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                        <div class="flex flex-wrap items-center gap-2 text-sm">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            <span class="text-gray-700">Menampilkan data:</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-medium">
                                {{ $currentPeriode['label'] }}
                            </span>
                            @if ($currentPeriode['is_active'])
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-circle-check mr-1"></i>Aktif
                                </span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Menampilkan data dari semua periode</span>
                        </p>
                    </div>
                @endif
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                <!-- Arsip Surat Stats -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-4 sm:p-5 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <i class="fas fa-envelope text-2xl sm:text-3xl opacity-80"></i>
                        <span class="text-2xl sm:text-3xl font-bold">{{ $stats['total_surat'] }}</span>
                    </div>
                    <h3 class="text-sm sm:text-base font-semibold mb-2">Arsip Surat</h3>
                    <div class="text-xs opacity-90 space-y-1 mb-3">
                        <div class="flex items-center justify-between">
                            <span><i class="fas fa-inbox mr-1"></i>Surat Masuk</span>
                            <span class="font-semibold">{{ $stats['surat_masuk'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span><i class="fas fa-paper-plane mr-1"></i>Surat Keluar</span>
                            <span class="font-semibold">{{ $stats['surat_keluar'] }}</span>
                        </div>
                    </div>
                    <button wire:click="exportArsipSurat" wire:loading.attr="disabled"
                        class="mt-2 w-full bg-white/20 hover:bg-white/30 px-3 py-2 rounded
                               text-xs sm:text-sm transition flex items-center justify-center gap-2
                               disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">

                        <!-- Normal -->
                        <span wire:loading.remove wire:target="exportArsipSurat">
                            <i class="fas fa-download"></i>
                            Download Excel
                        </span>

                        <!-- Loading -->
                        <span wire:loading wire:target="exportArsipSurat">
                            <i class="fas fa-spinner fa-spin"></i>
                            Mengunduh...
                        </span>
                    </button>
                </div>

                <!-- Data Anggota Stats -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow p-4 sm:p-5 text-white">
                    <div class="flex items-center justify-between mb-3">
                        <i class="fas fa-users text-2xl sm:text-3xl opacity-80"></i>
                        <span class="text-2xl sm:text-3xl font-bold">{{ $stats['total_anggota'] }}</span>
                    </div>
                    <h3 class="text-sm sm:text-base font-semibold mb-2">Data Anggota</h3>
                    <div class="text-xs opacity-90 mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-user-check mr-2"></i>
                            <span>Total anggota terdaftar</span>
                        </div>
                    </div>
                    <button wire:click="exportDataAnggota" wire:loading.attr="disabled"
                        class="mt-2 w-full bg-white/20 hover:bg-white/30 px-3 py-2 rounded
                               text-xs sm:text-sm transition flex items-center justify-center gap-2
                               disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">

                        <!-- Normal -->
                        <span wire:loading.remove wire:target="exportDataAnggota">
                            <i class="fas fa-download"></i>
                            Download Excel
                        </span>

                        <!-- Loading -->
                        <span wire:loading wire:target="exportDataAnggota">
                            <i class="fas fa-spinner fa-spin"></i>
                            Mengunduh...
                        </span>
                    </button>
                </div>

                <!-- Pengajuan Surat Stats -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow p-4 sm:p-5 text-white sm:col-span-2 xl:col-span-1">
                    <div class="flex items-center justify-between mb-3">
                        <i class="fas fa-file-signature text-2xl sm:text-3xl opacity-80"></i>
                        <span class="text-2xl sm:text-3xl font-bold">{{ $stats['total_pengajuan'] }}</span>
                    </div>
                    <h3 class="text-sm sm:text-base font-semibold mb-2">Pengajuan Surat</h3>
                    <div class="text-xs opacity-90 space-y-1 mb-3">
                        <div class="flex items-center justify-between">
                            <span><i class="fas fa-file-alt mr-1"></i>Total Pengajuan</span>
                            <span class="font-semibold">{{ $stats['total_pengajuan'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span><i class="fas fa-clock mr-1"></i>Pending</span>
                            <span class="font-semibold">{{ $stats['pengajuan_pending'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span><i class="fas fa-check-circle mr-1"></i>Diterima</span>
                            <span class="font-semibold">{{ $stats['pengajuan_diterima'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span><i class="fas fa-times-circle mr-1"></i>Ditolak</span>
                            <span class="font-semibold">{{ $stats['pengajuan_ditolak'] }}</span>
                        </div>
                    </div>
                    <button wire:click="exportPengajuan" wire:loading.attr="disabled"
                        class="mt-2 w-full bg-white/20 hover:bg-white/30 px-3 py-2 rounded
                               text-xs sm:text-sm transition flex items-center justify-center gap-2
                               disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">

                        <!-- Normal -->
                        <span wire:loading.remove wire:target="exportPengajuan">
                            <i class="fas fa-download"></i>
                            Download Excel
                        </span>

                        <!-- Loading -->
                        <span wire:loading wire:target="exportPengajuan">
                            <i class="fas fa-spinner fa-spin"></i>
                            Mengunduh...
                        </span>
                    </button>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informasi Akun
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">User ID</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800 break-all">{{ $user->id }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Role</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            {{ ucwords(str_replace('_', ' ', $user->role)) }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Terdaftar Sejak</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            {{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Terakhir Update</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            {{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Email Verified</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            @if ($user->email_verified_at)
                                {{ $user->email_verified_at->format('d M Y, H:i') }}
                            @else
                                <span class="text-yellow-600">Belum diverifikasi</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Status Akun</label>
                        <p
                            class="text-sm sm:text-base font-medium {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Terbaru - Arsip Surat -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-envelope text-blue-600 mr-2"></i>
                        <span>Arsip Surat Terbaru</span>
                    </h2>
                    @if($stats['latest_surat']->count() > 0)
                        <button wire:click="exportArsipSurat" wire:loading.attr="disabled"
                            class="w-full sm:w-auto text-xs sm:text-sm bg-blue-600 hover:bg-blue-700 text-white
                                   px-3 py-2 rounded-lg transition flex items-center justify-center gap-2
                                   disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">

                            <!-- Normal -->
                            <span wire:loading.remove wire:target="exportArsipSurat">
                                <i class="fas fa-file-excel"></i>
                                Export Excel
                            </span>

                            <!-- Loading -->
                            <span wire:loading wire:target="exportArsipSurat">
                                <i class="fas fa-spinner fa-spin"></i>
                                Mengunduh...
                            </span>
                        </button>
                    @endif
                </div>
                @if($stats['latest_surat']->count() > 0)
                    <div class="space-y-2">
                        @foreach($stats['latest_surat'] as $surat)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $surat->no_surat }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $surat->pengirim_penerima }}</p>
                                    <span class="inline-block text-xs px-2 py-1 rounded mt-1 {{ $surat->jenis_surat === 'masuk' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }}">
                                        {{ ucfirst($surat->jenis_surat) }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500 ml-2 whitespace-nowrap">{{ $surat->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fas fa-inbox text-2xl mb-2 block text-gray-400"></i>
                        Belum ada arsip surat
                    </p>
                @endif
            </div>

            <!-- Data Terbaru - Data Anggota -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-users text-green-600 mr-2"></i>
                        <span>Data Anggota Terbaru</span>
                    </h2>
                    @if($stats['latest_anggota']->count() > 0)
                        <button wire:click="exportDataAnggota" wire:loading.attr="disabled"
                            class="w-full sm:w-auto text-xs sm:text-sm bg-green-600 hover:bg-green-700 text-white
                                   px-3 py-2 rounded-lg transition flex items-center justify-center gap-2
                                   disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">

                            <!-- Normal -->
                            <span wire:loading.remove wire:target="exportDataAnggota">
                                <i class="fas fa-file-excel"></i>
                                Export Excel
                            </span>

                            <!-- Loading -->
                            <span wire:loading wire:target="exportDataAnggota">
                                <i class="fas fa-spinner fa-spin"></i>
                                Mengunduh...
                            </span>
                        </button>
                    @endif
                </div>
                @if($stats['latest_anggota']->count() > 0)
                    <div class="space-y-2">
                        @foreach($stats['latest_anggota'] as $anggota)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $anggota->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $anggota->jabatan }}</p>
                                </div>
                                <span class="text-xs text-gray-500 ml-2 whitespace-nowrap">{{ $anggota->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fas fa-users text-2xl mb-2 block text-gray-400"></i>
                        Belum ada data anggota
                    </p>
                @endif
            </div>

            <!-- Data Terbaru - Pengajuan Surat -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-file-signature text-purple-600 mr-2"></i>
                        <span>Pengajuan Surat Terbaru</span>
                    </h2>
                    @if($stats['latest_pengajuan']->count() > 0)
                        <button wire:click="exportPengajuan" wire:loading.attr="disabled"
                            class="w-full sm:w-auto text-xs sm:text-sm bg-purple-600 hover:bg-purple-700 text-white
                                   px-3 py-2 rounded-lg transition flex items-center justify-center gap-2
                                   disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">

                            <!-- Normal -->
                            <span wire:loading.remove wire:target="exportPengajuan">
                                <i class="fas fa-file-excel"></i>
                                Export Excel
                            </span>

                            <!-- Loading -->
                            <span wire:loading wire:target="exportPengajuan">
                                <i class="fas fa-spinner fa-spin"></i>
                                Mengunduh...
                            </span>
                        </button>
                    @endif
                </div>
                @if($stats['latest_pengajuan']->count() > 0)
                    <div class="space-y-2">
                        @foreach($stats['latest_pengajuan'] as $pengajuan)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $pengajuan->no_surat }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $pengajuan->keperluan }}</p>
                                    <span class="inline-block text-xs px-2 py-1 rounded mt-1
                                        {{ $pengajuan->status === 'pending' ? 'bg-yellow-100 text-yellow-600' :
                                           ($pengajuan->status === 'diterima' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600') }}">
                                        {{ ucfirst($pengajuan->status) }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500 ml-2 whitespace-nowrap">{{ $pengajuan->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fas fa-file-signature text-2xl mb-2 block text-gray-400"></i>
                        Belum ada pengajuan surat
                    </p>
                @endif
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-history text-blue-600 mr-2"></i>Aktivitas Terakhir
                </h2>
                <div class="space-y-3">
                    @if ($stats['latest_anggota']->count() > 0)
                        <div class="flex items-start space-x-3 pb-3 border-b border-gray-100">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                                <i class="fas fa-user-plus text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">Menambahkan anggota terakhir</p>
                                <p class="text-xs text-gray-500">
                                    {{ $stats['latest_anggota']->first()->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if ($stats['latest_surat']->count() > 0)
                        <div class="flex items-start space-x-3 pb-3 border-b border-gray-100">
                            <div class="bg-green-100 text-green-600 p-2 rounded-full">
                                <i class="fas fa-file-alt text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">Upload surat terakhir</p>
                                <p class="text-xs text-gray-500">
                                    {{ $stats['latest_surat']->first()->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-start space-x-3">
                        <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                            <i class="fas fa-sign-in-alt text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800">Terdaftar</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 Scripts --}}
<script>
    function confirmToggleStatus(id, name, isActive) {
        const action = isActive ? 'nonaktifkan' : 'aktifkan';
        const icon = isActive ? 'warning' : 'success';
        const confirmColor = isActive ? '#ef4444' : '#10b981';
        const title = isActive ? 'Nonaktifkan User?' : 'Aktifkan User?';
        const html = `Apakah Anda yakin ingin <strong>${action}</strong> akun <strong>${name}</strong>?`;

        Swal.fire({
            title: title,
            html: html,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6b7280',
            confirmButtonText: `<i class="fas fa-${isActive ? 'ban' : 'check-circle'} mr-2"></i>Ya, ${isActive ? 'Nonaktifkan' : 'Aktifkan'}!`,
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-4 py-2 rounded-lg',
                cancelButton: 'px-4 py-2 rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('toggleStatus', id);
            }
        });
    }

    function confirmResetPassword(id, name) {
        Swal.fire({
            title: 'Reset Password?',
            html: `Password untuk <strong>${name}</strong> akan direset menjadi:<br>
                   <code class="bg-gray-100 px-3 py-1 rounded text-sm">password123</code><br><br>
                   Lanjutkan?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-key mr-2"></i>Ya, Reset!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-4 py-2 rounded-lg',
                cancelButton: 'px-4 py-2 rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('resetPassword', id);
            }
        });
    }
    function confirmDeleteUser(id, name) {
        Swal.fire({
            title: 'Hapus User?',
            html: `Akun <strong>${name}</strong> akan dihapus secara permanen.<br>Anda yakin?`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
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
