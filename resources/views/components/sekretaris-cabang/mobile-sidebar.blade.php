<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/mobile-sidebar.blade.php -->
<div
    x-show="sidebarOpen"
    @click.self="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 bg-black bg-opacity-50 lg:hidden"
>
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg"
    >
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
            <a href="{{ route('cabang.dashboard') }}"
               class="flex items-center space-x-2 px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('cabang.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-home text-base"></i>
                <span>Dashboard</span>
            </a>

            <!-- Arsip Surat -->
            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-folder text-base"></i>
                <span>Arsip Surat</span>
            </a>

            <!-- Pengajuan PAC -->
            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-file-import text-base"></i>
                <span>Pengajuan PAC</span>
            </a>

            <!-- Data User PAC -->
            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-user-cog text-base"></i>
                <span>Data User PAC</span>
            </a>

            <!-- Manajemen Anggota Dropdown -->
            <div x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
                >
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-users text-base"></i>
                        <span>Manajemen Anggota</span>
                    </div>
                    <i
                        :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"
                        class="fas text-xs"
                    ></i>
                </button>
                <div x-show="open" x-transition class="ml-6 mt-1 space-y-1">
                    <a
                        href="#"
                        class="flex items-center space-x-2 px-3 py-1.5 rounded-md text-gray-600 hover:bg-gray-100 transition text-sm"
                    >
                        <i class="fas fa-circle text-xs"></i>
                        <span>Data Anggota</span>
                    </a>
                    <a
                        href="#"
                        class="flex items-center space-x-2 px-3 py-1.5 rounded-md text-gray-600 hover:bg-gray-100 transition text-sm"
                    >
                        <i class="fas fa-circle text-xs"></i>
                        <span>Periode</span>
                    </a>
                </div>
            </div>

            <!-- Kalender Kegiatan -->
            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-calendar-alt text-base"></i>
                <span>Kalender Kegiatan</span>
            </a>
        </nav>
    </div>
</div>
