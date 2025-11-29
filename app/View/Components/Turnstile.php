<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Turnstile extends Component
{
    public string $siteKey;

    public function __construct()
    {
        $this->siteKey = config('services.recaptcha.site_key');
    }

    public function render(): View|Closure|string
    {
        return view('components.turnstile');
    }
}
