<div wire:ignore>
    <div
        class="cf-turnstile"
        data-sitekey="{{ $siteKey }}"
        data-theme="{{ $theme }}"
        data-size="{{ $size }}"
        data-callback="onTurnstileCallback"
        {{ $attributes }}
    ></div>
</div>

@once
@push('scripts')
<script>
    let turnstileWidgetIds = new Map();

    function onTurnstileCallback(token) {
        // Cari wire:id terdekat dari turnstile element
        const turnstileEl = document.querySelector('.cf-turnstile');
        if (!turnstileEl) return;

        const livewireEl = turnstileEl.closest('[wire\\:id]');

        if (livewireEl) {
            const componentId = livewireEl.getAttribute('wire:id');
            const component = window.Livewire?.find(componentId);

            if (component) {
                component.set('captcha', token);
            }
        }
    }

    function renderTurnstile() {
        if (typeof turnstile === 'undefined') {
            console.log('Turnstile not loaded yet, retrying...');
            setTimeout(renderTurnstile, 100);
            return;
        }

        const widgets = document.querySelectorAll('.cf-turnstile');

        widgets.forEach((widget) => {
            // Skip jika sudah di-render
            if (widget.children.length > 0) {
                return;
            }

            try {
                const widgetId = turnstile.render(widget, {
                    sitekey: widget.getAttribute('data-sitekey'),
                    theme: widget.getAttribute('data-theme') || 'light',
                    size: widget.getAttribute('data-size') || 'normal',
                    callback: onTurnstileCallback,
                });

                turnstileWidgetIds.set(widget, widgetId);
                console.log('Turnstile rendered:', widgetId);
            } catch (error) {
                console.error('Error rendering Turnstile:', error);
            }
        });
    }

    // Initial render saat halaman load
    document.addEventListener('DOMContentLoaded', renderTurnstile);

    // Render ulang setelah Livewire navigation (untuk SPA)
    document.addEventListener('livewire:navigated', () => {
        console.log('Livewire navigated, re-rendering Turnstile...');
        setTimeout(renderTurnstile, 100);
    });

    // Listen untuk reset captcha event
    document.addEventListener('livewire:init', () => {
        window.Livewire.on('reset-captcha', () => {
            if (typeof turnstile !== 'undefined') {
                const widgets = document.querySelectorAll('.cf-turnstile');
                widgets.forEach((widget) => {
                    const widgetId = turnstileWidgetIds.get(widget);
                    if (widgetId !== undefined) {
                        try {
                            turnstile.reset(widgetId);
                            console.log('Turnstile reset:', widgetId);
                        } catch (error) {
                            console.error('Error resetting Turnstile:', error);
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
@endonce
