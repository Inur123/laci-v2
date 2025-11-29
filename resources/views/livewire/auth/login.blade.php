<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Banner -->
    <img src="{{ asset('images/banner-2.png') }}" alt="Banner LACI IPNU IPPNU" class="banner-img">

    <!-- Content -->
    <div class="p-5 space-y-8">
        <!-- Header -->
        <div>
            <h2 class="text-center text-3xl font-bold text-gray-900">
                Selamat Datang
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Silakan masuk ke akun Anda
            </p>
        </div>

        <!-- Form -->
        <form wire:submit="login" class="mt-2 space-y-6">
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
                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-md leading-6 bg-white placeholder-gray-500 focus:outline-none focus:ring-green-600 focus:border-green-600 text-base"
                        placeholder="Password" autocomplete="current-password" required>
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

            <!-- Turnstile Captcha -->
            <div>
                <x-turnstile wire:model="captcha" />
                @error('captcha')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" wire:loading.attr="disabled" wire:target="login"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 disabled:opacity-75 disabled:cursor-not-allowed cursor-pointer">
                    <span wire:loading.remove wire:target="login">Masuk</span>
                    <span wire:loading wire:target="login" class="flex items-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Memproses...
                    </span>
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" wire:navigate class="font-medium text-green-700 hover:text-green-600">
                Daftar di sini
            </a>
        </div>
    </div>
</div>
