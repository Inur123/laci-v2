{{-- resources/views/livewire/auth/edit-profile.blade.php --}}
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profil Saya</h1>
        <p class="text-gray-600 mt-2">Kelola informasi akun Anda dengan aman</p>
    </div>



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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 transition"
                        placeholder="contoh@email.com" required>
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror

                    @if (!Auth::user()->hasVerifiedEmail())
                        <p class="text-yellow-600 text-xs mt-2">Email belum terverifikasi!</p>

                        <!-- Wrapper Alpine + Livewire Sync -->
                        <div x-data="resendCooldown()" class="mt-3">
                            <button type="button" wire:click="resendVerification" wire:loading.attr="disabled"
                                :disabled="$wire.resendCooldown > 0"
                                class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-xs font-medium rounded-lg text-white transition-all duration-300 disabled:opacity-75 disabled:cursor-not-allowed min-w-[180px]"
                                :class="$wire.resendCooldown > 0 ?
                                    'bg-gray-500 cursor-not-allowed' :
                                    'bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500'">
                                <!-- Normal State -->
                                <span x-show="$wire.resendCooldown === 0" wire:loading.remove
                                    wire:target="resendVerification">
                                    Kirim Ulang Verifikasi
                                </span>

                                <!-- Countdown State -->
                                <span x-show="$wire.resendCooldown > 0"
                                    x-text="`Tunggu ${$wire.resendCooldown}s`"></span>

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
                    @else
                        <p class="text-green-600 text-xs mt-2 flex items-center gap-1">
                            <i class="fas fa-check-circle"></i> Email sudah terverifikasi
                        </p>
                    @endif
                </div>

                <!-- Password Baru -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                    <div class="relative">
                        <input :type="$wire.showPassword ? 'text' : 'password'" wire:model.blur="password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                            placeholder="Kosongkan jika tidak ingin ganti">
                        <button type="button" wire:click="togglePassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-700">
                            <i class="fas" :class="$wire.showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <input :type="$wire.showPasswordConfirmation ? 'text' : 'password'"
                            wire:model.blur="password_confirmation"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <button type="button" wire:click="togglePasswordConfirmation"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-700">
                            <i class="fas" :class="$wire.showPasswordConfirmation ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

            </div>

            <div class="mt-10">
                <button type="submit"
                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                    <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
