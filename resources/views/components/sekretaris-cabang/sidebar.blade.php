<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/sidebar.blade.php -->
<div :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 hidden lg:block">
    <!-- Logo -->
    <div class="flex items-center justify-center p-4 h-[77px] border-b border-gray-200">
        <div class="flex items-center space-x-2" :class="!sidebarOpen && 'justify-center w-full'">
            <!-- 🔥 Ganti dengan Image Logo -->
            <img src="{{ asset('images/logo-laci-3.webp') }}" alt="Logo LACI" class="w-20 h-20 object-contain">
            <span x-show="sidebarOpen" x-transition.opacity class="text-xl font-bold text-gray-800">
                LACI Cabang
            </span>
        </div>
    </div>

    <!-- Loading Bar saat navigasi -->
    <div wire:loading class="h-1 bg-blue-600 animate-pulse"></div>

    <!-- Menu -->
    <nav class="p-3 space-y-2 overflow-y-auto h-[calc(100vh-77px)]">
        <!-- Dashboard -->
        <button type="button"
            wire:click="$dispatch('navigate', { url: '{{ route('cabang.dashboard') }}' })"
            @click="Livewire.navigate('{{ route('cabang.dashboard') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.dashboard') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-home text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Dashboard</span>
            <!-- Loading Spinner -->
            <div wire:loading wire:target="$dispatch('navigate')" class="ml-auto">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </button>

        <!-- Arsip Surat Dropdown -->
        <div x-data="{ arsipOpen: {{ request()->routeIs('cabang.arsip-surat*') || request()->routeIs('cabang.arsip-berkas*') ? 'true' : 'false' }} }">
            <button type="button" @click="arsipOpen = !arsipOpen"
                class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.arsip-surat*') || request()->routeIs('cabang.arsip-berkas*') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
                :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
                <i class="fas fa-folder text-lg" :class="sidebarOpen && 'w-6'"></i>
                <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium flex-1">Arsip</span>
                <i x-show="sidebarOpen" :class="arsipOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-sm transition-transform"></i>
            </button>

            <!-- Sub Menu -->
            <div x-show="arsipOpen && sidebarOpen" x-transition.opacity class="ml-4 mt-1 space-y-1">
                <!-- Arsip Surat -->
                <button type="button" @click="Livewire.navigate('{{ route('cabang.arsip-surat') }}')"
                    class="w-full text-left flex items-center px-4 py-2 rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.arsip-surat') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-file-alt text-sm w-6"></i>
                    <span class="text-sm">Arsip Surat</span>
                </button>

                <!-- Arsip Berkas SP -->
                <button type="button" @click="Livewire.navigate('{{ route('cabang.arsip-berkas-sp') }}')"
                    class="w-full text-left flex items-center px-4 py-2 rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.arsip-berkas-sp') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-file-archive text-sm w-6"></i>
                    <span class="text-sm">Berkas SP</span>
                </button>

                <!-- Arsip Berkas Cabang -->
                <button type="button" @click="Livewire.navigate('{{ route('cabang.arsip-berkas-cabang') }}')"
                    class="w-full text-left flex items-center px-4 py-2 rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.arsip-berkas-cabang') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-folder-open text-sm w-6"></i>
                    <span class="text-sm">Berkas Cabang</span>
                </button>
            </div>
        </div>

        <!-- Pengajuan PAC -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.pengajuan-pac') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.pengajuan-pac') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-file-import text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Pengajuan PAC</span>
        </button>

        <!-- Data User PAC -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.data-user-pac') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.data-user-pac') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-user-cog text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Data User PAC</span>
        </button>

        <!-- Periode -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.periode') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.periode') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-calendar-check text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Periode</span>
        </button>

        <!-- Data Anggota -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.data-anggota') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.data-anggota') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-users text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Data Anggota</span>
        </button>

        <!-- Kalender Kegiatan -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.kalender-kegiatan') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('cabang.kalender-kegiatan') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-calendar-alt text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Kalender Kegiatan</span>
        </button>
    </nav>
</div>
