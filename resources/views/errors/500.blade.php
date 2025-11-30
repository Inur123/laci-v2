{{-- resources/views/errors/500.blade.php --}}
<x-layouts.error title="500 - Internal Server Error">
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full animate-float">
                <i class="fas fa-server text-5xl text-red-600"></i>
            </div>
        </div>

        <h1 class="text-7xl sm:text-8xl font-bold text-gray-900 mb-4">500</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Internal Server Error</h2>
        <p class="text-base text-gray-600 mb-8">
            Maaf, terjadi kesalahan pada server. Tim kami sedang menangani masalah ini.
        </p>

        <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all shadow-lg hover:shadow-xl">
            <i class="fas fa-home"></i>
            Kembali ke Beranda
        </a>
    </div>
</x-layouts.error>
