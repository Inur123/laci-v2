<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/mobile-sidebar.blade.php -->
<div x-show="sidebarOpen" @click.self="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 bg-white/20 backdrop-blur-xl lg:hidden">
    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
        <!-- Logo -->
        <div class="flex items-center justify-between p-4 h-[69px] border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <i class="fas fa-building text-xl text-blue-600"></i>
                <span class="text-lg font-bold text-gray-800">LACI Cabang</span>
            </div>
            <button @click="sidebarOpen = false" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Menu Mobile -->
        <nav class="p-3 space-y-1 overflow-y-auto h-[calc(100vh-69px)]">
            <!-- Dashboard -->
            <button type="button" @click="Livewire.navigate('{{ route('cabang.dashboard') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-2 px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('cabang.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-home text-base w-5"></i>
                <span>Dashboard</span>
            </button>

            <!-- Arsip Surat -->
            <button type="button" @click="Livewire.navigate('{{ route('cabang.arsip-surat') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-2 px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('cabang.arsip-surat') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-folder text-base w-5"></i>
                <span>Arsip Surat</span>
            </button>

            <!-- Pengajuan PAC -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.pengajuan-pac') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-2 px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('cabang.pengajuan-pac') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-file-import text-base w-5"></i>
                <span>Pengajuan PAC</span>
            </button>

            <!-- Data User PAC -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.data-user-pac') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-2 px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('cabang.data-user-pac') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-user-cog text-base w-5"></i>
                <span>Data User PAC</span>
            </button>

            <!-- Manajemen Anggota Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('cabang.data-anggota') || request()->routeIs('cabang.periode') ? 'true' : 'false' }} }">
                <button type="button" @click="open = !open"
                    class="w-full text-left flex items-center justify-between px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('cabang.data-anggota') || request()->routeIs('cabang.periode') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-users text-base w-5"></i>
                        <span>Manajemen Anggota</span>
                    </div>
                    <i :class="open ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs"></i>
                </button>
                <div x-show="open" x-transition class="ml-0 mt-1 space-y-1">
                    <button type="button"
                        @click="Livewire.navigate('{{ route('cabang.data-anggota') }}'); sidebarOpen = false"
                        class="w-full text-left flex items-center space-x-2 pl-11 pr-3 py-1.5 rounded-md transition text-sm {{ request()->routeIs('cabang.data-anggota') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-circle text-xs w-3"></i>
                        <span>Data Anggota</span>
                    </button>
                    <button type="button"
                        @click="Livewire.navigate('{{ route('cabang.periode') }}'); sidebarOpen = false"
                        class="w-full text-left flex items-center space-x-2 pl-11 pr-3 py-1.5 rounded-md transition text-sm {{ request()->routeIs('cabang.periode') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-circle text-xs w-3"></i>
                        <span>Periode</span>
                    </button>
                </div>
            </div>

            <!-- Kalender Kegiatan -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.kalender-kegiatan') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-2 px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('cabang.kalender-kegiatan') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-calendar-alt text-base w-5"></i>
                <span>Kalender Kegiatan</span>
            </button>
        </nav>
    </div>
</div>
