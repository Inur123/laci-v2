<!doctype html>
<html lang="id" class="scroll-smooth">

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


    @vite('resources/js/app.js')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['ui-sans-serif', 'system-ui', 'Inter', 'Segoe UI', 'Roboto', 'Helvetica', 'Arial',
                            'Apple Color Emoji', 'Segoe UI Emoji'
                        ]
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d'
                        }
                    },
                    boxShadow: {
                        soft: '0 10px 30px rgba(2, 44, 20, 0.10)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->


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

<body class="bg-white text-slate-900 antialiased">
    <div class="noise pointer-events-none fixed inset-0 -z-10"></div>

    <x-home.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-home.footer />
</body>

</html>
