<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-pac/sidebar.blade.php -->
<div
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 hidden lg:block"
>
    <!-- Logo -->
    <div class="flex items-center justify-center p-4 h-[77px] border-b border-gray-200">
        <div class="flex items-center space-x-2" :class="!sidebarOpen && 'justify-center w-full'">
            <i class="fas fa-tachometer-alt text-xl text-blue-600"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-lg font-bold text-gray-800">
                LACI PAC
            </span>
        </div>
    </div>

    <!-- Menu -->
    <nav class="p-3 space-y-1 overflow-y-auto h-[calc(100vh-73px)]">
        <!-- Dashboard -->
        <a href="{{ route('pac.dashboard') }}"
           class="flex items-center rounded-md transition text-sm {{ request()->routeIs('pac.dashboard') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-home text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Dashboard</span>
        </a>

        <!-- Header: Manajemen Data -->
        <div x-show="sidebarOpen" x-transition.opacity class="pt-4 pb-2 px-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen Data</span>
        </div>

        <!-- Data Anggota -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-users text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Data Anggota</span>
        </a>

        <!-- Kegiatan -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-calendar text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Kegiatan</span>
        </a>

        <!-- Laporan -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-file-alt text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Laporan</span>
        </a>

        <!-- Header: Reports -->
        <div x-show="sidebarOpen" x-transition.opacity class="pt-4 pb-2 px-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</span>
        </div>

        <!-- Statistik -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-chart-line text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Statistik</span>
        </a>

        <!-- Header: System -->
        <div x-show="sidebarOpen" x-transition.opacity class="pt-4 pb-2 px-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">System</span>
        </div>

        <!-- Pengaturan -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-cog text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Pengaturan</span>
        </a>
    </nav>
</div>
