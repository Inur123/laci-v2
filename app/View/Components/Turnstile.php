<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Turnstile extends Component
{
    public string $theme;
    public string $size;
    public string $siteKey;

    public function __construct(
        string $theme = 'light',
        string $size = 'normal'
    ) {
        $this->theme = $theme;
        $this->size = $size;
        $this->siteKey = config('services.turnstile.site_key');
    }

    public function render(): View|Closure|string
    {
        return view('components.turnstile');
    }
}
