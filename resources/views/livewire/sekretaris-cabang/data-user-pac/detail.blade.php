<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/sekretaris-cabang/data-user-pac/detail.blade.php -->
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-row items-center justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Detail User PAC</h1>
            <p class="text-sm text-gray-600 mt-1 break-words">
                Informasi lengkap user {{ $user->name }}
            </p>
        </div>

        <button wire:click="back"
            class="text-white bg-gray-600 hover:bg-gray-700 transition rounded-lg px-3 sm:px-4 py-2 whitespace-nowrap cursor-pointer">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=3b82f6&color=fff"
                        class="w-32 h-32 rounded-full mx-auto mb-4" alt="Avatar">

                    <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-600 mb-4">{{ $user->email }}</p>

                    <!-- Status Badges -->
                    <div class="space-y-2 mb-6">
                        @if ($user->is_active)
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Akun Aktif
                            </span>
                        @else
                            <span
                                class="inline-block px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">
                                <i class="fas fa-ban mr-1"></i>Akun Nonaktif
                            </span>
                        @endif

                        @if ($user->email_verified_at)
                            <span
                                class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                <i class="fas fa-envelope-circle-check mr-1"></i>Email Verified
                            </span>
                        @else
                            <span
                                class="inline-block px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Email Unverified
                            </span>
                        @endif

                        <span
                            class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-medium">
                            <i class="fas fa-user-shield mr-1"></i>Sekretaris PAC
                        </span>
                    </div>

                    <!-- Actions with SweetAlert -->
                    <div class="space-y-2">
                        <!-- Toggle Status Button -->
                        <button
                            onclick="confirmToggleStatus('{{ $user->id }}', '{{ addslashes($user->name) }}', {{ $user->is_active ? 'true' : 'false' }})"
                            class="w-full px-4 py-2 {{ $user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition text-sm flex items-center justify-center cursor-pointer">
                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }} mr-2"></i>
                            {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                        </button>

                        <!-- Reset Password Button -->
                        <button onclick="confirmResetPassword('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                            class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-sm flex items-center justify-center cursor-pointer">
                            <i class="fas fa-key mr-2"></i>Reset Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details & Activity -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Account Information -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informasi Akun
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">User ID</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800 break-all">{{ $user->id }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Role</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            {{ ucwords(str_replace('_', ' ', $user->role)) }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Terdaftar Sejak</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            {{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Terakhir Update</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            {{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Email Verified</label>
                        <p class="text-sm sm:text-base font-medium text-gray-800">
                            @if ($user->email_verified_at)
                                {{ $user->email_verified_at->format('d M Y, H:i') }}
                            @else
                                <span class="text-yellow-600">Belum diverifikasi</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm text-gray-600">Status Akun</label>
                        <p
                            class="text-sm sm:text-base font-medium {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Activity Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Total Anggota</p>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mt-1">{{ $user->anggotas->count() }}
                            </h3>
                        </div>
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                            <i class="fas fa-users text-lg sm:text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Total Surat</p>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mt-1">{{ $user->surats->count() }}
                            </h3>
                        </div>
                        <div class="bg-green-100 text-green-600 p-3 rounded-full">
                            <i class="fas fa-envelope text-lg sm:text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Total Periode</p>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mt-1">{{ $user->periodes->count() }}
                            </h3>
                        </div>
                        <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                            <i class="fas fa-calendar text-lg sm:text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-history text-blue-600 mr-2"></i>Aktivitas Terakhir
                </h2>
                <div class="space-y-3">
                    @if ($user->anggotas->count() > 0)
                        <div class="flex items-start space-x-3 pb-3 border-b border-gray-100">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                                <i class="fas fa-user-plus text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">Menambahkan anggota terakhir</p>
                                <p class="text-xs text-gray-500">
                                    {{ $user->anggotas->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if ($user->surats->count() > 0)
                        <div class="flex items-start space-x-3 pb-3 border-b border-gray-100">
                            <div class="bg-green-100 text-green-600 p-2 rounded-full">
                                <i class="fas fa-file-alt text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">Upload surat terakhir</p>
                                <p class="text-xs text-gray-500">
                                    {{ $user->surats->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-start space-x-3">
                        <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                            <i class="fas fa-sign-in-alt text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800">Terdaftar</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 Scripts --}}
<script>
    function confirmToggleStatus(id, name, isActive) {
        const action = isActive ? 'nonaktifkan' : 'aktifkan';
        const icon = isActive ? 'warning' : 'success';
        const confirmColor = isActive ? '#ef4444' : '#10b981';
        const title = isActive ? 'Nonaktifkan User?' : 'Aktifkan User?';
        const html = `Apakah Anda yakin ingin <strong>${action}</strong> akun <strong>${name}</strong>?`;

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
            customClass: {
                confirmButton: 'px-4 py-2 rounded-lg',
                cancelButton: 'px-4 py-2 rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('toggleStatus', id);
            }
        });
    }

    function confirmResetPassword(id, name) {
        Swal.fire({
            title: 'Reset Password?',
            html: `Password untuk <strong>${name}</strong> akan direset menjadi:<br>
                   <code class="bg-gray-100 px-3 py-1 rounded text-sm">password123</code><br><br>
                   Lanjutkan?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-key mr-2"></i>Ya, Reset!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-4 py-2 rounded-lg',
                cancelButton: 'px-4 py-2 rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('resetPassword', id);
            }
        });
    }
</script>
