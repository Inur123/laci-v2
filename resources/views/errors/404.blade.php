{{-- resources/views/errors/404.blade.php --}}
<x-layouts.error title="404 - Halaman Tidak Ditemukan">
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 rounded-full animate-float">
                <i class="fas fa-search text-5xl text-yellow-600"></i>
            </div>
        </div>

        <h1 class="text-7xl sm:text-8xl font-bold text-gray-900 mb-4">404</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
        <p class="text-base text-gray-600 mb-4">
            Maaf, halaman yang Anda cari tidak dapat ditemukan.
        </p>
    </div>
</x-layouts.error>
