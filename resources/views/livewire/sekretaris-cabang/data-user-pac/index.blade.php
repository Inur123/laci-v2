<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/data-user-pac.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Data User PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola akun pengguna dari setiap PAC</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total User PAC</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">48</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">User Aktif</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">42</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">User Nonaktif</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">6</h3>
                </div>
                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                    <i class="fas fa-user-times text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Login Hari Ini</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">15</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fas fa-sign-in-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
                <input type="text" placeholder="Nama, email..."
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
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

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Daftar User PAC</h3>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-user-plus mr-2"></i>Tambah User
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">PAC</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Role</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Login Terakhir</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=3b82f6&color=fff"
                                     class="w-10 h-10 rounded-full" alt="Avatar">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Ahmad Fauzi</p>
                                    <p class="text-xs text-gray-500">Sekretaris PAC</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">ahmad.fauzi@example.com</td>
                        <td class="py-3 px-4 text-sm text-gray-700">PAC Sukajaya</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">Sekretaris PAC</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Aktif</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">2 jam yang lalu</td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-yellow-600 hover:text-yellow-800 mr-2" title="Reset Password">
                                <i class="fas fa-key"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800" title="Nonaktifkan">
                                <i class="fas fa-ban"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=3b82f6&color=fff"
                                     class="w-10 h-10 rounded-full" alt="Avatar">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Budi Santoso</p>
                                    <p class="text-xs text-gray-500">Sekretaris PAC</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">budi.santoso@example.com</td>
                        <td class="py-3 px-4 text-sm text-gray-700">PAC Mekarjaya</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">Sekretaris PAC</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Aktif</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">1 hari yang lalu</td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-yellow-600 hover:text-yellow-800 mr-2" title="Reset Password">
                                <i class="fas fa-key"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800" title="Nonaktifkan">
                                <i class="fas fa-ban"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Menampilkan 1-10 dari 48 user</p>
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
