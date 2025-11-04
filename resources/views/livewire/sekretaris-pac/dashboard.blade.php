<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-pac/dashboard.blade.php -->
<div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-blue-600 mb-4">Selamat Datang Sekretaris PAC</h2>
        <p class="text-gray-700">Halo, <strong>{{ auth()->user()->name }}</strong></p>
        <p class="text-gray-600 mt-2">Ini adalah dashboard khusus untuk Sekretaris PAC</p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-100 p-6 rounded-lg">
                <h3 class="font-bold text-blue-700 mb-2">Total Anggota</h3>
                <p class="text-4xl font-bold text-blue-900">150</p>
                <p class="text-sm text-blue-600 mt-2">Anggota aktif</p>
            </div>
            <div class="bg-blue-100 p-6 rounded-lg">
                <h3 class="font-bold text-blue-700 mb-2">Kegiatan Bulan Ini</h3>
                <p class="text-4xl font-bold text-blue-900">12</p>
                <p class="text-sm text-blue-600 mt-2">Total kegiatan</p>
            </div>
            <div class="bg-blue-100 p-6 rounded-lg">
                <h3 class="font-bold text-blue-700 mb-2">Laporan Pending</h3>
                <p class="text-4xl font-bold text-blue-900">5</p>
                <p class="text-sm text-blue-600 mt-2">Menunggu review</p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Kegiatan Terbaru</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-600">Belum ada kegiatan terbaru</p>
            </div>
        </div>
    </div>
</div>
