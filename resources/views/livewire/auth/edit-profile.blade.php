{{-- resources/views/livewire/auth/edit-profile.blade.php --}}
<div class="space-y-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profil Saya</h1>
        <p class="text-gray-600 mt-2">Kelola informasi akun Anda dengan aman</p>
    </div>

    <!-- Alert Verifikasi Email (di atas form) -->
    @if (!Auth::user()->hasVerifiedEmail())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="flex items-start gap-3 flex-1">
                    <div class="flex-shrink-0 mt-0.5">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-yellow-800">Email Belum Terverifikasi</h3>
                        <p class="text-xs text-yellow-700 mt-1">Silakan verifikasi email Anda untuk mengakses semua fitur.</p>
                    </div>
                </div>

                <!-- Wrapper Alpine + Livewire Sync -->
                <div x-data="resendCooldown()" class="flex-shrink-0">
                    <button type="button" wire:click="resendVerification" wire:loading.attr="disabled"
                        :disabled="$wire.resendCooldown > 0"
                        class="inline-flex items-center py-2.5 px-4 border border-transparent text-xs font-medium rounded-lg text-white transition-all duration-300 disabled:opacity-75 disabled:cursor-not-allowed whitespace-nowrap cursor-pointer w-full md:w-auto justify-center"
                        :class="$wire.resendCooldown > 0 ?
                            'bg-gray-500 cursor-not-allowed' :
                            'bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500'">
                        <!-- Normal State -->
                        <span x-show="$wire.resendCooldown === 0" wire:loading.remove wire:target="resendVerification">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Ulang Verifikasi
                        </span>

                        <!-- Countdown State -->
                        <span x-show="$wire.resendCooldown > 0" x-text="`Tunggu ${$wire.resendCooldown}s`"></span>

                        <!-- Loading State -->
                        <span wire:loading wire:target="resendVerification" class="flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Mengirim...
                        </span>
                    </button>
                </div>

                <!-- Alpine Component untuk sync countdown -->
                <script>
                    function resendCooldown() {
                        return {
                            init() {
                                // Sinkronkan dengan Livewire
                                this.$watch('$wire.resendCooldown', value => {
                                    if (value > 0) {
                                        this.startTimer();
                                    }
                                });

                                // Jalankan timer jika ada cooldown saat load
                                if (this.$wire.resendCooldown > 0) {
                                    this.startTimer();
                                }
                            },

                            startTimer() {
                                if (this.timer) clearInterval(this.timer);

                                this.timer = setInterval(() => {
                                    if (this.$wire.resendCooldown <= 1) {
                                        clearInterval(this.timer);
                                        this.timer = null;
                                    }
                                    @this.call('decrementCooldown');
                                }, 1000);
                            },

                            timer: null
                        }
                    }
                </script>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-xl p-6 lg:p-10">
        <form wire:submit="updateProfile">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model.blur="name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 transition"
                        placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" wire:model.blur="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                        placeholder="contoh@email.com" readonly disabled>

                    <div class="mt-2 space-y-1.5">
                        @if (Auth::user()->hasVerifiedEmail())
                            <p class="text-green-600 text-xs flex items-center gap-1.5">
                                <i class="fas fa-check-circle flex-shrink-0"></i>
                                <span>Email sudah terverifikasi</span>
                            </p>
                        @endif

                        <p class="text-gray-500 text-xs flex items-start gap-1.5">
                            <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
                            <span>Jika ingin melakukan perubahan email, silakan hubungi Sekretaris Cabang</span>
                        </p>
                    </div>
                </div>

                <!-- Password Baru -->
                <div x-data="{ show: false }">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password Baru
                    </label>

                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" wire:model.blur="password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg
                   focus:ring-2 focus:ring-green-500"
                            placeholder="Kosongkan jika tidak ingin ganti">

                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center
                   text-gray-500 hover:text-gray-700 cursor-pointer">

                            <template x-if="show">
                                <i class="fas fa-eye-slash"></i>
                            </template>
                            <template x-if="!show">
                                <i class="fas fa-eye"></i>
                            </template>
                        </button>
                    </div>

                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror

                    <p class="text-gray-500 text-xs mt-1">
                        Kosongkan jika tidak ingin mengubah password
                    </p>
                </div>


                <!-- Konfirmasi Password -->
                <div x-data="{ show: false }">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>

                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" wire:model.blur="password_confirmation"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg
                   focus:ring-2 focus:ring-green-500">

                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center
                   text-gray-500 hover:text-gray-700 cursor-pointer">

                            <template x-if="show">
                                <i class="fas fa-eye-slash"></i>
                            </template>
                            <template x-if="!show">
                                <i class="fas fa-eye"></i>
                            </template>
                        </button>
                    </div>
                </div>


            </div>

            <div class="mt-10">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold
               rounded-lg shadow-md transition
               flex items-center justify-center gap-2
               disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">

                    <!-- Normal -->
                    <span wire:loading.remove wire:target="updateProfile">
                        Simpan Perubahan
                    </span>

                    <!-- Loading -->
                    <span wire:loading wire:target="updateProfile">
                        <i class="fas fa-spinner fa-spin"></i>
                        Menyimpan...
                    </span>

                </button>
            </div>

        </form>
    </div>
</div>
