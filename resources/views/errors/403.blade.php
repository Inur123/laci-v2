{{-- resources/views/errors/403.blade.php --}}
<x-layouts.error title="403 - Akses Ditolak">
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full animate-float">
                <i class="fas fa-ban text-5xl text-red-600"></i>
            </div>
        </div>

        <h1 class="text-7xl sm:text-8xl font-bold text-gray-900 mb-4">403</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Akses Ditolak</h2>
        <p class="text-base text-gray-600 mb-4">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
        </p>
    </div>
</x-layouts.error>
