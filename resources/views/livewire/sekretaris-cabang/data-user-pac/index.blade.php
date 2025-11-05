<!-- filepath: resources/views/livewire/sekretaris-cabang/data-user-pac/index.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Data User PAC</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola akun pengguna dari setiap PAC</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Total User PAC</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->totalUserPac }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-users text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">User Aktif</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->userAktif }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-user-check text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">User Nonaktif</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->userNonaktif }}</h3>
                </div>
                <div class="bg-red-100 text-red-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-user-times text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Email Verified</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->userVerified }}</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-envelope-circle-check text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Nama atau email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="$refresh"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Daftar User PAC</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email Verified</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Terdaftar</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $users->firstItem() + $index }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=fff"
                                         class="w-10 h-10 rounded-full" alt="Avatar">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">Sekretaris PAC</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @if($user->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-circle text-[8px] mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-circle text-[8px] mr-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->email_verified_at)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Verified
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-exclamation-circle mr-1"></i>Unverified
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="detail('{{ $user->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="toggleStatus('{{ $user->id }}')"
                                        wire:confirm="Apakah Anda yakin ingin mengubah status user ini?"
                                        class="text-{{ $user->is_active ? 'red' : 'green' }}-600 hover:text-{{ $user->is_active ? 'red' : 'green' }}-800 transition"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }}"></i>
                                    </button>
                                    <button wire:click="resetPassword('{{ $user->id }}')"
                                        wire:confirm="Password akan direset ke 'password123'. Lanjutkan?"
                                        class="text-yellow-600 hover:text-yellow-800 transition" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                <p>Tidak ada data user PAC</p>
                                @if($search || $filterStatus !== '')
                                    <p class="text-sm mt-2">Coba ubah filter pencarian Anda</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 🔥 Custom Pagination (Tanpa URL Parameter) -->
        @if($users->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Info -->
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $users->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $users->lastItem() }}</span>
                        dari <span class="font-medium">{{ $users->total() }}</span> hasil
                    </div>

                    <!-- Pagination Buttons -->
                    <div class="flex items-center gap-2">
                        {{-- Previous Button --}}
                        @if ($users->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $users->currentPage() - 1 }})" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="$set('page', {{ $page }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($users->hasMorePages())
                            <button wire:click="$set('page', {{ $users->currentPage() + 1 }})" wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
