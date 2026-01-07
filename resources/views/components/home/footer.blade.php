<footer id="kontak" class="border-t border-slate-200 bg-slate-950 text-slate-200">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-5">

            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-laci-new.webp') }}" alt="Laci Digital"
                        class="h-10 w-10 rounded-xl object-contain shadow-[0_10px_30px_rgba(2,44,20,0.10)]" />
                    <div>
                        <p class="font-semibold">Laci Digital</p>
                        <p class="text-sm text-slate-400">Sistem Informasi Manajemen Organisasi</p>
                    </div>
                </div>

                <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-400">
                    Platform manajemen organisasi PC IPNU IPPNU Kabupaten Magetan dengan enkripsi data dan pengelolaan
                    dokumen yang rapi.
                </p>
            </div>

            <!-- Menu -->
            <div>
                <p class="text-sm font-semibold">Menu</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-400">
                    <li><a class="hover:text-white transition-colors" href="#home">Home</a></li>
                    <li><a class="hover:text-white transition-colors" href="#fitur">Fitur</a></li>
                    <li><a class="hover:text-white transition-colors" href="#resources">Resources</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <p class="text-sm font-semibold">Kontak</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-400">
                    <li class="flex items-center">
                        <span>Magetan, Jawa Timur</span>
                    </li>
                    <li class="flex items-center">
                        <a href="mailto:pelajarnumagetan@gmail.com" class="hover:text-[#22c55e] transition-colors">
                            pelajarnumagetan@gmail.com
                        </a>
                    </li>
                    <li class="flex items-center">
                        <a href="https://wa.me/6285850512135?text=Halo,%20saya%20ingin%20bertanya%20lebih%20lanjut%20mengenai%20IPNU%20IPPNU%20Magetan."
                            target="_blank" rel="noopener noreferrer" class="hover:text-[#22c55e] transition-colors">
                            +62 858-5051-2135
                        </a>
                    </li>
                </ul>
            </div>

            <!--  Media Partner -->
            <div class="text-left">
                <p class="text-sm font-semibold">Media Partner</p>

                <!-- Card / Container -->
                <div class="mt-2 w-fit overflow-hidden rounded-2xl bg-white shadow-lg">
                    <img src="{{ asset('images/media.webp') }}" alt="Media Partner"
                        class="h-20 w-auto object-contain" />
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div
            class="mt-10 flex flex-col gap-2 border-t border-white/10 pt-6 text-center text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:text-left">
            <p>© <span x-data x-text="{{ date('Y') }}"></span> Laci Digital. All rights reserved.</p>
            <p>Versi v2.0.0</p>
        </div>
    </div>
</footer>
