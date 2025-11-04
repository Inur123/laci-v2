<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/sidebar.blade.php -->
<div
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 hidden lg:block"
>
    <!-- Logo -->
    <div class="flex items-center justify-center p-4 h-[77px] border-b border-gray-200">
        <div class="flex items-center space-x-2" :class="!sidebarOpen && 'justify-center w-full'">
            <i class="fas fa-building text-xl text-blue-600"></i>
            <span x-show="sidebarOpen" x-transition.opacity class="text-lg font-bold text-gray-800">
                LACI Cabang
            </span>
        </div>
    </div>

    <!-- Menu -->
    <nav class="p-3 space-y-1 overflow-y-auto h-[calc(100vh-77px)]">
        <!-- Dashboard -->
        <a href="{{ route('cabang.dashboard') }}"
           class="flex items-center rounded-md transition text-sm {{ request()->routeIs('cabang.dashboard') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-home text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Dashboard</span>
        </a>

        <!-- Arsip Surat -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-folder text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Arsip Surat</span>
        </a>

        <!-- Pengajuan PAC -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-file-import text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Pengajuan PAC</span>
        </a>

        <!-- Data User PAC -->
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-user-cog text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Data User PAC</span>
        </a>

        <!-- Manajemen Anggota Dropdown -->
        <div x-data="{ open: false }">
            <button
                @click="sidebarOpen && (open = !open)"
                class="w-full flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
                :class="sidebarOpen ? 'px-3 py-2 justify-between space-x-2' : 'justify-center p-2'"
            >
                <div class="flex items-center" :class="sidebarOpen && 'space-x-2'">
                    <i class="fas fa-users text-base"></i>
                    <span x-show="sidebarOpen" x-transition.opacity>Manajemen Anggota</span>
                </div>
                <i
                    x-show="sidebarOpen"
                    :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"
                    class="fas text-xs"
                ></i>
            </button>
            <div
                x-show="open && sidebarOpen"
                x-transition
                class="ml-6 mt-1 space-y-1"
            >
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
        <a href="#"
           class="flex items-center rounded-md text-gray-700 hover:bg-gray-100 transition text-sm"
           :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-calendar-alt text-base"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Kalender Kegiatan</span>
        </a>
    </nav>
</div>
