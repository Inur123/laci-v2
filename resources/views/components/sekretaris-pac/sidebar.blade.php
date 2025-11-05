<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-pac/sidebar.blade.php -->
<div :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 hidden lg:block">
    <!-- Logo -->
    <div class="flex items-center justify-center p-4 h-[77px] border-b border-gray-200">
        <div class="flex items-center space-x-2" :class="!sidebarOpen && 'justify-center w-full'">
            <i class="fas fa-users text-2xl text-green-600"></i>
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
        <button type="button"
            @click="Livewire.navigate('{{ route('pac.dashboard') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.dashboard') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-home text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Dashboard</span>
        </button>

        <!-- Arsip Surat -->
        <button type="button" @click="Livewire.navigate('{{ route('pac.arsip-surat') }}')"
            class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.arsip-surat') ? 'bg-green-600 text-white hover:bg-green-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-4 py-3 space-x-3' : 'justify-center p-3'">
            <i class="fas fa-archive text-lg" :class="sidebarOpen && 'w-6'"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-base font-medium">Arsip Surat</span>
        </button>

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

        <!-- Manajemen Anggota Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('pac.data-anggota') || request()->routeIs('pac.periode') ? 'true' : 'false' }} }">
            <button type="button" @click="sidebarOpen && (open = !open)"
                class="w-full text-left flex items-center rounded-lg transition cursor-pointer {{ request()->routeIs('pac.data-anggota') || request()->routeIs('pac.periode') ? 'bg-green-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}"
                :class="sidebarOpen ? 'px-4 py-3 justify-between' : 'justify-center p-3'">
                <div class="flex items-center" :class="sidebarOpen && 'space-x-3'">
                    <i class="fas fa-users text-lg" :class="sidebarOpen && 'w-6'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">Manajemen Anggota</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-sm"></i>
            </button>
            <div x-show="open && sidebarOpen" x-transition class="ml-0 mt-2 space-y-1">
                <button type="button" @click="Livewire.navigate('{{ route('pac.data-anggota') }}')"
                    class="w-full text-left flex items-center space-x-3 pl-14 pr-4 py-2.5 rounded-lg transition cursor-pointer {{ request()->routeIs('pac.data-anggota') ? 'bg-green-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-circle text-xs w-4"></i>
                    <span class="text-base">Data Anggota</span>
                </button>
                <button type="button" @click="Livewire.navigate('{{ route('pac.periode') }}')"
                    class="w-full text-left flex items-center space-x-3 pl-14 pr-4 py-2.5 rounded-lg transition cursor-pointer {{ request()->routeIs('pac.periode') ? 'bg-green-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-circle text-xs w-4"></i>
                    <span class="text-base">Periode</span>
                </button>
            </div>
        </div>
    </nav>
</div>
