<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/sidebar.blade.php -->
<div :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed inset-y-0 left-0 z-50 bg-white shadow-lg transition-all duration-300 hidden lg:block">
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
        <button type="button" @click="Livewire.navigate('{{ route('cabang.dashboard') }}')"
            class="w-full text-left flex items-center rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.dashboard') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-home text-base" :class="sidebarOpen && 'w-5'"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Dashboard</span>
        </button>

        <!-- Arsip Surat -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.arsip-surat') }}')"
            class="w-full text-left flex items-center rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.arsip-surat') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-folder text-base" :class="sidebarOpen && 'w-5'"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Arsip Surat</span>
        </button>

        <!-- Pengajuan PAC -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.pengajuan-pac') }}')"
            class="w-full text-left flex items-center rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.pengajuan-pac') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-file-import text-base" :class="sidebarOpen && 'w-5'"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Pengajuan PAC</span>
        </button>

        <!-- Data User PAC -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.data-user-pac') }}')"
            class="w-full text-left flex items-center rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.data-user-pac') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-user-cog text-base" :class="sidebarOpen && 'w-5'"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Data User PAC</span>
        </button>

        <!-- Manajemen Anggota Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('cabang.data-anggota') || request()->routeIs('cabang.periode') ? 'true' : 'false' }} }">
            <button type="button" @click="sidebarOpen && (open = !open)"
                class="w-full text-left flex items-center rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.data-anggota') || request()->routeIs('cabang.periode') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}"
                :class="sidebarOpen ? 'px-3 py-2 justify-between' : 'justify-center p-2'">
                <div class="flex items-center" :class="sidebarOpen && 'space-x-2'">
                    <i class="fas fa-users text-base" :class="sidebarOpen && 'w-5'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity>Manajemen Anggota</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs"></i>
            </button>
            <div x-show="open && sidebarOpen" x-transition class="ml-0 mt-1 space-y-1">
                <button type="button" @click="Livewire.navigate('{{ route('cabang.data-anggota') }}')"
                    class="w-full text-left flex items-center space-x-2 pl-11 pr-3 py-1.5 rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.data-anggota') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-circle text-xs w-3"></i>
                    <span>Data Anggota</span>
                </button>
                <button type="button" @click="Livewire.navigate('{{ route('cabang.periode') }}')"
                    class="w-full text-left flex items-center space-x-2 pl-11 pr-3 py-1.5 rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.periode') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fas fa-circle text-xs w-3"></i>
                    <span>Periode</span>
                </button>
            </div>
        </div>

        <!-- Kalender Kegiatan -->
        <button type="button" @click="Livewire.navigate('{{ route('cabang.kalender-kegiatan') }}')"
            class="w-full text-left flex items-center rounded-md transition text-sm cursor-pointer {{ request()->routeIs('cabang.kalender-kegiatan') ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700 hover:bg-gray-100' }}"
            :class="sidebarOpen ? 'px-3 py-2 space-x-2' : 'justify-center p-2'">
            <i class="fas fa-calendar-alt text-base" :class="sidebarOpen && 'w-5'"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Kalender Kegiatan</span>
        </button>
    </nav>
</div>
