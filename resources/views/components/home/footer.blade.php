<footer class="bg-gray-900 text-white py-8 sm:py-12" role="contentinfo">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 mb-8">
            <!-- Brand Section -->
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo-laci-3.webp') }}" alt="Logo Laci Digital" class="w-16 h-16"
                        width="80" height="80" loading="lazy">
                    <h3 class="text-base sm:text-lg font-bold">Laci Digital</h3>
                </div>
                <p class="text-xs sm:text-sm text-gray-400">
                    Sistem Informasi Manajemen Organisasi PC IPNU IPPNU Kabupaten Magetan dengan enkripsi data lengkap
                </p>
            </div>

            <!-- Navigation Links -->
            <nav aria-label="Footer Navigation" data-aos="fade-up" data-aos-delay="200">
                <h4 class="text-sm sm:text-base font-semibold mb-4">Menu</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-gray-400">
                    <li>
                        <a href="{{ route('home') }}" wire:navigate class="hover:text-green-400 transition-colors">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="#features" class="hover:text-green-400 transition-colors">
                            Fitur
                        </a>
                    </li>
                    <li>
                        <a href="#resources" class="hover:text-green-400 transition-colors">
                            Resources
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" wire:navigate class="hover:text-green-400 transition-colors">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" wire:navigate class="hover:text-green-400 transition-colors">
                            Daftar
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Contact Information -->
            <address class="not-italic" data-aos="fade-up" data-aos-delay="300">
                <h4 class="text-sm sm:text-base font-semibold mb-4">Kontak</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-gray-400">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-green-400"></i>
                        Magetan, Jawa Timur
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-envelope text-green-400"></i>
                        <a href="mailto:info@lacidigital.com" class="hover:text-green-400 transition-colors">
                            pelajarnumagetan@gmail.com
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-phone text-green-400"></i>
                        <a href="https://wa.me/6285850512135?text=Halo,%20saya%20ingin%20bertanya%20lebih%20lanjut%20mengenai%20website%20Laci%20PC%20IPNU%20IPPNU%20Magetan."
                            target="_blank" class="hover:text-green-400 transition-colors">
                            +6285850512135
                        </a>
                    </li>


                </ul>
            </address>

            <!-- Social Media Links -->
            <div data-aos="fade-up" data-aos-delay="400">
                <h4 class="text-sm sm:text-base font-semibold mb-4">Ikuti Kami</h4>
                <nav class="flex gap-3" aria-label="Social Media Links">
                    <a href="#"
                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors"
                        aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-instagram text-sm sm:text-base"></i>
                    </a>
                    <a href="#"
                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors"
                        aria-label="TikTok" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-tiktok text-sm sm:text-base"></i>
                    </a>
                    <a href="#"
                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors"
                        aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-youtube text-sm sm:text-base"></i>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 pt-6 sm:pt-8 text-center">
            <p class="text-xs sm:text-sm text-gray-400">
                &copy; {{ date('Y') }} Laci Digital PC IPNU IPPNU Magetan.
                <span class="text-gray-500">Versi 2.0.0</span> - All rights reserved.
            </p>
        </div>
    </div>
</footer>
