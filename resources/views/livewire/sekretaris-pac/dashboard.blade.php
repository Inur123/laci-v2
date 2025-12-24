<div class="space-y-6">
    <!-- Welcome Section -->
    <div
        class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-800 rounded-2xl shadow-xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute transform rotate-45 -right-10 -top-10 w-40 h-40 bg-white rounded-full"></div>
            <div class="absolute transform -rotate-45 -left-10 -bottom-10 w-60 h-60 bg-white rounded-full"></div>
        </div>

        <div class="relative flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-4xl font-bold mb-2">
                    Selamat Datang, {{ \Illuminate\Support\Str::title(auth()->user()->name) }}!
                </h1>
                <p class="text-green-100 text-base md:text-lg mb-1">Dashboard Sekretaris PAC IPNU IPPNU</p>
                <p class="text-green-200 text-sm">
                    <i class="fas fa-calendar-day mr-2"></i>
                    {{ now()->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            <div class="hidden lg:block">
                <div
                    class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 transform hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-mosque text-7xl text-white/90"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Peringatan Periode - Fixed Bottom, Closeable & Minimizable -->
    <div x-data="{
            storageKey: 'warningClosed_{{ auth()->id() }}_{{ session('login_time', time()) }}',
            showWarning: true,
            isMinimized: false,
            init() {
                // Cek localStorage saat component init
                const isClosed = localStorage.getItem(this.storageKey);
                this.showWarning = !isClosed;
            },
            closeWarning() {
                localStorage.setItem(this.storageKey, 'true');
                this.showWarning = false;
            }
         }"
         x-show="showWarning"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-full"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-full"
         class="fixed bottom-4 left-4 right-4 md:left-auto md:right-6 md:w-96 z-40 bg-gradient-to-r from-red-50 to-orange-50 border border-red-300 rounded-lg shadow-2xl overflow-hidden">

        <!-- Header - Always visible -->
        <div class="bg-red-600 p-3 flex items-center justify-between cursor-pointer" @click="isMinimized = !isMinimized">
            <div class="flex items-center gap-2 text-white">
                <div class="bg-white/20 rounded-full p-1.5">
                    <i class="fas fa-exclamation-circle text-sm"></i>
                </div>
                <span class="text-sm font-bold">⚠️ PERINGATAN PERIODE</span>
            </div>
            <div class="flex items-center gap-2">
                <button @click.stop="isMinimized = !isMinimized"
                        class="text-white hover:text-red-100 transition-colors p-1 cursor-pointer">
                    <i class="fas" :class="isMinimized ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <button @click.stop="closeWarning()"
                        class="text-white hover:text-red-100 transition-colors p-1 cursor-pointer">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Content - Collapsible -->
        <div x-show="!isMinimized"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 max-h-0"
             x-transition:enter-end="opacity-100 max-h-96"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 max-h-96"
             x-transition:leave-end="opacity-0 max-h-0"
             class="p-4 max-h-64 overflow-y-auto">
            <div class="text-xs text-red-700 space-y-2 leading-relaxed">
                <p class="font-semibold text-sm">
                    Penghapusan/perubahan periode mempengaruhi <strong>SEMUA DATA!</strong>
                </p>
                <div class="space-y-1">
                    <p class="font-medium">📋 Data yang terpengaruh:</p>
                    <p class="pl-3">• Arsip Surat Keluar & Masuk</p>
                    <p class="pl-3">• Data Anggota</p>
                    <p class="pl-3">• Pengajuan Surat</p>
                    <p class="pl-3">• Referensi Surat</p>
                </div>
                <div class="bg-red-100 border-l-2 border-red-600 p-2 rounded mt-3">
                    <p class="font-bold text-red-900">
                        ⚡ <strong>JANGAN ASAL GANTI PERIODE!</strong>
                    </p>
                    <p class="text-red-800 mt-1">Selalu cek periode aktif sebelum input data baru.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Main Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6" wire:poll.30s>
        <!-- Data Anggota -->
        <div
            class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
            <div class="p-6 relative">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-3xl text-white"></i>
                        </div>
                        @if($this->anggotaBulanIni > 0)
                        <span
                            class="text-xs font-bold text-green-100 bg-white/20 px-3 py-1.5 rounded-full backdrop-blur-sm">
                            <i class="fas fa-arrow-up"></i> +{{ $this->anggotaBulanIni }}
                        </span>
                        @endif
                    </div>
                    <h3 class="text-white/80 text-sm font-medium mb-1">Total Anggota</h3>
                    <p class="text-4xl font-bold text-white mb-2">{{ number_format($this->totalAnggota) }}</p>
                    <div class="flex items-center gap-3 text-xs text-green-100">
                        <span><i class="fas fa-male mr-1"></i>{{ $this->anggotaLakiLaki }}</span>
                        <span><i class="fas fa-female mr-1"></i>{{ $this->anggotaPerempuan }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-green-900/30 px-6 py-3 backdrop-blur-sm">
                <a href="{{ route('pac.data-anggota') }}"
                    class="text-sm text-white hover:text-green-100 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Periode Kepengurusan -->
        <div
            class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
            <div class="p-6 relative">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-clock text-3xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/80 text-sm font-medium mb-1">Total Periode</h3>
                    <p class="text-4xl font-bold text-white mb-2">{{ $this->totalPeriode }}</p>
                    <p class="text-xs text-blue-100">Periode kepengurusan</p>
                </div>
            </div>
            <div class="bg-blue-900/30 px-6 py-3 backdrop-blur-sm">
                <a href="{{ route('pac.periode') }}"
                    class="text-sm text-white hover:text-blue-100 font-medium flex items-center justify-between group">
                    <span>Kelola Periode</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Arsip Surat -->
        <div
            class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
            <div class="p-6 relative">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-folder text-3xl text-white"></i>
                        </div>
                        @if($this->suratBulanIni > 0)
                        <span
                            class="text-xs font-bold text-purple-100 bg-white/20 px-3 py-1.5 rounded-full backdrop-blur-sm">
                            <i class="fas fa-plus"></i> +{{ $this->suratBulanIni }}
                        </span>
                        @endif
                    </div>
                    <h3 class="text-white/80 text-sm font-medium mb-1">Arsip Surat</h3>
                    <p class="text-4xl font-bold text-white mb-2">{{ number_format($this->totalSurat) }}</p>
                    <div class="flex items-center gap-3 text-xs text-purple-100">
                        <span><i class="fas fa-inbox mr-1"></i>{{ $this->suratMasuk }}</span>
                        <span><i class="fas fa-paper-plane mr-1"></i>{{ $this->suratKeluar }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-purple-900/30 px-6 py-3 backdrop-blur-sm">
                <a href="{{ route('pac.arsip-surat') }}"
                    class="text-sm text-white hover:text-purple-100 font-medium flex items-center justify-between group">
                    <span>Lihat Arsip</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Pengajuan Surat -->
        <div
            class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
            <div class="p-6 relative">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-signature text-3xl text-white"></i>
                        </div>
                        @if($this->pengajuanPending > 0)
                        <span
                            class="text-xs font-bold text-yellow-100 bg-red-500/30 px-3 py-1.5 rounded-full backdrop-blur-sm animate-pulse">
                            <i class="fas fa-exclamation-triangle"></i> {{ $this->pengajuanPending }} Pending
                        </span>
                        @endif
                    </div>
                    <h3 class="text-white/80 text-sm font-medium mb-1">Pengajuan Surat</h3>
                    <p class="text-4xl font-bold text-white mb-2">{{ $this->pengajuanPending }}</p>
                    <p class="text-xs text-yellow-100">Menunggu persetujuan</p>
                </div>
            </div>
            <div class="bg-yellow-900/30 px-6 py-3 backdrop-blur-sm">
                <a href="{{ route('pac.pengajuan-surat') }}"
                    class="text-sm text-white hover:text-yellow-100 font-medium flex items-center justify-between group">
                    <span>Lihat Pengajuan</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- AKTIVITAS TERBARU + SIDEBAR KANAN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

        <!-- Aktivitas Terbaru (Kiri - 2/3) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col" wire:poll.10s
            style="height: calc(100vh - 450px); min-height: 600px;">
            <div
                class="border-b border-gray-200 p-6 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-history text-green-600"></i>
                    </div>
                    Aktivitas Terbaru
                </h3>
                <button wire:click="loadMoreActivities"
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center cursor-pointer">
                    <i class="fas fa-plus mr-1"></i> Muat Lebih
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                @forelse($this->aktivitasTerbaru as $activity)
                <div
                    class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-all duration-200 group">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg
                                        @if($activity['color'] == 'green') bg-green-500
                                        @elseif($activity['color'] == 'blue') bg-blue-500
                                        @elseif($activity['color'] == 'teal') bg-teal-500
                                        @elseif($activity['color'] == 'indigo') bg-indigo-500
                                        @elseif($activity['color'] == 'purple') bg-purple-500
                                        @elseif($activity['color'] == 'orange') bg-orange-500
                                        @elseif($activity['color'] == 'yellow') bg-yellow-500
                                        @elseif($activity['color'] == 'red') bg-red-500
                                        @endif
                                        shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas {{ $activity['icon'] }} text-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-semibold text-gray-800 truncate">{{ $activity['title'] }}</h4>
                            <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                {{ $activity['time']->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">{{ $activity['description'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-user mr-1"></i> {{ $activity['user'] }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                    <p class="text-lg font-medium">Belum ada aktivitas</p>
                    <p class="text-sm">Mulai tambah anggota, surat, atau pengajuan</p>
                </div>
                @endforelse
            </div>

            <!-- Loading More -->
            @if($this->aktivitasTerbaru->count() >= $this->activityLimit)
            <div class="p-4 border-t border-gray-200 text-center">
                <button wire:click="loadMoreActivities"
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium cursor-pointer">
                    Muat lebih banyak...
                </button>
            </div>
            @endif
        </div>

        <!-- Sidebar Kanan (1/3) -->
        <div class="flex flex-col space-y-6" style="height: calc(100vh - 450px); min-height: 600px; overflow-y: auto;">

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-yellow-100 p-2 rounded-lg mr-2">
                        <i class="fas fa-bolt text-yellow-600"></i>
                    </div>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <a href="{{ route('pac.data-anggota') }}"
                        class="flex items-center space-x-3 p-3 rounded-xl bg-green-50 hover:bg-green-100 transition-all duration-200 text-left group">
                        <div class="bg-green-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-plus text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Tambah Anggota</span>
                    </a>

                    <a href="{{ route('pac.arsip-surat') }}"
                        class="flex items-center space-x-3 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-all duration-200 text-left group">
                        <div class="bg-blue-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-upload text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Upload Surat</span>
                    </a>

                    <a href="{{ route('pac.pengajuan-surat') }}"
                        class="flex items-center space-x-3 p-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 transition-all duration-200 text-left group">
                        <div class="bg-indigo-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-signature text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Ajukan Surat</span>
                    </a>

                    <a href="{{ route('pac.periode') }}"
                        class="flex items-center space-x-3 p-3 rounded-xl bg-purple-50 hover:bg-purple-100 transition-all duration-200 text-left group">
                        <div class="bg-purple-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Kelola Periode</span>
                    </a>
                </div>
            </div>

            <!-- Ringkasan Statistik (sesuai Quick Actions) -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-indigo-100 p-2 rounded-lg mr-2">
                        <i class="fas fa-chart-line text-indigo-600"></i>
                    </div>
                    Ringkasan Statistik
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <!-- Total Anggota -->
                    <div
                        class="flex items-center space-x-3 p-3 rounded-xl bg-green-50 hover:bg-green-100 transition-all duration-200 group">
                        <div class="bg-green-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ number_format($this->totalAnggota) }}
                            Anggota</span>
                    </div>

                    <!-- Total Periode -->
                    <div
                        class="flex items-center space-x-3 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-all duration-200 group">
                        <div class="bg-blue-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $this->totalPeriode }} Periode</span>
                    </div>

                    <!-- Arsip Surat -->
                    <div
                        class="flex items-center space-x-3 p-3 rounded-xl bg-purple-50 hover:bg-purple-100 transition-all duration-200 group">
                        <div class="bg-purple-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-folder text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ number_format($this->totalSurat) }} Arsip
                            Surat</span>
                    </div>

                    <!-- Pengajuan Pending -->
                    <div
                        class="flex items-center space-x-3 p-3 rounded-xl bg-yellow-50 hover:bg-yellow-100 transition-all duration-200 group relative">
                        <div class="bg-yellow-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-signature text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $this->pengajuanPending }} Pending</span>
                        @if($this->pengajuanPending > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-pulse">
                            {{ $this->pengajuanPending }}
                        </span>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
