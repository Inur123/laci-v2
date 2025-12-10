<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/header.blade.php -->
<header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-40 transition-all duration-300"
    :class="sidebarOpen ? 'lg:left-64' : 'lg:left-20'">
    <div class="flex items-center justify-between p-3 md:p-4">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-gray-900 p-2 cursor-pointer">
            <i class="fas fa-bars text-lg md:text-xl"></i>
        </button>

        <div class="flex items-center space-x-2 md:space-x-4">
            <!-- Ganti Periode Component -->
            @livewire('components.ganti-periode')

            <!-- Profile -->
            <div x-data="{ profileOpen: false }" class="relative">
                <button @click="profileOpen = !profileOpen"
                    class="flex items-center space-x-1 md:space-x-2 p-1 cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=16a34a&color=fff"
                        alt="Profile" class="w-8 h-8 md:w-9 md:h-9 rounded-full" />
                    <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <i :class="profileOpen ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs text-gray-600"></i>
                </button>

                <div x-show="profileOpen" @click.away="profileOpen = false" x-transition
                    class="absolute right-0 mt-2 w-40 md:w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
                    <a href="{{ route('edit-profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user text-xs mr-2"></i>Profile
                    </a>
                    <hr class="my-2 border-gray-200" />

                    <!-- Logout Livewire Component -->
                    @livewire('auth.logout')
                </div>
            </div>
        </div>
    </div>
</header>
