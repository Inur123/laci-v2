<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Banner -->
    <img src="{{ asset('images/banner-2.png') }}" alt="Banner LACI IPNU IPPNU" class="banner-img">

    <!-- Content -->
    <div class="p-5 space-y-8">
        <!-- Header -->
        <div>
            <h2 class="text-center text-3xl font-bold text-gray-900">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Bergabunglah dengan kami
            </p>
        </div>

        <!-- Form -->
        <form wire:submit="register" class="mt-2 space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nama Lengkap
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="name" wire:model="name"
                        class="block w-full pl-10 pr-3 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md leading-6 bg-white placeholder-gray-500 focus:outline-none focus:ring-green-600 focus:border-green-600 text-base"
                        placeholder="John Doe" autocomplete="name" required>
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Alamat Email
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" wire:model="email"
                        class="block w-full pl-10 pr-3 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md leading-6 bg-white placeholder-gray-500 focus:outline-none focus:ring-green-600 focus:border-green-600 text-base"
                        placeholder="anda@email.com" autocomplete="email" required>
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password with Livewire -->
            <!-- Password with Alpine.js -->
            <div x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input :type="show ? 'text' : 'password'" id="password" wire:model="password"
                        class="block w-full pl-10 pr-10 py-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md leading-6 bg-white placeholder-gray-500 focus:outline-none focus:ring-green-600 focus:border-green-600 text-base"
                        placeholder="Password" autocomplete="new-password" required>
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer hover:text-gray-700">
                        <template x-if="show">
                            <i class="fas fa-eye-slash text-gray-500"></i>
                        </template>
                        <template x-if="!show">
                            <i class="fas fa-eye text-gray-500"></i>
                        </template>
                    </button>
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation with Alpine.js -->
            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Konfirmasi Password
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input :type="show ? 'text' : 'password'" id="password_confirmation"
                        wire:model="password_confirmation"
                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-md leading-6 bg-white placeholder-gray-500 focus:outline-none focus:ring-green-600 focus:border-green-600 text-base"
                        placeholder="Konfirmasi Password" autocomplete="new-password" required>
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer hover:text-gray-700">
                        <template x-if="show">
                            <i class="fas fa-eye-slash text-gray-500"></i>
                        </template>
                        <template x-if="!show">
                            <i class="fas fa-eye text-gray-500"></i>
                        </template>
                    </button>
                </div>
            </div>

            <!-- Turnstile Captcha -->
            <div>
                <x-turnstile wire:model="captcha" />
                @error('captcha')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" wire:loading.attr="disabled" wire:target="register"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 disabled:opacity-75 disabled:cursor-not-allowed cursor-pointer">
                    <span wire:loading.remove wire:target="register">Daftar</span>
                    <span wire:loading wire:target="register" class="flex items-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Memproses...
                    </span>
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" wire:navigate class="font-medium text-green-700 hover:text-green-600">
                Masuk di sini
            </a>
        </div>
    </div>
</div>
