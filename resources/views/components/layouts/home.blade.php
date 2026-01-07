<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laci Digital - Sistem Informasi Manajemen PC IPNU IPPNU Magetan</title>

    <meta name="description"
        content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan. Kelola data anggota, surat menyurat, dan administrasi dengan aman dan terenkripsi. Sistem approval otomatis dengan notifikasi email.">
    <meta name="keywords"
        content="laci digital, ipnu magetan, ippnu magetan, sistem informasi organisasi, manajemen data anggota, surat menyurat digital, pc ipnu magetan, administrasi organisasi, enkripsi data, role based access">
    <meta name="author" content="PC IPNU IPPNU Magetan">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    <meta name="revisit-after" content="7 days">
    <meta name="format-detection" content="telephone=no">
    <meta name="color-scheme" content="only light">

    <!--  PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#22c55e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Laci Digital">
    <link rel="apple-touch-icon" href="/images/logo-laci-new.webp">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Laci Digital - Sistem Informasi Manajemen PC IPNU IPPNU Magetan">
    <meta property="og:description"
        content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan. Kelola data anggota, surat menyurat, dan administrasi dengan aman dan terenkripsi.">
    <meta property="og:image" content="{{ asset('images/logo-laci-new.webp') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Laci Digital">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="Laci Digital - Sistem Informasi Manajemen PC IPNU IPPNU Magetan">
    <meta name="twitter:description"
        content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan dengan enkripsi data lengkap.">
    <meta name="twitter:image" content="{{ asset('images/logo-laci-new.webp') }}">

    <!-- Icon -->
    <link rel="canonical" href="{{ url('/') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />
    <link rel="shortcut icon" type="image/webp" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/logo-laci-new.webp') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preload" href="{{ asset('images/logo-laci-new.webp') }}" as="image">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .noise {
            background-image:
                radial-gradient(circle at 10% 10%, rgba(34, 197, 94, .12), transparent 45%),
                radial-gradient(circle at 90% 20%, rgba(34, 197, 94, .10), transparent 40%),
                radial-gradient(circle at 40% 90%, rgba(34, 197, 94, .10), transparent 45%);
        }
    </style>
</head>

<body class="bg-white text-slate-900 antialiased font-[Inter]">
    <div class="noise pointer-events-none fixed inset-0 -z-10"></div>

    <!--  PWA Install Modal (selalu muncul tiap web dibuka) -->
    {{-- <div x-data="pwaInstallModal()" x-show="show" x-cloak x-init="init()"
        class="fixed inset-0 z-[999] flex items-start justify-center px-4 pt-6 sm:pt-10">

        <!-- overlay -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="dismiss()"></div>

        <!-- modal -->
        <div class="relative w-full max-w-md rounded-2xl border border-white/10 bg-slate-950/95 text-white shadow-2xl">
            <div class="flex items-start gap-4 p-5">
                <img src="{{ asset('images/logo-laci-new.webp') }}"
                    class="h-12 w-12 rounded-xl object-contain bg-white/5 p-2" alt="Laci">

                <div class="flex-1">
                    <p class="text-sm font-semibold leading-tight">Install Laci Digital</p>
                    <p class="mt-1 text-xs text-slate-300">
                        Tambahkan ke layar utama agar akses lebih cepat seperti aplikasi.
                    </p>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <button @click="install()"
                            class="rounded-xl bg-green-500 px-4 py-2 text-xs font-semibold text-white hover:bg-green-600 transition">
                            Install Sekarang
                        </button>

                        <button @click="dismiss()"
                            class="rounded-xl bg-white/5 px-4 py-2 text-xs text-slate-300 hover:bg-white/10 hover:text-white transition">
                            Nanti
                        </button>
                    </div>
                </div>

                <button @click="dismiss()"
                    class="rounded-xl p-2 text-slate-300 hover:text-white hover:bg-white/10 transition"
                    aria-label="Close">
                    ✕
                </button>
            </div>
        </div>
    </div> --}}

    <x-home.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-home.footer />

    <!--  Register Service Worker -->
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/sw.js").then(() => {
                    console.log("Service Worker registered!");
                });
            });
        }

        function pwaInstallModal() {
            return {
                deferredPrompt: null,
                show: false,

                init() {
                    window.addEventListener("beforeinstallprompt", (e) => {
                        e.preventDefault();
                        this.deferredPrompt = e;

                        //  SELALU tampil setiap reload / buka halaman
                        this.show = true;
                    });
                },

                async install() {
                    if (!this.deferredPrompt) return;

                    this.deferredPrompt.prompt();
                    const {
                        outcome
                    } = await this.deferredPrompt.userChoice;

                    this.deferredPrompt = null;
                    this.show = false;

                    console.log("PWA install outcome:", outcome);
                },

                dismiss() {
                    // hanya menutup saat ini saja
                    this.show = false;
                }
            }
        }
    </script>

    <!--  Chatwoot Live Chat (tambahkan sebelum </body>) -->
    {{-- <script>
      window.chatwootSettings = {
        locale: "id",
        position: "right",
        type: "standard"
      };

      (function(d,t) {
        var BASE_URL="https://app.chatwoot.com";
        var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=BASE_URL+"/packs/js/sdk.js";
        g.async = true;
        s.parentNode.insertBefore(g,s);
        g.onload=function(){
          window.chatwootSDK.run({
            websiteToken: '6w6b9zuUzKyUto29zKxjRhSr',
            baseUrl: BASE_URL
          })
        }
      })(document,"script");
    </script> --}}

</body>

</html>
