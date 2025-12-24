{{-- resources/views/errors/429.blade.php --}}
<x-layouts.error title="429 - Terlalu Banyak Permintaan">
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-orange-100 rounded-full animate-float">
                <i class="fas fa-tachometer-alt text-5xl text-orange-600"></i>
            </div>
        </div>

        <h1 class="text-7xl sm:text-8xl font-bold text-gray-900 mb-4">429</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Terlalu Banyak Permintaan</h2>
        <p class="text-base text-gray-600 mb-6">
            Anda telah mengirimkan terlalu banyak permintaan. Mohon tunggu beberapa saat.
        </p>

        <div class="mb-4 inline-flex items-center gap-3 px-5 py-3 bg-orange-50 border border-orange-200 rounded-lg">
            <i class="fas fa-hourglass-half text-orange-600 animate-pulse"></i>
            <span class="text-sm font-semibold text-gray-700">Silakan tunggu sebentar...</span>
        </div>
    </div>
</x-layouts.error>
