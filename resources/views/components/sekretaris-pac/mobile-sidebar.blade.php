<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-pac/mobile-sidebar.blade.php -->
<div
    x-show="sidebarOpen"
    @click.self="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 bg-white/20 backdrop-blur-lg lg:hidden"
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
                <i class="fas fa-tachometer-alt text-xl text-blue-600"></i>
                <span class="text-lg font-bold text-gray-800">LACI PAC</span>
            </div>
            <button @click="sidebarOpen = false" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Menu Mobile -->
        <nav class="p-3 space-y-1 overflow-y-auto h-[calc(100vh-73px)]">
            <a href="{{ route('pac.dashboard') }}"
               class="flex items-center space-x-2 px-3 py-2 rounded-md transition text-sm {{ request()->routeIs('pac.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-home text-base"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-2 px-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen Data</span>
            </div>

            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-users text-base"></i>
                <span>Data Anggota</span>
            </a>

            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-calendar text-base"></i>
                <span>Kegiatan</span>
            </a>

            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-file-alt text-base"></i>
                <span>Laporan</span>
            </a>

            <div class="pt-4 pb-2 px-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</span>
            </div>

            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-chart-line text-base"></i>
                <span>Statistik</span>
            </a>

            <div class="pt-4 pb-2 px-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">System</span>
            </div>

            <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition text-sm">
                <i class="fas fa-cog text-base"></i>
                <span>Pengaturan</span>
            </a>
        </nav>
    </div>
</div>
