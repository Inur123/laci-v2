<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/data-anggota.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Data Anggota</h1>
        <p class="text-sm text-gray-600 mt-1">Rekapitulasi data anggota dari seluruh PAC</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Anggota</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">1,245</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <p class="text-green-600 text-sm mt-4">
                <i class="fas fa-arrow-up"></i> 5% dari bulan lalu
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Anggota Aktif</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">1,102</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm mt-4">88.5% dari total</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Laki-laki</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">745</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fas fa-male text-2xl"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm mt-4">59.8% dari total</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Perempuan</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">500</h3>
                </div>
                <div class="bg-pink-100 text-pink-600 p-3 rounded-full">
                    <i class="fas fa-female text-2xl"></i>
                </div>
            </div>
            <p class="text-gray-600 text-sm mt-4">40.2% dari total</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Anggota</label>
                <input type="text" placeholder="Nama, NIK, NPNU..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">PAC</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua PAC</option>
                    <option>PAC Sukajaya</option>
                    <option>PAC Mekarjaya</option>
                    <option>PAC Sentosa</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua</option>
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition" title="Export Excel">
                    <i class="fas fa-file-excel"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Anggota</h3>
            <div class="flex gap-2">
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-file-excel mr-2"></i>Export
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">NPNU</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama Lengkap</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">PAC</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">JK</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal Lahir</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No. HP</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm font-medium text-blue-600">12345678</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name=Ahmad+Rizki&background=3b82f6&color=fff"
                                     class="w-10 h-10 rounded-full" alt="Avatar">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Ahmad Rizki</p>
                                    <p class="text-xs text-gray-500">ahmadrizki@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">PAC Sukajaya</td>
                        <td class="py-3 px-4 text-sm text-gray-700">L</td>
                        <td class="py-3 px-4 text-sm text-gray-700">15 Mei 2005</td>
                        <td class="py-3 px-4 text-sm text-gray-700">0812-3456-7890</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Aktif</span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800" title="Download Kartu">
                                <i class="fas fa-id-card"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm font-medium text-blue-600">12345679</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=ec4899&color=fff"
                                     class="w-10 h-10 rounded-full" alt="Avatar">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Siti Nurhaliza</p>
                                    <p class="text-xs text-gray-500">siti.nur@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">PAC Mekarjaya</td>
                        <td class="py-3 px-4 text-sm text-gray-700">P</td>
                        <td class="py-3 px-4 text-sm text-gray-700">20 Mar 2006</td>
                        <td class="py-3 px-4 text-sm text-gray-700">0813-4567-8901</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Aktif</span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800" title="Download Kartu">
                                <i class="fas fa-id-card"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Menampilkan 1-10 dari 1,245 anggota</p>
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
