<nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50" role="navigation" aria-label="Main Navigation">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between items-center h-16 sm:h-20">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 sm:gap-3">
                <img src="{{ asset('images/logo-laci-3.webp') }}" alt="Logo Laci Digital PC IPNU IPPNU Magetan"
                    class="w-12 h-12 sm:w-15 sm:h-15" width="80" height="80" loading="eager">
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-gray-800">Laci Digital</h1>
                    <p class="text-[10px] sm:text-xs text-gray-500 hidden sm:block">PC IPNU IPPNU Magetan</p>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-2 sm:gap-4">
                <a href="#resources" class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-gray-700 text-xs sm:text-sm font-medium hover:text-green-600 transition-colors">
                    <i class="fas fa-folder-open" aria-hidden="true"></i>
                    <span>Resources</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-green-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-gray-700 text-xs sm:text-sm font-medium hover:text-green-600 transition-colors">
                        <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-green-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-user-plus" aria-hidden="true"></i>
                        <span>Daftar</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-green-600 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 transition-colors"
                    :aria-expanded="mobileMenuOpen" aria-controls="mobile-menu">
                    <span class="sr-only">Buka menu utama</span>
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
            x-transition:enter="mobile-menu-enter"
            x-transition:enter-start="mobile-menu-enter"
            x-transition:enter-end="mobile-menu-enter-active"
            x-transition:leave="mobile-menu-exit"
            x-transition:leave-start="mobile-menu-exit"
            x-transition:leave-end="mobile-menu-exit-active"
            @click.away="mobileMenuOpen = false"
            id="mobile-menu"
            class="md:hidden absolute left-4 right-4 top-full mt-2 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#resources" @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-md transition-colors">
                    <i class="fas fa-folder-open w-5 text-center"></i>
                    <span>Resources</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-3 py-2 text-base font-medium text-green-700 bg-green-50 rounded-md transition-colors">
                        <i class="fas fa-tachometer-alt w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" wire:navigate @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-md transition-colors">
                        <i class="fas fa-sign-in-alt w-5 text-center"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ route('register') }}" wire:navigate @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-3 py-2 text-base font-medium text-white bg-green-600 hover:bg-green-700 rounded-md transition-colors">
                        <i class="fas fa-user-plus w-5 text-center"></i>
                        <span>Daftar</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
