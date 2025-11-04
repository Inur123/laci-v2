<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/periode.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Periode Kepengurusan</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola periode kepengurusan PAC Cabang</p>
    </div>

    <!-- Current Period Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm mb-2">Periode Aktif Saat Ini</p>
                <h2 class="text-3xl font-bold mb-2">2023 - 2025</h2>
                <p class="text-blue-100">Masa Bakti: 2 Tahun</p>
            </div>
            <div class="text-right">
                <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                    <p class="text-sm mb-1">Sisa Waktu</p>
                    <p class="text-2xl font-bold">8 Bulan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Periode</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">5</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-history text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Periode Aktif</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">1</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total PAC</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">18</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fas fa-building text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pengurus</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">156</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Periode</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua</option>
                    <option>Aktif</option>
                    <option>Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Periode</label>
                <input type="text" placeholder="Cari tahun..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end gap-2">
                <button class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Periode Kepengurusan</h3>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Periode
            </button>
        </div>

        <div class="p-6">
            <!-- Active Period -->
            <div class="relative border-l-4 border-green-500 pl-8 pb-8">
                <div class="absolute w-6 h-6 bg-green-500 rounded-full -left-3.5 top-0"></div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-medium">Aktif</span>
                            <h4 class="text-xl font-bold text-gray-800 mt-2">Periode 2023 - 2025</h4>
                            <p class="text-sm text-gray-600 mt-1">Mulai: 1 Januari 2023 • Berakhir: 31 Desember 2025</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <p class="text-sm text-gray-600">Total PAC</p>
                            <p class="text-2xl font-bold text-gray-800">18</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <p class="text-sm text-gray-600">Total Pengurus</p>
                            <p class="text-2xl font-bold text-gray-800">156</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <p class="text-sm text-gray-600">Total Anggota</p>
                            <p class="text-2xl font-bold text-gray-800">1,245</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Past Period 1 -->
            <div class="relative border-l-4 border-gray-300 pl-8 pb-8">
                <div class="absolute w-6 h-6 bg-gray-300 rounded-full -left-3.5 top-0"></div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="px-3 py-1 bg-gray-500 text-white rounded-full text-xs font-medium">Selesai</span>
                            <h4 class="text-xl font-bold text-gray-800 mt-2">Periode 2021 - 2023</h4>
                            <p class="text-sm text-gray-600 mt-1">Mulai: 1 Januari 2021 • Berakhir: 31 Desember 2023</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800" title="Download Laporan">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-600">Total PAC</p>
                            <p class="text-2xl font-bold text-gray-800">15</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-600">Total Pengurus</p>
                            <p class="text-2xl font-bold text-gray-800">142</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-600">Total Anggota</p>
                            <p class="text-2xl font-bold text-gray-800">1,089</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Past Period 2 -->
            <div class="relative border-l-4 border-gray-300 pl-8 pb-8">
                <div class="absolute w-6 h-6 bg-gray-300 rounded-full -left-3.5 top-0"></div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="px-3 py-1 bg-gray-500 text-white rounded-full text-xs font-medium">Selesai</span>
                            <h4 class="text-xl font-bold text-gray-800 mt-2">Periode 2019 - 2021</h4>
                            <p class="text-sm text-gray-600 mt-1">Mulai: 1 Januari 2019 • Berakhir: 31 Desember 2021</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800" title="Download Laporan">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-600">Total PAC</p>
                            <p class="text-2xl font-bold text-gray-800">12</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-600">Total Pengurus</p>
                            <p class="text-2xl font-bold text-gray-800">128</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-600">Total Anggota</p>
                            <p class="text-2xl font-bold text-gray-800">956</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
