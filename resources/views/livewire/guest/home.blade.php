<div>
    <!-- Hero Section -->
    <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20" itemscope itemtype="https://schema.org/WebPage">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <article class="text-center lg:text-left" data-aos="fade-right" data-aos-duration="800">
                <div class="inline-block mb-4 sm:mb-6">
                    <span class="bg-green-100 text-green-700 px-3 py-1 sm:px-4 sm:py-1.5 rounded-full text-xs sm:text-sm font-semibold">
                        <i class="fas fa-sparkles mr-1" aria-hidden="true"></i> Sistem Informasi Digital
                    </span>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4 sm:mb-6 leading-tight" itemprop="headline">
                    Selamat Datang di
                    <span class="gradient-text block mt-2">
                        Laci Digital
                    </span>
                </h2>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-6 sm:mb-8 max-w-2xl mx-auto lg:mx-0" itemprop="description">
                    Platform manajemen organisasi terintegrasi untuk <strong>PC IPNU IPPNU Kabupaten Magetan</strong>.
                    Kelola data anggota per periode, arsip surat & berkas, pengajuan surat, dan administrasi organisasi dengan mudah, aman, dan terenkripsi penuh.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                    @guest
                        <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center justify-center gap-2 px-6 py-3 sm:px-8 sm:py-4 bg-green-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-green-700 transition-all hover:scale-105 shadow-lg hover:shadow-xl" aria-label="Mulai Sekarang - Daftar Gratis" data-aos="zoom-in" data-aos-delay="200">
                            <i class="fas fa-rocket" aria-hidden="true"></i>
                            Mulai Sekarang
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center gap-2 px-6 py-3 sm:px-8 sm:py-4 bg-white text-gray-700 text-sm sm:text-base font-semibold rounded-lg hover:bg-gray-50 transition-all border-2 border-gray-200 hover:border-green-600" aria-label="Pelajari Lebih Lanjut tentang Fitur" data-aos="zoom-in" data-aos-delay="300">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center justify-center gap-2 px-6 py-3 sm:px-8 sm:py-4 bg-green-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-green-700 transition-all hover:scale-105 shadow-lg hover:shadow-xl" aria-label="Ke Dashboard" data-aos="zoom-in" data-aos-delay="200">
                            <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                            Ke Dashboard
                        </a>
                    @endguest
                </div>
                <div class="grid grid-cols-3 gap-4 sm:gap-6 mt-8 sm:mt-12" role="region" aria-label="Statistik Platform">
                    <div class="text-center lg:text-left" data-aos="fade-up" data-aos-delay="400">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-green-600 mb-1">Aman</div>
                        <div class="text-xs sm:text-sm text-gray-600">Data Terenkripsi</div>
                    </div>
                    <div class="text-center lg:text-left" data-aos="fade-up" data-aos-delay="500">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-green-600 mb-1">Mudah</div>
                        <div class="text-xs sm:text-sm text-gray-600">Kelola Organisasi</div>
                    </div>
                    <div class="text-center lg:text-left" data-aos="fade-up" data-aos-delay="600">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-green-600 mb-1">24/7</div>
                        <div class="text-xs sm:text-sm text-gray-600">Akses Online</div>
                    </div>
                </div>
            </article>
            <aside class="flex justify-center lg:justify-end">
                <div class="relative">
                    <img src="{{ asset('images/logo-laci-3.webp') }}" alt="Ilustrasi Platform Laci Digital untuk Manajemen IPNU IPPNU Magetan" class="relative hidden lg:block w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96 lg:w-[500px] lg:h-[500px]" width="500" height="500" loading="lazy" data-aos="fade-left" data-aos-duration="800">
                </div>
            </aside>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="bg-white py-12 sm:py-16 lg:py-20" itemscope itemtype="https://schema.org/ItemList">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-10 sm:mb-12 lg:mb-16" data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                    Fitur Unggulan
                </h2>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
                    Sistem terintegrasi untuk manajemen organisasi yang efisien dan modern
                </p>
            </header>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <article class="bg-gradient-to-br from-green-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-green-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-calendar-alt text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Periode Kepengurusan</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Manajemen data per periode kepengurusan dengan sistem switch periode aktif, filter otomatis, dan peringatan perubahan periode
                    </p>
                </article>

                <article class="bg-gradient-to-br from-teal-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-teal-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="150">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-teal-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-users text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Data Anggota</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Kelola data anggota PC dan PAC lengkap dengan foto, NIA, informasi pribadi, dan filter berdasarkan periode kepengurusan
                    </p>
                </article>

                <article class="bg-gradient-to-br from-orange-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-orange-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-orange-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-folder-open text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Arsip Berkas Digital</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Arsip Berkas PAC dan Cabang dengan enkripsi penuh, search, pagination, dan export Excel dengan format tanggal Indonesia
                    </p>
                </article>

                <article class="bg-gradient-to-br from-blue-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-blue-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="250">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-envelope-open-text text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Arsip Surat Digital</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Sistem arsip surat masuk/keluar untuk PC dan PAC dengan enkripsi file, filter jenis surat, search, dan pencarian nomor surat
                    </p>
                </article>

                <article class="bg-gradient-to-br from-purple-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-purple-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-paper-plane text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Pengajuan Surat</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        PAC dapat mengajukan surat ke PC dengan status pending, diterima, atau ditolak disertai notifikasi email otomatis
                    </p>
                </article>

                <article class="bg-gradient-to-br from-yellow-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-yellow-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="350">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-yellow-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-user-check text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Manajemen User PAC</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Kelola user PAC dengan approve/unapprove akses, edit data user, verifikasi email, dan monitoring status aktivasi akun
                    </p>
                </article>

                <article class="bg-gradient-to-br from-pink-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-pink-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-pink-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-calendar-check text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Kalender Kegiatan</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Penjadwalan dan monitoring kegiatan tingkat cabang dengan detail waktu, tempat, dan deskripsi lengkap
                    </p>
                </article>

                <article class="bg-gradient-to-br from-red-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-red-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="450">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-chart-pie text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Dashboard & Export</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Dashboard interaktif dengan statistik real-time, referensi surat PAC, dan export Excel dengan format tanggal Indonesia
                    </p>
                </article>

                <article class="bg-gradient-to-br from-indigo-50 to-white p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-shadow border border-indigo-100" itemprop="itemListElement" itemscope itemtype="https://schema.org/Service" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-indigo-600 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-shield-alt text-white text-xl sm:text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3" itemprop="name">Keamanan Data</h3>
                    <p class="text-sm sm:text-base text-gray-600" itemprop="description">
                        Enkripsi penuh untuk data sensitif dan file, verifikasi email, role-based access control, dan sistem autentikasi berlapis
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Resources Section -->
    <section id="resources" class="bg-gradient-to-br from-green-50 to-white py-12 sm:py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-10 sm:mb-12 lg:mb-16" data-aos="fade-up">
                <div class="inline-block mb-4">
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-download mr-2"></i>Dokumen & Resources
                    </span>
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                    Pusat Sumber Daya
                </h2>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
                    Download template surat, format administrasi, peraturan, dan logo resmi IPNU IPPNU Magetan
                </p>
            </header>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="group bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-delay="100">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-word text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                Format Surat Baru
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Template surat resmi terbaru sesuai standar PC IPNU IPPNU Magetan
                            </p>
                            <a href="https://drive.google.com/drive/folders/1r-4OOy_5UcDDn6glvgz7NPrr6n5uxbSP" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700">
                                <i class="fas fa-download"></i>
                                Download Template
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-clipboard-list text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                Administrasi Makesta
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Format administrasi lengkap untuk Masa Kesetiaan Anggota (MAKESTA)
                            </p>
                            <a href="https://drive.google.com/drive/folders/1e4__zQjlCTHsT_oIyrxlEeBDLUKm6KP7?usp=sharing" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700">
                                <i class="fas fa-download"></i>
                                Download Format
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-delay="300">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-box-open text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                Perlengkapan Lakmud
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Daftar dan template perlengkapan untuk Latihan Kader Muda (LAKMUD)
                            </p>
                            <a href="https://drive.google.com/drive/u/0/folders/1FtsEWTe32t-p1aZI0MV6M5djwfClh468" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700">
                                <i class="fas fa-download"></i>
                                Download Checklist
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-delay="400">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-gavel text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                Peraturan IPNU IPPNU
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Peraturan organisasi, AD/ART, dan pedoman pelaksanaan terbaru
                            </p>
                            <a href="https://drive.google.com/drive/folders/1uJuqz-Y8CD5RT0cwVNn1V2Db6rI_3FHj" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700">
                                <i class="fas fa-download"></i>
                                Download Peraturan
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-delay="500">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-signature text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                Format Pengajuan SP
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Template pengajuan Surat Pengantar dari PAC ke PC Magetan
                            </p>
                            <a href="https://drive.google.com/drive/folders/1l9Nb5O7hTyKVmuSgG8k13QmiHfBcLGRo" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700">
                                <i class="fas fa-download"></i>
                                Download Template
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-delay="600">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-image text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                Logo Resmi
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Logo IPNU, IPPNU, dan PC Magetan dalam berbagai format (PNG, SVG, AI)
                            </p>
                            <a href="https://drive.google.com/drive/folders/1cOwGh9FtPg62mDD61b7P097y-FWK-CTz" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700">
                                <i class="fas fa-download"></i>
                                Download Logo
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 sm:p-8 text-white" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-center sm:text-left">
                        <h3 class="text-xl sm:text-2xl font-bold mb-2">
                            <i class="fas fa-info-circle mr-2"></i>
                            Butuh Bantuan?
                        </h3>
                        <p class="text-sm sm:text-base text-green-50">
                            Hubungi tim kami jika ada pertanyaan seputar dokumen dan resources
                        </p>
                    </div>
                    <a href="mailto:info@lacidigital.com" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-green-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                        <i class="fas fa-envelope"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
