{{-- filepath: resources/views/components/turnstile.blade.php --}}
<div wire:ignore>
    <input type="hidden" id="recaptcha-token" wire:model="captcha">
</div>

@once
@push('scripts')
<script src="https://www.google.com/recaptcha/api.js?render={{ $siteKey }}"></script>
<script>
    function executeRecaptcha() {
        if (typeof grecaptcha === 'undefined') {
            setTimeout(executeRecaptcha, 100);
            return;
        }
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ $siteKey }}', {action: 'submit'}).then(function(token) {
                // Cari wire:id terdekat dari input
                const input = document.getElementById('recaptcha-token');
                const livewireEl = input.closest('[wire\\:id]');
                if (livewireEl) {
                    const componentId = livewireEl.getAttribute('wire:id');
                    const component = window.Livewire?.find(componentId);
                    if (component) {
                        component.set('captcha', token);
                    }
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', executeRecaptcha);
    document.addEventListener('livewire:navigated', () => {
        setTimeout(executeRecaptcha, 100);
    });
    window.Livewire && window.Livewire.on('reset-captcha', () => {
        executeRecaptcha();
    });
</script>
@endpush
@endonce
