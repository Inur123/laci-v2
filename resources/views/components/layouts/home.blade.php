<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ mobileMenuOpen: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laci Digital - Sistem Informasi Manajemen PC IPNU IPPNU Magetan</title>
    <meta name="description" content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan. Kelola data anggota, surat menyurat, dan administrasi dengan aman dan terenkripsi. Sistem approval otomatis dengan notifikasi email.">
    <meta name="keywords" content="laci digital, ipnu magetan, ippnu magetan, sistem informasi organisasi, manajemen data anggota, surat menyurat digital, pc ipnu magetan, administrasi organisasi, enkripsi data, role based access">
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
    <meta property="og:description" content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan. Kelola data anggota, surat menyurat, dan administrasi dengan aman dan terenkripsi.">
    <meta property="og:image" content="{{ asset('images/logo-laci-3.png') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Laci Digital">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="Laci Digital - Sistem Informasi Manajemen PC IPNU IPPNU Magetan">
    <meta name="twitter:description" content="Platform manajemen organisasi terintegrasi untuk PC IPNU IPPNU Kabupaten Magetan dengan enkripsi data lengkap.">
    <meta name="twitter:image" content="{{ asset('images/logo-laci-3.png') }}">

    <link rel="canonical" href="{{ url('/') }}">
    <link rel="icon" href="{{ asset('images/logo-laci-3.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-laci-3.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes float {
            0%, 100% {
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

<body class="min-h-screen relative antialiased" style="background: linear-gradient(to bottom right, #dcfce7, #ffffff, #dcfce7); background-attachment: fixed; -webkit-background-clip: border-box; -webkit-text-size-adjust: 100%;">

    <!-- Main Content -->
    <div x-data="{ mobileMenuOpen: false }">

        <!-- Navigation -->
        <x-home.navbar />

        <!-- Slot for Page Content -->
        {{ $slot }}

        <!-- Footer -->
        <x-home.footer />
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
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
