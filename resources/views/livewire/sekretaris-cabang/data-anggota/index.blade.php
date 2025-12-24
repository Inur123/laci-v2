<!-- resources/views/livewire/sekretaris-cabang/data-anggota/index.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Data Anggota</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola data anggota organisasi</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Total Anggota</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->statsAnggota['total'] }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-users text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Laki-laki</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->statsAnggota['laki'] }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-male text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">Perempuan</p>
                    <h3 class="text-xl sm:text-2xl font-bold mt-1 text-gray-800">{{ $this->statsAnggota['perempuan'] }}
                    </h3>
                </div>
                <div class="bg-pink-100 text-pink-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-female text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs sm:text-sm">By Role</p>
                    <div class="flex gap-2 mt-1">
                        <span class="text-sm font-bold text-blue-600">PAC: {{ $this->statsAnggota['pac'] }}</span>
                        <span class="text-sm font-bold text-green-600">Cab: {{ $this->statsAnggota['cab'] }}</span>
                    </div>
                </div>
                <div class="bg-purple-100 text-purple-600 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-user-shield text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Export User</label>
                <select wire:model="exportUserId"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua User</option>
                    @foreach ($this->exportUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>

                <form wire:submit.prevent="export" class="w-full">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-green-600 text-white px-4 py-2 rounded-lg
                               hover:bg-green-700 transition text-sm
                               flex items-center justify-center gap-2
                               disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                        <span wire:loading.remove wire:target="export">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </span>
                        <span wire:loading wire:target="export">
                            <i class="fas fa-spinner fa-spin"></i>
                            Mengunduh...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Anggota</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Nama lengkap..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                <select wire:model.live="filterPeriode"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua Periode</option>
                    @foreach ($this->periodeList as $periode)
                        <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Dibuat Oleh <span class="text-xs text-gray-500">(Aktif & Verified)</span>
                </label>
                <select wire:model.live="filterUser"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="">Semua User</option>
                    @foreach ($this->userList as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} ({{ $user->role === 'sekretaris_cabang' ? 'Cabang' : 'PAC' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="hidden md:block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button wire:click="create"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg
                           hover:bg-blue-700 transition text-sm cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>Tambah Anggota
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">Daftar Anggota</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 w-16">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama Lengkap</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">NIK/NIA</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Periode</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">JK</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No. HP</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Dibuat Oleh</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($anggotas as $index => $anggota)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                {{ $anggotas->firstItem() + $index }}
                            </td>

                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $anggota->avatar_url }}" class="w-10 h-10 rounded-full object-cover"
                                        alt="{{ $anggota->nama_lengkap }}">
                                    <div class="whitespace-nowrap">
                                        <p class="text-sm font-medium text-gray-800">{{ $anggota->nama_lengkap }}</p>
                                        @if ($anggota->email)
                                            <p class="text-xs text-gray-500">{{ $anggota->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                @if ($anggota->nik)
                                    <span class="text-xs">NIK: {{ $anggota->nik }}</span><br>
                                @endif
                                @if ($anggota->nia)
                                    <span class="text-xs text-blue-600">NIA: {{ $anggota->nia }}</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                {{ $anggota->periode->nama }}
                            </td>

                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                @if ($anggota->jenis_kelamin === 'Laki-laki')
                                    <span class="text-blue-600"><i class="fas fa-male"></i></span>
                                @elseif($anggota->jenis_kelamin === 'Perempuan')
                                    <span class="text-pink-600"><i class="fas fa-female"></i></span>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                {{ $anggota->no_hp ?? '-' }}
                            </td>

                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $anggota->user->role === 'sekretaris_cabang' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} inline-flex items-center gap-1">
                                        <i class="fas fa-user-shield"></i>
                                        {{ $anggota->user->role === 'sekretaris_cabang' ? 'Cabang' : 'PAC' }}
                                    </span>
                                    @if ($anggota->user->is_active && $anggota->user->email_verified_at)
                                        <div class="flex gap-1">
                                            <span class="px-2 py-0.5 bg-green-50 text-green-600 rounded text-[10px]"
                                                title="Akun Aktif">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[10px]"
                                                title="Email Verified">
                                                <i class="fas fa-envelope-circle-check"></i>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <button wire:click="detail('{{ $anggota->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition cursor-pointer"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="edit('{{ $anggota->id }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition cursor-pointer"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        onclick="confirmDeleteAnggota('{{ $anggota->id }}', '{{ $anggota->nama_lengkap }}')"
                                        class="text-red-600 hover:text-red-800 transition cursor-pointer"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-users-slash text-4xl mb-2 block"></i>
                                <p>Belum ada data anggota</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (WINDOWED) -->
        @if ($anggotas->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $anggotas->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $anggotas->lastItem() }}</span>
                        dari <span class="font-medium">{{ $anggotas->total() }}</span> hasil
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Prev --}}
                        @if ($anggotas->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="$set('page', {{ $anggotas->currentPage() - 1 }})"
                                wire:loading.attr="disabled"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        {{-- Windowed numbers: 1 ... 3 4 5 ... last --}}
                        @php
                            $current = $anggotas->currentPage();
                            $last = $anggotas->lastPage();

                            $start = max(1, $current - 2);
                            $end = min($last, $current + 2);

                            if ($end - $start < 4) {
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
                        @if ($anggotas->hasMorePages())
                            <button wire:click="$set('page', {{ $anggotas->currentPage() + 1 }})"
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

<script>
    function confirmDeleteAnggota(id, namaLengkap) {
        Swal.fire({
            title: 'Hapus Anggota?',
            html: `Anggota <strong>${namaLengkap}</strong> akan dihapus secara permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-4 py-2 rounded-lg',
                cancelButton: 'px-4 py-2 rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', id);
            }
        });
    }
</script>
