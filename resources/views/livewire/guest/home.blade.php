<div>
    <!-- ===================== HERO ===================== -->
    <section id="home" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div>
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-[#bbf7d0] bg-[#f0fdf4] px-3 py-1 text-xs font-semibold text-[#15803d]">
                    <span class="h-2 w-2 rounded-full bg-[#22c55e]"></span>
                    Sistem Informasi Digital
                </div>

                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">
                    Selamat Datang di <span class="text-[#15803d]">Laci Digital</span>
                </h1>

                <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">
                    Platform manajemen organisasi terintegrasi untuk <b>PC IPNU IPPNU Kabupaten Magetan</b>.
                    Kelola data anggota per periode, arsip surat & berkas, pengajuan surat, serta administrasi
                    organisasi dengan mudah, aman, dan terenkripsi.
                </p>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('login') }}" wire:navigate
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#16a34a] px-5 py-3 text-sm font-semibold text-white shadow-[0_10px_30px_rgba(2,44,20,0.10)] hover:bg-[#15803d] focus:outline-none focus:ring-2 focus:ring-[#bbf7d0]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M8 5v14l11-7L8 5Z" fill="currentColor" />
                        </svg>
                        Mulai Sekarang
                    </a>

                    <a href="{{ route('register') }}" wire:navigate
                        class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Pelajari Lebih Lanjut
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-3 sm:gap-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">Aman</p>
                        <p class="mt-1 text-xs text-slate-500">Data terenkripsi</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">Mudah</p>
                        <p class="mt-1 text-xs text-slate-500">Kelola organisasi</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">24/7</p>
                        <p class="mt-1 text-xs text-slate-500">Akses online</p>
                    </div>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-md sm:max-w-lg lg:max-w-none">
                <div
                    class="absolute -inset-3 sm:-inset-4 -z-10 rounded-[2rem] bg-gradient-to-br from-[#dcfce7] via-white to-white blur-2xl">
                </div>

                <div
                    class="rounded-[2rem] border border-slate-200 bg-white p-4 sm:p-6 shadow-[0_10px_30px_rgba(2,44,20,0.10)]">
                    <!-- header card -->
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="grid h-11 w-11 sm:h-12 sm:w-12 place-items-center rounded-2xl bg-[rgba(22,163,74,0.10)] text-[#15803d]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 2l8 4v6c0 5-3.5 9.7-8 10-4.5-.3-8-5-8-10V6l8-4Z" stroke="currentColor"
                                        stroke-width="2" stroke-linejoin="round" />
                                    <path d="M9 12l2 2 4-5" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-sm font-semibold">PC IPNU IPPNU</p>
                                <p class="text-xs text-slate-500">Dashboard ringkas & modern</p>
                            </div>
                        </div>

                        <span
                            class="inline-flex w-fit items-center rounded-full bg-[#f0fdf4] px-3 py-1 text-xs font-semibold text-[#15803d] border border-[#bbf7d0]">
                            Enkripsi Aktif
                        </span>
                    </div>

                    <!-- stats -->
                    <div class="mt-5 sm:mt-6 grid gap-3 sm:gap-4 grid-cols-1 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold text-slate-500">Anggota Terdaftar</p>
                            <p class="mt-2 text-2xl sm:text-3xl font-bold">1.248</p>
                            <p class="mt-1 text-xs text-slate-500">+12 minggu ini</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-xs font-semibold text-slate-500">Surat Diproses</p>
                            <p class="mt-2 text-2xl sm:text-3xl font-bold">342</p>
                            <p class="mt-1 text-xs text-slate-500">Real-time</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4 sm:col-span-2">
                            <p class="text-xs font-semibold text-slate-500">Status Layanan</p>

                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 text-xs sm:text-sm font-semibold text-slate-700 border border-slate-200">
                                    <span class="h-2 w-2 rounded-full bg-[#22c55e]"></span>
                                    Arsip Digital
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 text-xs sm:text-sm font-semibold text-slate-700 border border-slate-200">
                                    <span class="h-2 w-2 rounded-full bg-[#22c55e]"></span>
                                    Pengajuan Surat
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 text-xs sm:text-sm font-semibold text-slate-700 border border-slate-200">
                                    <span class="h-2 w-2 rounded-full bg-[#22c55e]"></span>
                                    Dashboard & Export
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- tip -->
                    <div class="mt-5 sm:mt-6 rounded-2xl bg-slate-50 p-4 border border-slate-200">
                        <p class="text-sm font-semibold">Tip cepat</p>
                        <p class="mt-1 text-sm text-slate-600">
                            Gunakan <b>filter periode</b> untuk memastikan data selalu sesuai masa kepengurusan.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ===================== FITUR ===================== -->
    <section id="fitur" class="border-t border-slate-200/70 bg-slate-50/40">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Fitur Unggulan</h2>
                <p class="mt-3 text-slate-600">
                    Sistem terintegrasi untuk manajemen organisasi yang efisien, rapi, dan modern.
                </p>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div
                            class="grid h-12 w-12 place-items-center rounded-2xl bg-[rgba(22,163,74,0.10)] text-[#15803d]">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7 3h10a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                    stroke="currentColor" stroke-width="2" />
                                <path d="M8 7h8M8 11h8M8 15h6" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Periode</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Periode Kepengurusan</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Switch cepat, filter otomatis, dan pengingat perubahan periode.
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-indigo-500/10 text-indigo-700">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M16 11c1.66 0 3-1.57 3-3.5S17.66 4 16 4s-3 1.57-3 3.5S14.34 11 16 11Z"
                                    stroke="currentColor" stroke-width="2" />
                                <path d="M8 11c1.66 0 3-1.57 3-3.5S9.66 4 8 4 5 5.57 5 7.5 6.34 11 8 11Z"
                                    stroke="currentColor" stroke-width="2" />
                                <path d="M8 13c-2.76 0-5 1.79-5 4v1h10v-1c0-2.21-2.24-4-5-4Z" stroke="currentColor"
                                    stroke-width="2" />
                                <path d="M16 13c-1.1 0-2.12.29-3 .78 1.21.9 2 2.1 2 3.47V19h6v-1c0-2.21-2.24-4-5-4Z"
                                    stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Anggota</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Data Anggota</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Kelola data anggota lengkap: foto, NIA, info pribadi, filter per periode.
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-orange-500/10 text-orange-700">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z"
                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Berkas</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Arsip Berkas Digital</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Enkripsi, search, pagination, dan export Excel (format Indonesia).
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-sky-500/10 text-sky-700">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7 4h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                                    stroke="currentColor" stroke-width="2" />
                                <path d="M8 8h8M8 12h6M8 16h8" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Surat</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Arsip Surat Digital</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Surat masuk/keluar: filter jenis, search, dan pencarian nomor surat.
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-violet-500/10 text-violet-700">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M3 11l18-8-8 18-2-7-8-3Z" stroke="currentColor" stroke-width="2"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Approval</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Pengajuan Surat</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Status pending/diterima/ditolak dan notifikasi otomatis.
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-amber-500/10 text-amber-700">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" />
                                <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">User</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Manajemen User PAC</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Approve akses, verifikasi email, dan monitoring aktivasi akun.
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-rose-500/10 text-rose-700">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M8 7V3m8 4V3M4 11h16" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M5 6h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z"
                                    stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Jadwal</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Kalender Kegiatan</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Jadwal cabang lengkap: waktu, tempat, dan deskripsi.
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-red-500/10 text-red-700">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v14Z"
                                    stroke="currentColor" stroke-width="2" />
                                <path d="M8 13h8M8 17h5M8 9h8" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Laporan</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Dashboard & Export</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Statistik real-time & export Excel format tanggal Indonesia.
                    </p>
                </article>

                <article
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <div class="flex items-start justify-between gap-3">
                        <div
                            class="grid h-12 w-12 place-items-center rounded-2xl bg-[rgba(22,163,74,0.10)] text-[#15803d]">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 2l8 4v6c0 5-3.5 9.7-8 10-4.5-.3-8-5-8-10V6l8-4Z" stroke="currentColor"
                                    stroke-width="2" stroke-linejoin="round" />
                                <path d="M12 11v4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">Security</span>
                    </div>
                    <h3 class="mt-4 text-base font-semibold">Keamanan Data</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Role-based access, verifikasi email, dan autentikasi berlapis.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- ===================== RESOURCES ===================== -->
    <section id="resources">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <div class="mx-auto max-w-2xl text-center">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-700">
                    <svg class="h-4 w-4 text-[#15803d]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 6v12M6 12h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Dokumen & Resources
                </div>
                <h2 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Pusat Sumber Daya</h2>
                <p class="mt-3 text-slate-600">
                    Download template surat, format administrasi, peraturan, dan logo resmi IPNU IPPNU Magetan.
                </p>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="https://drive.google.com/drive/folders/1r-4OOy_5UcDDn6glvgz7NPrr6n5uxbSP" target="_blank"
                    rel="noopener noreferrer"
                    class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <p class="font-semibold">Format Surat Baru</p>
                    <p class="mt-1 text-sm text-slate-600">Template surat terbaru sesuai standar PC IPNU IPPNU Magetan.
                    </p>
                    <span
                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#15803d] group-hover:text-[#14532d]">
                        Download Template
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                </a>

                <a href="https://drive.google.com/drive/folders/1e4__zQjlCTHsT_oIyrxlEeBDLUKm6KP7?usp=sharing"
                    target="_blank" rel="noopener noreferrer"
                    class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <p class="font-semibold">Administrasi Makesta</p>
                    <p class="mt-1 text-sm text-slate-600">
                        Format administrasi lengkap untuk Masa Kesetiaan Anggota (MAKESTA).
                    </p>
                    <span
                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#15803d] group-hover:text-[#14532d]">
                        Download Format
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                </a>

                <a href="https://drive.google.com/drive/folders/1cOwGh9FtPg62mDD61b7P097y-FWK-CTz" target="_blank"
                    rel="noopener noreferrer"
                    class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <p class="font-semibold">Logo Resmi</p>
                    <p class="mt-1 text-sm text-slate-600">Logo IPNU, IPPNU, dan PC Magetan berbagai format.</p>
                    <span
                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#15803d] group-hover:text-[#14532d]">
                        Download Logo
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                </a>

                <a href="https://drive.google.com/drive/folders/1uJuqz-Y8CD5RT0cwVNn1V2Db6rI_3FHj" target="_blank"
                    rel="noopener noreferrer"
                    class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <p class="font-semibold">Peraturan IPNU IPPNU</p>
                    <p class="mt-1 text-sm text-slate-600">Peraturan organisasi, AD/ART, dan pedoman pelaksanaan
                        terbaru.</p>
                    <span
                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#15803d] group-hover:text-[#14532d]">
                        Download Template
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                </a>

                <a href="https://drive.google.com/drive/folders/1l9Nb5O7hTyKVmuSgG8k13QmiHfBcLGRo" target="_blank"
                    rel="noopener noreferrer"
                    class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <p class="font-semibold">Format Pengajuan SP</p>
                    <p class="mt-1 text-sm text-slate-600">Template pengajuan Surat Pengantar dari PAC ke PC Magetan.
                    </p>
                    <span
                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#15803d] group-hover:text-[#14532d]">
                        Download Template
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                </a>

                <a href="https://drive.google.com/drive/u/0/folders/1FtsEWTe32t-p1aZI0MV6M5djwfClh468" target="_blank"
                    rel="noopener noreferrer"
                    class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-[0_10px_30px_rgba(2,44,20,0.10)] transition">
                    <p class="font-semibold">Perlengkapan Lakmud</p>
                    <p class="mt-1 text-sm text-slate-600">Daftar dan template perlengkapan untuk Latihan Kader Muda
                        (LAKMUD).</p>
                    <span
                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#15803d] group-hover:text-[#14532d]">
                        Download Template
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                </a>
            </div>

            <div class="mt-10 rounded-3xl border border-[#bbf7d0] bg-[#f0fdf4] p-6 sm:p-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-bold">Butuh Bantuan?</h3>
                        <p class="mt-1 text-sm text-slate-600">
                            Hubungi tim kami jika ada pertanyaan seputar dokumen dan resources.
                        </p>
                    </div>
                    <a href="mailto:pelajarnumagetan@gmail.com?subject=Butuh%20Bantuan&body=Halo%20tim,%0ASaya%20ingin%20bertanya%20tentang..."
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#16a34a] px-5 py-3 text-sm font-semibold text-white shadow-[0_10px_30px_rgba(2,44,20,0.10)] hover:bg-[#15803d]">
                        Hubungi Kami
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M3 11l18-8-8 18-2-7-8-3Z" stroke="currentColor" stroke-width="2"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>
</div>
