{{-- filepath: resources/views/livewire/auth/edit-profile.blade.php --}}
<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Profil Saya</h1>
            <p class="text-sm text-gray-600 mt-1">Ubah nama, email, dan password akun Anda</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        @if(session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <form wire:submit.prevent="updateProfile">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-1 text-gray-400"></i>Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model.defer="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm"
                        required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-gray-400"></i>Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" wire:model.defer="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm"
                        required>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Password Baru -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-key mr-1 text-gray-400"></i>Password Baru
                    </label>
                    <div class="relative">
                        <input :type="$wire.showPassword ? 'text' : 'password'"
                            wire:model.defer="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm pr-10"
                            autocomplete="new-password">
                        <button type="button" wire:click="togglePassword"
                            class="absolute right-2 top-2 text-gray-500 hover:text-gray-700">
                            <i class="fas" :class="$wire.showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-gray-400"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input :type="$wire.showPasswordConfirmation ? 'text' : 'password'"
                            wire:model.defer="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 text-sm pr-10"
                            autocomplete="new-password">
                        <button type="button" wire:click="togglePasswordConfirmation"
                            class="absolute right-2 top-2 text-gray-500 hover:text-gray-700">
                            <i class="fas" :class="$wire.showPasswordConfirmation ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6">
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
