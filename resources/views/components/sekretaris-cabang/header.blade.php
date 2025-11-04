<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/sekretaris-cabang/header.blade.php -->
<header
    class="fixed top-0 left-0 right-0 bg-white shadow-sm z-40 transition-all duration-300"
    :class="sidebarOpen ? 'lg:left-64' : 'lg:left-20'"
>
    <div class="flex items-center justify-between p-3 md:p-4">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-gray-900 p-2">
            <i class="fas fa-bars text-lg md:text-xl"></i>
        </button>

        <div class="flex items-center space-x-2 md:space-x-4">
            <!-- Search -->
            <div class="hidden md:block">
                <input
                    type="text"
                    placeholder="Cari..."
                    class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <!-- Notifications -->
            <button class="relative text-gray-600 hover:text-gray-900 p-2">
                <i class="fas fa-bell text-base md:text-lg"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <!-- Profile -->
            <div x-data="{ profileOpen: false }" class="relative">
                <button @click="profileOpen = !profileOpen" class="flex items-center space-x-1 md:space-x-2 p-1">
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=16a34a&color=fff"
                        alt="Profile"
                        class="w-8 h-8 md:w-9 md:h-9 rounded-full"
                    />
                    <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <i :class="profileOpen ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs text-gray-600"></i>
                </button>

                <div
                    x-show="profileOpen"
                    @click.away="profileOpen = false"
                    x-transition
                    class="absolute right-0 mt-2 w-40 md:w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200"
                >
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user text-xs mr-2"></i>Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog text-xs mr-2"></i>Pengaturan
                    </a>
                    <hr class="my-2" />
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt text-xs mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
