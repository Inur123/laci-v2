<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/kalender-kegiatan.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kalender Kegiatan</h1>
        <p class="text-sm text-gray-600 mt-1">Jadwal kegiatan dan agenda dari seluruh PAC</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Kegiatan</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">64</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Bulan Ini</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">12</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-calendar-check text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Minggu Ini</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">3</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Hari Ini</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">1</h3>
                </div>
                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                    <i class="fas fa-bell text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Calendar -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Januari 2025</h3>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                        Hari Ini
                    </button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-2">
                <!-- Header Days -->
                <div class="text-center text-sm font-semibold text-gray-700 py-2">Min</div>
                <div class="text-center text-sm font-semibold text-gray-700 py-2">Sen</div>
                <div class="text-center text-sm font-semibold text-gray-700 py-2">Sel</div>
                <div class="text-center text-sm font-semibold text-gray-700 py-2">Rab</div>
                <div class="text-center text-sm font-semibold text-gray-700 py-2">Kam</div>
                <div class="text-center text-sm font-semibold text-gray-700 py-2">Jum</div>
                <div class="text-center text-sm font-semibold text-gray-700 py-2">Sab</div>

                <!-- Calendar Days -->
                <!-- Empty days from previous month -->
                <div class="text-center py-3 text-gray-400 text-sm">29</div>
                <div class="text-center py-3 text-gray-400 text-sm">30</div>
                <div class="text-center py-3 text-gray-400 text-sm">31</div>

                <!-- Current month days -->
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">1</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">2</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">3</div>
                <div class="text-center py-3 bg-blue-600 text-white text-sm rounded font-semibold cursor-pointer">4</div>

                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">5</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">6</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer relative">
                    7
                    <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-green-500 rounded-full"></span>
                </div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">8</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">9</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">10</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">11</div>

                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">12</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">13</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">14</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer relative">
                    15
                    <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-yellow-500 rounded-full"></span>
                </div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">16</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">17</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">18</div>

                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">19</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer relative">
                    20
                    <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-blue-500 rounded-full"></span>
                </div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">21</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">22</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">23</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">24</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">25</div>

                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">26</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">27</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">28</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">29</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">30</div>
                <div class="text-center py-3 text-gray-700 text-sm hover:bg-gray-100 rounded cursor-pointer">31</div>
            </div>

            <div class="mt-6 flex items-center justify-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-600">Rapat</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                    <span class="text-gray-600">Kegiatan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-600">Pelatihan</span>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Kegiatan Mendatang</h3>
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Lihat Semua
                </button>
            </div>

            <div class="space-y-4">
                <!-- Event 1 - Today -->
                <div class="border-l-4 border-red-500 bg-red-50 p-4 rounded-r">
                    <div class="flex items-start justify-between mb-2">
                        <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-medium">Hari Ini</span>
                        <span class="text-xs text-gray-500">09:00 WIB</span>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Rapat Koordinasi</h4>
                    <p class="text-sm text-gray-600 mb-2">PAC Sukajaya</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Gedung IPNU Kota
                    </div>
                </div>

                <!-- Event 2 -->
                <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-r">
                    <div class="flex items-start justify-between mb-2">
                        <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-medium">7 Jan</span>
                        <span class="text-xs text-gray-500">14:00 WIB</span>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Kajian Rutin</h4>
                    <p class="text-sm text-gray-600 mb-2">PAC Mekarjaya</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Masjid Al-Ikhlas
                    </div>
                </div>

                <!-- Event 3 -->
                <div class="border-l-4 border-yellow-500 bg-yellow-50 p-4 rounded-r">
                    <div class="flex items-start justify-between mb-2">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs font-medium">15 Jan</span>
                        <span class="text-xs text-gray-500">08:00 WIB</span>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Pelatihan Kader</h4>
                    <p class="text-sm text-gray-600 mb-2">Seluruh PAC</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Aula Cabang
                    </div>
                </div>

                <!-- Event 4 -->
                <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded-r">
                    <div class="flex items-start justify-between mb-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs font-medium">20 Jan</span>
                        <span class="text-xs text-gray-500">13:00 WIB</span>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Bakti Sosial</h4>
                    <p class="text-sm text-gray-600 mb-2">PAC Sentosa</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Desa Sentosa
                    </div>
                </div>
            </div>

            <button class="w-full mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Kegiatan
            </button>
        </div>
    </div>

    <!-- List View -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Semua Kegiatan</h3>
            <div class="flex gap-2">
                <select class="px-3 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500">
                    <option>Semua PAC</option>
                    <option>PAC Sukajaya</option>
                    <option>PAC Mekarjaya</option>
                    <option>PAC Sentosa</option>
                </select>
                <select class="px-3 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500">
                    <option>Semua Kategori</option>
                    <option>Rapat</option>
                    <option>Kegiatan</option>
                    <option>Pelatihan</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama Kegiatan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">PAC</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kategori</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Lokasi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-700">04 Jan 2025, 09:00</td>
                        <td class="py-3 px-4 text-sm font-medium text-gray-800">Rapat Koordinasi</td>
                        <td class="py-3 px-4 text-sm text-gray-700">PAC Sukajaya</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Rapat</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">Gedung IPNU</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">Hari Ini</span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-700">07 Jan 2025, 14:00</td>
                        <td class="py-3 px-4 text-sm font-medium text-gray-800">Kajian Rutin</td>
                        <td class="py-3 px-4 text-sm text-gray-700">PAC Mekarjaya</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">Kegiatan</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">Masjid Al-Ikhlas</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">Mendatang</span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-blue-600 hover:text-blue-800 mr-2" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Menampilkan 1-10 dari 64 kegiatan</p>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Prev</button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded">1</button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
