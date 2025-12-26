<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-pac/sidebar.blade.php -->
<div :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 hidden lg:block">
    <!-- Logo -->
    <div class="flex p-4 h-[77px] border-b border-gray-200">
        <div class="flex items-center space-x-2" :class="!sidebarOpen && 'justify-center w-full'">

            <!-- ✅ Ganti Icon dengan Logo -->
            <img src="{{ asset('images/logo-laci-new.webp') }}" alt="Logo LACI" class="w-12 h-12 object-contain">

            <span x-show="sidebarOpen" x-transition.opacity class="text-xl font-bold text-gray-800">
                LACI PAC
            </span>
        </div>
    </div>


    <!-- Loading Bar saat navigasi -->
    <div wire:loading class="h-1 bg-green-600 animate-pulse"></div>

    <!-- Menu -->
    <nav class="p-3 space-y-2 overflow-y-auto h-[calc(100vh-77px)]">
        <!-- Dashboard -->
        <button type="button" @click="Livewire.navigate('{{ route('pac.dashboard') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.dashboard') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-home text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Dashboard</span>
        </button>

        <!-- Arsip Dropdown -->
        <div x-data="{ arsipOpen: {{ request()->routeIs('pac.arsip-surat*') || request()->routeIs('pac.arsip-berkas*') ? 'true' : 'false' }} }">
            <button type="button" @click="arsipOpen = !arsipOpen"
                class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.arsip-surat*') || request()->routeIs('pac.arsip-berkas*') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
                :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
                <i class="fas fa-folder text-lg" :class="sidebarOpen && 'w-6'"></i>
                <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium flex-1">Arsip</span>
                <i x-show="sidebarOpen" :class="arsipOpen ? 'fa-chevron-down' : 'fa-chevron-right'"
                    class="fas text-sm transition-transform"></i>
            </button>

            <!-- Sub Menu -->
            <div x-show="arsipOpen && sidebarOpen" x-transition.opacity class="ml-4 mt-1 space-y-1">
                <!-- Arsip Surat -->
                <button type="button" @click="Livewire.navigate('{{ route('pac.arsip-surat') }}')"
                    class="w-full text-left flex items-center px-4 py-2 rounded-lg transition cursor-pointer {{ request()->routeIs('pac.arsip-surat') ? 'bg-green-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-file-alt text-sm w-6"></i>
                    <span class="text-sm">Arsip Surat</span>
                </button>

                <!-- Arsip Berkas PAC -->
                <button type="button" @click="Livewire.navigate('{{ route('pac.arsip-berkas-pac') }}')"
                    class="w-full text-left flex items-center px-4 py-2 rounded-lg transition cursor-pointer {{ request()->routeIs('pac.arsip-berkas-pac') ? 'bg-green-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-file-archive text-sm w-6"></i>
                    <span class="text-sm">Berkas PAC</span>
                </button>
            </div>
        </div>

        <!-- Pengajuan Surat -->
        <button type="button" @click="Livewire.navigate('{{ route('pac.pengajuan-surat') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.pengajuan-surat') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-paper-plane text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Pengajuan Surat</span>
        </button>

        <!-- Referensi Surat -->
        <button type="button" @click="Livewire.navigate('{{ route('pac.referensi-surat') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.referensi-surat') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-book text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Referensi Surat</span>
        </button>

        <!-- Periode -->
        <button type="button" @click="Livewire.navigate('{{ route('pac.periode') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.periode') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-calendar-check text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Periode</span>
        </button>

        <!-- Data Anggota -->
        <button type="button" @click="Livewire.navigate('{{ route('pac.data-anggota') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.data-anggota') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-users text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Data Anggota</span>
        </button>
        <!-- Pengumuman -->
        <button type="button" @click="Livewire.navigate('{{ route('pac.pengumuman') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.pengumuman') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-bullhorn text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Pengumuman</span>
        </button>

    </nav>
</div>
