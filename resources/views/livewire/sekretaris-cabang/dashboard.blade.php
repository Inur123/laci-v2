<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/dashboard.blade.php -->
<div class="space-y-6">
    <!-- Welcome Section -->
    <div
        class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-800 rounded-2xl shadow-xl p-6 md:p-8 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute transform rotate-45 -right-10 -top-10 w-40 h-40 bg-white rounded-full"></div>
            <div class="absolute transform -rotate-45 -left-10 -bottom-10 w-60 h-60 bg-white rounded-full"></div>
        </div>

        <div class="relative flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-4xl font-bold mb-2">

                    Selamat Datang, {{ \Illuminate\Support\Str::title(auth()->user()->name) }}! 👋
                </h1>
                <p class="text-green-100 text-base md:text-lg mb-1">Dashboard Sekretaris Cabang IPNU IPPNU Magetan</p>
                <p class="text-green-200 text-sm">
                    <i class="fas fa-calendar-day mr-2"></i>
                    {{ now()->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            <div class="hidden lg:block">
                <div
                    class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 transform hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-building text-7xl text-white/90"></i>
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
                    <p class="pl-3">• Berkas PAC & Berkas Cabang</p>
                    <p class="pl-3">• Data Anggota</p>
                    <p class="pl-3">• Pengajuan Surat PAC</p>
                    <p class="pl-3">• Kalender Kegiatan</p>
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

    <!-- Main Statistics Cards - Auto refresh every 30s -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6" wire:poll.30s>
        <!-- Total PAC -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg overflow-hidden group">
            <div class="p-6 relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-building text-3xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/80 text-sm font-medium mb-1">Statistik PAC</h3>
                    <p class="text-4xl font-bold text-white mb-2">{{ $this->totalPacActive }}</p>
                    <p class="text-xs text-blue-100 mb-4">PAC Aktif & Terverifikasi</p>
                    <div class="space-y-1 text-xs">
                        <div class="flex items-center justify-between text-white/80">
                            <span><i class="fas fa-check-circle text-green-300 mr-1"></i>Sudah Verifikasi</span>
                            <span class="font-bold">{{ $this->totalPacVerified }}</span>
                        </div>
                        <div class="flex items-center justify-between text-white/80">
                            <span><i class="fas fa-exclamation-circle text-yellow-300 mr-1"></i>Belum Verifikasi</span>
                            <span class="font-bold">{{ $this->totalPacUnverified }}</span>
                        </div>
                        <div class="flex items-center justify-between text-white/80">
                            <span><i class="fas fa-user-slash text-gray-300 mr-1"></i>Belum Aktif</span>
                            <span class="font-bold">{{ $this->totalPacInactive }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-blue-900/30 px-6 py-3 backdrop-blur-sm">
                <a href="{{ route('cabang.data-user-pac') }}"
                    class="text-sm text-white hover:text-blue-100 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Anggota -->
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
                <a href="{{ route('cabang.data-anggota') }}"
                    class="text-sm text-white hover:text-green-100 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>


        <!-- Pengajuan PAC -->
        <div
            class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
            <div class="p-6 relative">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-hourglass-half text-3xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/80 text-sm font-medium mb-1">Pengajuan PAC</h3>
                    <p class="text-4xl font-bold text-white mb-2">{{ $this->totalPengajuanPac }}</p>
                    <p class="text-xs text-blue-100 mb-4">Seluruah Pengajuan</p>
                    <div class="space-y-1 text-xs">
                        <div class="flex items-center justify-between text-white/80">
                            <span><i class="fas fa-check-circle text-green-300 mr-1"></i>Diterima</span>
                            <span class="font-bold">{{ $this->pengajuanDiterima }}</span>
                        </div>
                        <div class="flex items-center justify-between text-white/80">
                            <span><i class="fas fa-times-circle text-red-300 mr-1"></i>Ditolak</span>
                            <span class="font-bold">{{ $this->pengajuanDitolak }}</span>
                        </div>
                        <div class="flex items-center justify-between text-white/80">
                            <span><i class="fas fa-hourglass-half text-yellow-300 mr-1"></i>Pending</span>
                            <span class="font-bold">{{ $this->pengajuanPending }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-900/30 px-6 py-3 backdrop-blur-sm">
                <a href="{{ route('cabang.pengajuan-pac') }}"
                    class="text-sm text-white hover:text-yellow-100 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
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
                <a href="{{ route('cabang.arsip-surat') }}"
                    class="text-sm text-white hover:text-purple-100 font-medium flex items-center justify-between group">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>



    <!-- Charts & Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -  FULL HEIGHT -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col" wire:poll.10s
            style="height: calc(100vh - 450px); min-height: 600px;">

            <!-- Header (Fixed) -->
            <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-gray-50 to-white flex-shrink-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <div class="bg-green-100 p-2 rounded-lg mr-3">
                            <i class="fas fa-history text-green-600"></i>
                        </div>
                        Aktivitas Terbaru
                    </h3>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs px-3 py-1.5 bg-green-100 text-green-700 rounded-full font-medium animate-pulse">
                            <i class="fas fa-circle text-xs mr-1"></i>Live
                        </span>
                        <span class="text-xs px-3 py-1.5 bg-gray-100 text-gray-600 rounded-full font-medium">
                            {{ $this->aktivitasTerbaru->count() }} aktivitas
                        </span>
                        <div wire:loading wire:target="$refresh,loadMoreActivities" class="text-xs">
                            <i class="fas fa-sync fa-spin text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!--  Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto custom-scrollbar" id="activity-container">
                <div class="p-6 space-y-3">
                    @forelse($this->aktivitasTerbaru as $activity)
                    <div
                        class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-all duration-200 border border-gray-100 animate-fade-in">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $activity['color'] }}-100 p-3 rounded-xl">
                                <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="text-sm text-gray-600 mt-0.5">{{ $activity['description'] }}</p>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-user mr-1"></i>{{ $activity['user'] }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            <i class="fas fa-clock mr-1"></i>{{ $activity['time']->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada aktivitas</p>
                    </div>
                    @endforelse

                    <!--  Load More Button -->
                    @if($this->aktivitasTerbaru->count() >= $activityLimit)
                    <div class="mt-6 pb-6 text-center">
                        <button wire:click="loadMoreActivities"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium">
                            <i class="fas fa-chevron-down"></i>
                            <span>Muat Lebih Banyak</span>
                            <div wire:loading wire:target="loadMoreActivities">
                                <i class="fas fa-spinner fa-spin ml-2"></i>
                            </div>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Sidebar -  FULL HEIGHT SAMA DENGAN AKTIVITAS -->
        <div class="flex flex-col space-y-6" style="height: calc(100vh - 450px); min-height: 600px; overflow-y: auto;"
            class="custom-scrollbar">
            <!-- Kegiatan Mendatang -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" wire:poll.30s>
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Kegiatan Mendatang
                            </h3>
                            <p class="text-xs text-blue-100 mt-1">{{ $this->kegiatanBerlangsung }} kegiatan berlangsung
                            </p>
                        </div>
                        <div wire:loading wire:target="$refresh">
                            <i class="fas fa-sync fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @forelse($this->kegiatanMendatang as $kegiatan)
                        <div class="p-4 border-l-4 rounded-r-xl hover:shadow-md transition-all duration-200 animate-fade-in"
                            style="border-color: {{ $kegiatan->warna }}; background-color: {{ $kegiatan->warna }}15;">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $kegiatan->judul }}</h4>
                                <span class="px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap ml-2"
                                    style="background-color: {{ $kegiatan->warna }}30; color: {{ $kegiatan->warna }};">
                                    @if($kegiatan->tanggal_mulai->isToday())
                                    Hari Ini
                                    @elseif($kegiatan->tanggal_mulai->isTomorrow())
                                    Besok
                                    @else
                                    {{ $kegiatan->tanggal_mulai->diffForHumans() }}
                                    @endif
                                </span>
                            </div>
                            <div class="space-y-1.5 text-xs text-gray-600">
                                <p>
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    {{ $kegiatan->tanggal_mulai->format('d M Y, H:i') }}
                                </p>
                                @if($kegiatan->lokasi)
                                <p>
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    {{ Str::limit($kegiatan->lokasi, 30) }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-300 mb-2"></i>
                            <p class="text-sm text-gray-500">Tidak ada kegiatan mendatang</p>
                        </div>
                        @endforelse
                    </div>

                    @if($this->kegiatanMendatang->count() > 0)
                    <a href="{{ route('cabang.kalender-kegiatan') }}"
                        class="block mt-4 text-center text-sm text-blue-600 hover:text-blue-700 font-medium py-2 px-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        Lihat Semua Kegiatan <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-yellow-100 p-2 rounded-lg mr-2">
                        <i class="fas fa-bolt text-yellow-600"></i>
                    </div>
                    Quick Actions
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('cabang.data-anggota') }}"
                        class="w-full flex items-center space-x-3 p-3 rounded-xl bg-green-50 hover:bg-green-100 transition-all duration-200 text-left group">
                        <div class="bg-green-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-plus text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Tambah Anggota</span>
                    </a>
                    <a href="{{ route('cabang.arsip-surat') }}"
                        class="w-full flex items-center space-x-3 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-all duration-200 text-left group">
                        <div class="bg-blue-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-upload text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Upload Surat</span>
                    </a>
                    <a href="{{ route('cabang.kalender-kegiatan') }}"
                        class="w-full flex items-center space-x-3 p-3 rounded-xl bg-purple-50 hover:bg-purple-100 transition-all duration-200 text-left group">
                        <div class="bg-purple-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-plus text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Buat Kegiatan</span>
                    </a>
                    <a href="{{ route('cabang.data-user-pac') }}"
                        class="w-full flex items-center space-x-3 p-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 transition-all duration-200 text-left group">
                        <div class="bg-indigo-600 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-building text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Kelola PAC</span>
                    </a>
                </div>
            </div>

            <!-- Distribusi Anggota per Periode -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-purple-100 p-2 rounded-lg mr-2">
                        <i class="fas fa-chart-pie text-purple-600"></i>
                    </div>
                    Top Periode
                </h3>
                <div class="space-y-3">
                    @forelse($this->distribusiPeriode as $index => $periode)
                    @php
                    $colors = ['blue', 'green', 'yellow', 'purple', 'pink'];
                    $color = $colors[$index % 5];
                    @endphp
                    <div
                        class="flex items-center justify-between p-3 rounded-xl bg-{{ $color }}-50 hover:bg-{{ $color }}-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="bg-{{ $color }}-600 text-white w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $periode->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $periode->anggotas_count }} anggota</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-{{ $color }}-600">
                                {{ number_format(($periode->anggotas_count / max($this->totalAnggota, 1)) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 text-sm py-4">Belum ada data periode</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Stats -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                    <i class="fas fa-chart-line text-indigo-600"></i>
                </div>
                Ringkasan Statistik
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div
                    class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl hover:shadow-lg transition-shadow">
                    <i class="fas fa-check-circle text-4xl text-green-600 mb-3"></i>
                    <p class="text-3xl font-bold text-gray-800">{{ $this->totalPacActive }}</p>
                    <p class="text-sm text-gray-600 mt-2 font-medium">PAC Aktif</p>
                </div>
                <div
                    class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl hover:shadow-lg transition-shadow">
                    <i class="fas fa-users text-4xl text-blue-600 mb-3"></i>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($this->totalAnggota) }}</p>
                    <p class="text-sm text-gray-600 mt-2 font-medium">Total Anggota</p>
                </div>
                <div
                    class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl hover:shadow-lg transition-shadow">
                    <i class="fas fa-envelope text-4xl text-purple-600 mb-3"></i>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($this->totalSurat) }}</p>
                    <p class="text-sm text-gray-600 mt-2 font-medium">Arsip Surat</p>
                </div>
                <div
                    class="text-center p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl hover:shadow-lg transition-shadow">
                    <i class="fas fa-calendar-alt text-4xl text-yellow-600 mb-3"></i>
                    <p class="text-3xl font-bold text-gray-800">{{ $this->totalKegiatan }}</p>
                    <p class="text-sm text-gray-600 mt-2 font-medium">Total Kegiatan</p>
                </div>
            </div>
        </div>
    </div>
</div>
