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
                <img src="{{ asset('images/logo-laci-3.webp') }}" alt="Logo LACI" class="w-20 h-20 object-contain">
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

            <!-- Arsip Surat -->
            <button type="button" @click="Livewire.navigate('{{ route('cabang.arsip-surat') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.arsip-surat') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-folder text-lg w-6"></i>
                <span class="text-base font-medium">Arsip Surat</span>
            </button>

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

            <!-- Manajemen Anggota Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('cabang.data-anggota') || request()->routeIs('cabang.periode') ? 'true' : 'false' }} }">
                <button type="button" @click="open = !open"
                    class="w-full text-left flex items-center justify-between px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.data-anggota') || request()->routeIs('cabang.periode') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-users text-lg w-6"></i>
                        <span class="text-base font-medium">Manajemen Anggota</span>
                    </div>
                    <i :class="open ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-sm"></i>
                </button>
                <div x-show="open" x-transition class="ml-0 mt-2 space-y-1">
                    <button type="button"
                        @click="Livewire.navigate('{{ route('cabang.data-anggota') }}'); sidebarOpen = false"
                        class="w-full text-left flex items-center space-x-3 pl-14 pr-4 py-2.5 rounded-lg transition {{ request()->routeIs('cabang.data-anggota') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-circle text-xs w-4"></i>
                        <span class="text-base">Data Anggota</span>
                    </button>
                    <button type="button"
                        @click="Livewire.navigate('{{ route('cabang.periode') }}'); sidebarOpen = false"
                        class="w-full text-left flex items-center space-x-3 pl-14 pr-4 py-2.5 rounded-lg transition {{ request()->routeIs('cabang.periode') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-circle text-xs w-4"></i>
                        <span class="text-base">Periode</span>
                    </button>
                </div>
            </div>

            <!-- Kalender Kegiatan -->
            <button type="button"
                @click="Livewire.navigate('{{ route('cabang.kalender-kegiatan') }}'); sidebarOpen = false"
                class="w-full text-left flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('cabang.kalender-kegiatan') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-calendar-alt text-lg w-6"></i>
                <span class="text-base font-medium">Kalender Kegiatan</span>
            </button>
        </nav>
    </div>
</div>
