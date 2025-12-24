<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ mobileMenuOpen: false }">

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
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="format-detection" content="telephone=no">
    <meta name="color-scheme" content="light">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Laci Digital - Sistem Informasi Manajemen PC IPNU IPPNU Magetan">
    <meta property="og:description"
        content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan. Kelola data anggota, surat menyurat, dan administrasi dengan aman dan terenkripsi.">
    <meta property="og:image" content="{{ asset('images/logo-laci-3-1.png') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Laci Digital">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="Laci Digital - Sistem Informasi Manajemen PC IPNU IPPNU Magetan">
    <meta name="twitter:description"
        content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan dengan enkripsi data lengkap.">
    <meta name="twitter:image" content="{{ asset('images/logo-laci-3-1.png') }}">

    <link rel="canonical" href="{{ url('/') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />
    <link rel="shortcut icon" type="image/webp" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/logo-laci-3-1.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Preload logo untuk loading screen -->
    <link rel="preload" href="{{ asset('images/logo-laci-3-1.png') }}" as="image">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Loading Screen Styles */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, #dcfce7, #ffffff, #dcfce7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }

        #loading-screen.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loading-logo {
            width: 80px;
            height: 80px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .loading-spinner {
            width: 100px;
            height: 100px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid #16a34a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: absolute;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down {
            animation: slideDown 0.3s ease-out;
        }

        .mobile-menu-enter {
            transform: translateY(-10px);
            opacity: 0;
        }

        .mobile-menu-enter-active {
            transform: translateY(0);
            opacity: 1;
            transition: all 0.3s ease-out;
        }

        .mobile-menu-exit {
            transform: translateY(0);
            opacity: 1;
        }

        .mobile-menu-exit-active {
            transform: translateY(-10px);
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        @media (max-width: 768px) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen relative antialiased"
    style="background: linear-gradient(to bottom right, #dcfce7, #ffffff, #dcfce7); background-attachment: fixed; -webkit-background-clip: border-box; -webkit-text-size-adjust: 100%;">

    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="relative flex items-center justify-center">
            <div class="loading-spinner"></div>
            <img src="{{ asset('images/logo-laci-3.webp') }}" alt="Loading..." class="loading-logo">
        </div>
    </div>

    <!-- Main Content -->
    <div x-data="{ mobileMenuOpen: false }">

        <!-- Navigation -->
        <x-home.navbar />

        <!-- Slot for Page Content -->
        {{ $slot }}

        <!-- Footer -->
        <x-home.footer />
    </div>

    <script>
        // Hide loading screen when page is fully loaded
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loading-screen');
            loadingScreen.classList.add('loaded');

            // Remove from DOM after transition
            setTimeout(() => {
                loadingScreen.remove();
            }, 500);
        });
    </script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100,
            disable: function() {
                return window.innerWidth < 768;
            }
        });
    </script>
</body>

</html>
