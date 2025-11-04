<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/arsip-surat.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Arsip Surat</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola dan lihat arsip surat masuk & keluar</p>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Surat</label>
                <input type="text" placeholder="Nomor surat, perihal..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua</option>
                    <option>Surat Masuk</option>
                    <option>Surat Keluar</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex items-end">
                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Surat</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">245</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-envelope text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Surat Masuk</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">142</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-inbox text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Surat Keluar</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">103</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-paper-plane text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Arsip Surat</h3>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Surat
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No. Surat</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Jenis</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Perihal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Pengirim/Tujuan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-700">001/SM/I/2025</td>
                        <td class="py-3 px-4 text-sm text-gray-700">15 Jan 2025</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Masuk</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">Undangan Rapat Koordinasi</td>
                        <td class="py-3 px-4 text-sm text-gray-700">PC IPNU Kota XYZ</td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800 mr-2">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-700">002/SK/I/2025</td>
                        <td class="py-3 px-4 text-sm text-gray-700">16 Jan 2025</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">Keluar</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">Laporan Kegiatan Bulanan</td>
                        <td class="py-3 px-4 text-sm text-gray-700">PC IPNU Provinsi</td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800 mr-2">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Menampilkan 1-10 dari 245 surat</p>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Prev</button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded">1</button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">3</button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
