<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/pengajuan-pac.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengajuan PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola pengajuan pembentukan PAC baru</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pengajuan</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">24</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Menunggu</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">8</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Disetujui</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">14</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Ditolak</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">2</h3>
                </div>
                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Status</option>
                    <option>Menunggu Review</option>
                    <option>Disetujui</option>
                    <option>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <input type="text" placeholder="Nama PAC, kecamatan..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Pengajuan PAC</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal Pengajuan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama PAC</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kecamatan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Ketua</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Jumlah Anggota</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-700">10 Jan 2025</td>
                        <td class="py-3 px-4 text-sm font-medium text-gray-800">PAC Kec. Sukajaya</td>
                        <td class="py-3 px-4 text-sm text-gray-700">Sukajaya</td>
                        <td class="py-3 px-4 text-sm text-gray-700">Ahmad Fauzi</td>
                        <td class="py-3 px-4 text-sm text-gray-700">45 orang</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">Menunggu</span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800 mr-2" title="Setujui">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800" title="Tolak">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-700">12 Jan 2025</td>
                        <td class="py-3 px-4 text-sm font-medium text-gray-800">PAC Kec. Mekarjaya</td>
                        <td class="py-3 px-4 text-sm text-gray-700">Mekarjaya</td>
                        <td class="py-3 px-4 text-sm text-gray-700">Budi Santoso</td>
                        <td class="py-3 px-4 text-sm text-gray-700">38 orang</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Disetujui</span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-purple-600 hover:text-purple-800" title="Download SK">
                                <i class="fas fa-download"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Menampilkan 1-10 dari 24 pengajuan</p>
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
