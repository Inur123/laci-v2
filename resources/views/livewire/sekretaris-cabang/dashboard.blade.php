<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/dashboard.blade.php -->
<div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-green-600 mb-4">Selamat Datang Sekretaris Cabang</h2>
        <p class="text-gray-700">Halo, <strong>{{ auth()->user()->name }}</strong></p>
        <p class="text-gray-600 mt-2">Ini adalah dashboard khusus untuk Sekretaris Cabang</p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-green-100 p-6 rounded-lg">
                <h3 class="font-bold text-green-700 mb-2">Total PAC</h3>
                <p class="text-4xl font-bold text-green-900">25</p>
                <p class="text-sm text-green-600 mt-2">PAC terdaftar</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg">
                <h3 class="font-bold text-green-700 mb-2">Total Anggota</h3>
                <p class="text-4xl font-bold text-green-900">3500</p>
                <p class="text-sm text-green-600 mt-2">Semua PAC</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg">
                <h3 class="font-bold text-green-700 mb-2">Laporan Masuk</h3>
                <p class="text-4xl font-bold text-green-900">18</p>
                <p class="text-sm text-green-600 mt-2">Dari semua PAC</p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Laporan PAC Terbaru</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-600">Belum ada laporan masuk</p>
            </div>
        </div>
    </div>
</div>
