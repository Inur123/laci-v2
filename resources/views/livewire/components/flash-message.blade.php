<!-- filepath: /Users/muhammadzainurroziqin/Documents/coding/ipnu/laci-v2/resources/views/livewire/components/flash-message.blade.php -->
<div>
    @if($show)
        <div
            wire:key="flash-{{ now()->timestamp }}"
            class="fixed top-4 right-4 z-50 max-w-sm animate-slide-in"
        >
            @if($type === 'success')
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-green-800">
                                {{ $message }}
                            </p>
                        </div>
                        <button
                            wire:click="close"
                            type="button"
                            class="ml-3 flex-shrink-0 text-green-500 hover:text-green-700 focus:outline-none transition cursor-pointer"
                        >
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
            @elseif($type === 'error')
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-red-800">
                                {{ $message }}
                            </p>
                        </div>
                        <button
                            wire:click="close"
                            type="button"
                            class="ml-3 flex-shrink-0 text-red-500 hover:text-red-700 focus:outline-none transition cursor-pointer"
                        >
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
            @elseif($type === 'warning')
                <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg shadow-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-yellow-800">
                                {{ $message }}
                            </p>
                        </div>
                        <button
                            wire:click="close"
                            type="button"
                            class="ml-3 flex-shrink-0 text-yellow-500 hover:text-yellow-700 focus:outline-none transition cursor-pointer"
                        >
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg shadow-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-blue-800">
                                {{ $message }}
                            </p>
                        </div>
                        <button
                            wire:click="close"
                            type="button"
                            class="ml-3 flex-shrink-0 text-blue-500 hover:text-blue-700 focus:outline-none transition cursor-pointer"
                        >
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <script>
            // Auto hide after 5 seconds
            setTimeout(() => {
                @this.call('close');
            }, 2000);
        </script>
    @endif
</div>
