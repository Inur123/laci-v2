<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/dashboard.blade.php -->
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-green-100 text-lg">Dashboard Sekretaris Cabang IPNU</p>
                <p class="text-green-200 text-sm mt-2">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                    <i class="fas fa-building text-6xl text-white/80"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total PAC -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-100 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-map-marked-alt text-2xl text-blue-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">
                        <i class="fas fa-arrow-up"></i> +2
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total PAC</h3>
                <p class="text-3xl font-bold text-gray-800">25</p>
                <p class="text-xs text-gray-500 mt-2">PAC terdaftar aktif</p>
            </div>
            <div class="bg-blue-50 px-6 py-3">
                <a href="{{ route('cabang.data-user-pac') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Anggota -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-2xl text-green-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">
                        <i class="fas fa-arrow-up"></i> +45
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Anggota</h3>
                <p class="text-3xl font-bold text-gray-800">3,500</p>
                <p class="text-xs text-gray-500 mt-2">Anggota dari semua PAC</p>
            </div>
            <div class="bg-green-50 px-6 py-3">
                <a href="{{ route('cabang.data-anggota') }}" class="text-sm text-green-600 hover:text-green-700 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Pengajuan PAC -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-100 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-import text-2xl text-yellow-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">
                        <i class="fas fa-clock"></i> 3 Baru
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Pengajuan PAC</h3>
                <p class="text-3xl font-bold text-gray-800">12</p>
                <p class="text-xs text-gray-500 mt-2">Menunggu persetujuan</p>
            </div>
            <div class="bg-yellow-50 px-6 py-3">
                <a href="{{ route('cabang.pengajuan-pac') }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Arsip Surat -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-100 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-folder text-2xl text-purple-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                        <i class="fas fa-plus"></i> 5 Baru
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Arsip Surat</h3>
                <p class="text-3xl font-bold text-gray-800">148</p>
                <p class="text-xs text-gray-500 mt-2">Total surat terarsip</p>
            </div>
            <div class="bg-purple-50 px-6 py-3">
                <a href="{{ route('cabang.arsip-surat') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts & Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md overflow-hidden">
            <div class="border-b border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-clock text-green-600 mr-3"></i>
                        Aktivitas Terbaru
                    </h3>
                    <button class="text-sm text-green-600 hover:text-green-700 font-medium">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Activity Item -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex-shrink-0">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <i class="fas fa-file-alt text-green-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Surat Edaran Baru</p>
                            <p class="text-sm text-gray-500">PAC Sukodono mengirim surat edaran kegiatan</p>
                            <p class="text-xs text-gray-400 mt-1">2 jam yang lalu</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex-shrink-0">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Anggota Baru</p>
                            <p class="text-sm text-gray-500">15 anggota baru terdaftar dari PAC Sidoarjo</p>
                            <p class="text-xs text-gray-400 mt-1">5 jam yang lalu</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex-shrink-0">
                            <div class="bg-yellow-100 p-2 rounded-lg">
                                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Pengajuan PAC Baru</p>
                            <p class="text-sm text-gray-500">PAC Waru mengajukan pendirian baru</p>
                            <p class="text-xs text-gray-400 mt-1">1 hari yang lalu</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex-shrink-0">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <i class="fas fa-calendar-check text-purple-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Kegiatan Selesai</p>
                            <p class="text-sm text-gray-500">Pelatihan kader PAC Gedangan telah selesai</p>
                            <p class="text-xs text-gray-400 mt-1">2 hari yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Calendar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <button class="w-full flex items-center space-x-3 p-3 rounded-lg bg-green-50 hover:bg-green-100 transition-colors text-left group">
                        <div class="bg-green-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Tambah Anggota</span>
                    </button>
                    <button class="w-full flex items-center space-x-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors text-left group">
                        <div class="bg-blue-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-upload text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Upload Surat</span>
                    </button>
                    <button class="w-full flex items-center space-x-3 p-3 rounded-lg bg-purple-50 hover:bg-purple-100 transition-colors text-left group">
                        <div class="bg-purple-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-plus text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Buat Kegiatan</span>
                    </button>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                    Kegiatan Mendatang
                </h3>
                <div class="space-y-3">
                    <div class="p-3 border-l-4 border-green-500 bg-green-50 rounded">
                        <p class="text-sm font-medium text-gray-900">Rapat Koordinasi</p>
                        <p class="text-xs text-gray-600 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            Besok, 14:00 WIB
                        </p>
                    </div>
                    <div class="p-3 border-l-4 border-blue-500 bg-blue-50 rounded">
                        <p class="text-sm font-medium text-gray-900">Pelatihan Kader</p>
                        <p class="text-xs text-gray-600 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            5 Nov, 09:00 WIB
                        </p>
                    </div>
                    <div class="p-3 border-l-4 border-yellow-500 bg-yellow-50 rounded">
                        <p class="text-sm font-medium text-gray-900">Musyawarah Cabang</p>
                        <p class="text-xs text-gray-600 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            10 Nov, 08:00 WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAC Statistics -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="border-b border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-chart-bar text-green-600 mr-3"></i>
                Statistik PAC
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-3xl text-green-600 mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">20</p>
                    <p class="text-sm text-gray-600 mt-1">PAC Aktif</p>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg">
                    <i class="fas fa-hourglass-half text-3xl text-yellow-600 mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">3</p>
                    <p class="text-sm text-gray-600 mt-1">Dalam Proses</p>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-red-50 to-red-100 rounded-lg">
                    <i class="fas fa-pause-circle text-3xl text-red-600 mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">2</p>
                    <p class="text-sm text-gray-600 mt-1">Non-Aktif</p>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg">
                    <i class="fas fa-star text-3xl text-blue-600 mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">5</p>
                    <p class="text-sm text-gray-600 mt-1">PAC Berprestasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
