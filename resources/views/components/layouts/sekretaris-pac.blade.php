<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/components/layouts/sekretaris-pac.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'LACI - Sekretaris PAC' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />

    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" x-cloak>

    <!-- Flash Message Component -->
    @livewire('components.flash-message')

    <!-- Sidebar Desktop -->
    <x-sekretaris-pac.sidebar />

    <!-- Mobile Sidebar -->
    <x-sekretaris-pac.mobile-sidebar />

    <!-- Main Content -->
    <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="transition-all duration-300">

        <!-- Header -->
        <x-sekretaris-pac.header />

        <!-- Dashboard Content -->
        <main class="pt-20 md:pt-24 p-4 md:p-6 pb-20 md:pb-24">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <x-sekretaris-pac.footer />
    </div>

    @livewireScripts

</body>

</html>
