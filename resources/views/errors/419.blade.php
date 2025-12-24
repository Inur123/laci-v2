{{-- resources/views/errors/419.blade.php --}}
<x-layouts.error title="419 - Sesi Kadaluarsa">
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-orange-100 rounded-full animate-float">
                <i class="fas fa-clock text-5xl text-orange-600"></i>
            </div>
        </div>

        <h1 class="text-7xl sm:text-8xl font-bold text-gray-900 mb-4">419</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Sesi Kadaluarsa</h2>
        <p class="text-base text-gray-600 mb-8">
            Sesi Anda telah berakhir. Silakan muat ulang halaman untuk melanjutkan.
        </p>

        <button onclick="location.reload()" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all shadow-lg hover:shadow-xl">
            <i class="fas fa-sync-alt"></i>
            Muat Ulang Halaman
        </button>
    </div>
</x-layouts.error>
