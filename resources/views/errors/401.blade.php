{{-- resources/views/errors/401.blade.php --}}
<x-layouts.error title="401 - Autentikasi Diperlukan">
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 rounded-full animate-float">
                <i class="fas fa-lock text-5xl text-purple-600"></i>
            </div>
        </div>

        <h1 class="text-7xl sm:text-8xl font-bold text-gray-900 mb-4">401</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Autentikasi Diperlukan</h2>
        <p class="text-base text-gray-600 mb-8">
            Anda harus login terlebih dahulu untuk mengakses halaman ini.
        </p>

        <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all shadow-lg hover:shadow-xl">
            <i class="fas fa-sign-in-alt"></i>
            Login Sekarang
        </a>
    </div>
</x-layouts.error>
