{{-- resources/views/errors/503.blade.php --}}
<x-layouts.error title="503 - Sedang Maintenance">
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full animate-float">
                <i class="fas fa-tools text-5xl text-blue-600"></i>
            </div>
        </div>

        <h1 class="text-7xl sm:text-8xl font-bold text-gray-900 mb-4">503</h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Sedang Maintenance</h2>
        <p class="text-base text-gray-600 mb-6">
            Kami sedang melakukan pemeliharaan sistem. Situs akan kembali normal dalam waktu singkat.
        </p>

        <div class="inline-flex items-center gap-3 px-5 py-3 bg-blue-50 border border-blue-200 rounded-lg">
            <i class="fas fa-circle-notch animate-rotate text-blue-600"></i>
            <span class="text-sm font-semibold text-gray-700">Mohon tunggu sebentar...</span>
        </div>
    </div>
</x-layouts.error>
