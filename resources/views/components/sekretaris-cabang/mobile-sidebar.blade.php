<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/mobile-sidebar.blade.php -->
<div x-show="sidebarOpen" @click.self="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 bg-white/20 backdrop-blur-xl lg:hidden">
    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 w-72 bg-white shadow-lg">
        <!-- Logo -->
        <div class="flex items-center justify-between p-4 h-[77px] border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <!-- 🔥 Ganti dengan Image Logo -->
                <img src="{{ asset('images/logo-laci-new.webp') }}" alt="Logo LACI" class="w-12 h-12 object-contain">
                <span class="text-xl font-bold text-gray-800">LACI Cabang</span>
            </div>
            <button @click="sidebarOpen = false" class="text-gray-600 hover:text-gray-800 p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Menu Mobile -->
        <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-77px)]">
            <!-- Dashboard -->
            <button type="button" @click="Livewire.navigate('{{ route('cabang.dashboard') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-home text-lg w-6"></i>
                <span class="text-base font-medium">Dashboard</span>
            </button>

            <!-- Arsip Surat Dropdown -->
            <div x-data="{ arsipOpen: {{ request()->routeIs('cabang.arsip-surat*') || request()->routeIs('cabang.arsip-berkas*') ? 'true' : 'false' }} }">
                <button type="button" @click="arsipOpen = !arsipOpen"
                    class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.arsip-surat*') || request()->routeIs('cabang.arsip-berkas*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-folder text-lg w-6"></i>
                    <span class="text-base font-medium flex-1">Arsip</span>
                    <i :class="arsipOpen ? 'fa-chevron-down' : 'fa-chevron-right'"
                        class="fas text-sm transition-transform"></i>
                </button>

                <!-- Sub Menu -->
                <div x-show="arsipOpen" x-transition.opacity class="ml-4 mt-1 space-y-1">
                    <!-- Arsip Surat -->
                    <button type="button"
                        @click="Livewire.navigate('{{ route('cabang.arsip-surat') }}'); sidebarOpen = false"
                        class="w-full text-left flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('cabang.arsip-surat') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt text-sm w-6"></i>
                        <span class="text-sm">Arsip Surat</span>
                    </button>

                    <!-- Arsip Berkas SP -->
                    <button type="button"
                        @click="Livewire.navigate('{{ route('cabang.arsip-berkas-sp') }}'); sidebarOpen = false"
                        class="w-full text-left flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('cabang.arsip-berkas-sp') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-file-archive text-sm w-6"></i>
                        <span class="text-sm">Berkas SP</span>
                    </button>

                    <!-- Arsip Berkas Cabang -->
                    <button type="button"
                        @click="Livewire.navigate('{{ route('cabang.arsip-berkas-cabang') }}'); sidebarOpen = false"
                        class="w-full text-left flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('cabang.arsip-berkas-cabang') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-folder-open text-sm w-6"></i>
                        <span class="text-sm">Berkas Cabang</span>
                    </button>
                </div>
            </div>

            <!-- Pengajuan PAC -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.pengajuan-pac') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.pengajuan-pac') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-file-import text-lg w-6"></i>
                <span class="text-base font-medium">Pengajuan PAC</span>
            </button>

            <!-- Data User PAC -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.data-user-pac') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.data-user-pac') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-user-cog text-lg w-6"></i>
                <span class="text-base font-medium">Data User PAC</span>
            </button>

            <!-- Periode -->
            <button type="button" @click="Livewire.navigate('{{ route('cabang.periode') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.periode') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-calendar-check text-lg w-6"></i>
                <span class="text-base font-medium">Periode</span>
            </button>

            <!-- Data Anggota -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.data-anggota') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.data-anggota') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-users text-lg w-6"></i>
                <span class="text-base font-medium">Data Anggota</span>
            </button>

            <!-- Kalender Kegiatan -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.kalender-kegiatan') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.kalender-kegiatan') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-calendar-alt text-lg w-6"></i>
                <span class="text-base font-medium">Kalender Kegiatan</span>
            </button>
            <button type="button"
    @click="Livewire.navigate('{{ route('cabang.pengumuman') }}'); sidebarOpen = false"
    class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.pengumuman') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-bullhorn text-lg w-6"></i>
    <span class="text-base font-medium">Pengumuman</span>
</button>
        </nav>
    </div>
</div>
