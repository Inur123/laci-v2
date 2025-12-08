<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LACI - Authentication' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo-laci-3.webp') }}?v={{ time() }}" />
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Cloudflare Turnstile - Render manual -->

    @livewireStyles
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .banner-img {
            width: 100%;
            height: 130px;
            object-fit: cover;
        }

        @media (max-width: 640px) {
            .banner-img {
                height: 110px;
            }
        }

        /* Animation for flash message */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        .animate-slide-out {
            animation: slideOut 0.3s ease-in forwards;
        }
    </style>
</head>

<body class="bg-gray-100 antialiased min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">

    <!-- Loading Overlay -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center space-x-3">
                <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 font-medium">Memproses...</span>
            </div>
        </div>
    </div>

    <!-- Flash Message Component -->
    @livewire('components.flash-message')

    <!-- Main Content -->
    <div class="max-w-md w-full">
        {{ $slot }}
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
