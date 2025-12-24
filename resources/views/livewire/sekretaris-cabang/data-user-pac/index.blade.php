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
            <!-- Cari User -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Nama atau email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <!-- Tombol Refresh -->
            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="$refresh"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg
                           hover:bg-blue-700 transition text-sm cursor-pointer">
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
            <table class="w-full table-auto min-w-[700px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 min-w-[200px]">Nama</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 min-w-[180px]">Email</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-24">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-28">Email Verified</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-32">Terdaftar</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-36">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $users->firstItem() + $index }}</td>

                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=fff"
                                        class="w-10 h-10 rounded-full flex-shrink-0" alt="Avatar">
                                    <div class="truncate">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">Sekretaris PAC</p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 px-4 text-sm text-gray-700 truncate">{{ $user->email }}</td>

                            <td class="py-3 px-4">
                                @if ($user->is_active)
                                    <span class="flex items-center px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-circle text-[8px] mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="flex items-center px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-circle text-[8px] mr-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4">
                                @if ($user->email_verified_at)
                                    <span class="flex items-center px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Verified
                                    </span>
                                @else
                                    <span class="flex items-center px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                                        <i class="fas fa-exclamation-circle mr-1"></i>Unverified
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                {{ $user->created_at->diffForHumans() }}
                            </td>

                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="detail('{{ $user->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition cursor-pointer"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button
                                        onclick="confirmToggleStatus('{{ $user->id }}', '{{ addslashes($user->name) }}', {{ $user->is_active ? 'true' : 'false' }})"
                                        class="text-{{ $user->is_active ? 'green' : 'red' }}-600 hover:text-{{ $user->is_active ? 'green' : 'red' }}-800 transition cursor-pointer"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'check-circle' : 'ban' }}"></i>
                                    </button>

                                    <button onclick="confirmResetPassword('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition cursor-pointer"
                                        title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>

                                    <button onclick="confirmDeleteUser('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                        class="text-red-600 hover:text-red-800 transition cursor-pointer"
                                        title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                <p>Tidak ada data user PAC</p>
                                @if ($search || $filterStatus !== '')
                                    <p class="text-sm mt-2">Coba ubah filter pencarian Anda</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (WINDOWED) -->
        @if ($users->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $users->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $users->lastItem() }}</span>
                        dari <span class="font-medium">{{ $users->total() }}</span> hasil
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Prev --}}
                        @if ($users->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $users->currentPage() - 1 }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        {{-- Windowed numbers: 1 ... 3 4 5 ... last --}}
                        @php
                            $current = $users->currentPage();
                            $last = $users->lastPage();

                            $start = max(1, $current - 2);
                            $end = min($last, $current + 2);

                            if (($end - $start) < 4) {
                                if ($start == 1) {
                                    $end = min($last, $start + 4);
                                } elseif ($end == $last) {
                                    $start = max(1, $end - 4);
                                }
                            }
                        @endphp

                        {{-- first page + dots --}}
                        @if ($start > 1)
                            <button wire:click="$set('page', 1)" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                1
                            </button>

                            @if ($start > 2)
                                <span class="px-3 py-2 text-sm text-gray-400">...</span>
                            @endif
                        @endif

                        {{-- page window --}}
                        @for ($p = $start; $p <= $end; $p++)
                            @if ($p == $current)
                                <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg font-medium">
                                    {{ $p }}
                                </span>
                            @else
                                <button wire:click="$set('page', {{ $p }})" wire:loading.attr="disabled"
                                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                    {{ $p }}
                                </button>
                            @endif
                        @endfor

                        {{-- dots + last page --}}
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <span class="px-3 py-2 text-sm text-gray-400">...</span>
                            @endif

                            <button wire:click="$set('page', {{ $last }})" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                {{ $last }}
                            </button>
                        @endif

                        {{-- Next --}}
                        @if ($users->hasMorePages())
                            <button wire:click="$set('page', {{ $users->currentPage() + 1 }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
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

{{-- SweetAlert2 Scripts --}}
<script>
    function confirmToggleStatus(id, name, isActive) {
        const action = isActive ? 'nonaktifkan' : 'aktifkan';
        const icon = isActive ? 'warning' : 'success';
        const confirmColor = isActive ? '#ef4444' : '#10b981';
        const title = isActive ? 'Nonaktifkan User?' : 'Aktifkan User?';
        const html = `Apakah Anda yakin ingin <strong>${action}</strong> user <strong>${name}</strong>?`;

        Swal.fire({
            title: title,
            html: html,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6b7280',
            confirmButtonText: `<i class="fas fa-${isActive ? 'ban' : 'check-circle'} mr-2"></i>Ya, ${isActive ? 'Nonaktifkan' : 'Aktifkan'}!`,
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: { confirmButton: 'px-4 py-2 rounded-lg', cancelButton: 'px-4 py-2 rounded-lg' }
        }).then((result) => {
            if (result.isConfirmed) @this.call('toggleStatus', id);
        });
    }

    function confirmResetPassword(id, name) {
        Swal.fire({
            title: 'Reset Password?',
            html: `Password user <strong>${name}</strong> akan direset menjadi <code class="bg-gray-100 px-2 py-1 rounded">password123</code>.<br><br>Lanjutkan?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-key mr-2"></i>Ya, Reset!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: { confirmButton: 'px-4 py-2 rounded-lg', cancelButton: 'px-4 py-2 rounded-lg' }
        }).then((result) => {
            if (result.isConfirmed) @this.call('resetPassword', id);
        });
    }

    function confirmDeleteUser(id, name) {
        Swal.fire({
            title: 'Hapus User?',
            html: `Akun <strong>${name}</strong> akan dihapus secara permanen.<br>Anda yakin?`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: { confirmButton: 'px-4 py-2 rounded-lg', cancelButton: 'px-4 py-2 rounded-lg' }
        }).then((result) => {
            if (result.isConfirmed) @this.call('delete', id);
        });
    }
</script>
