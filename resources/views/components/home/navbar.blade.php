<header class="sticky top-0 z-50 border-b border-slate-200/60 bg-white/75 backdrop-blur" x-data="{
    open: false,
    active: 'home',
    offset: 110,

    lockScroll() { document.body.classList.add('overflow-hidden'); },
    unlockScroll() { document.body.classList.remove('overflow-hidden'); },

    openMenu() {
        if (this.open) return;
        this.open = true;
        this.lockScroll();
    },
    closeMenu() {
        if (!this.open) return;
        this.open = false;
        setTimeout(() => this.unlockScroll(), 200);
    },
    toggleMenu() { this.open ? this.closeMenu() : this.openMenu(); },

    setActive(id) { this.active = id; },

    atBottom() {
        return (window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 4);
    },

    getSections() {
        return ['home', 'fitur', 'resources', 'kontak']
            .map(id => document.getElementById(id))
            .filter(Boolean);
    },

    calcActive() {
        const sections = this.getSections();
        if (!sections.length) return 'home';

        // FIX: mentok bawah -> paksa kontak aktif
        if (this.atBottom()) return sections[sections.length - 1].id;

        const y = window.scrollY + this.offset;
        let current = sections[0].id;

        for (const sec of sections) {
            if (sec.offsetTop <= y) current = sec.id;
        }
        return current;
    },

    updateActive() { this.active = this.calcActive(); },

    goTo(id, isMobile = false) {
        this.setActive(id);

        const doScroll = () => {
            const target = document.getElementById(id);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.replaceState(null, '', `#${id}`);
            }
        };

        if (isMobile) {
            this.closeMenu();
            setTimeout(doScroll, 210);
        } else {
            doScroll();
        }
    },

    linkBase() {
        return 'rounded-xl px-3 py-2 text-sm font-semibold transition';
    },
    linkActive() {
        return 'bg-brand-50 text-brand-800 ring-1 ring-brand-200';
    },
    linkIdleDesktop() {
        return 'text-slate-600 hover:bg-slate-100';
    },
    linkIdleMobile() {
        return 'text-slate-700 hover:bg-slate-100';
    },

    init() {
        const hash = (window.location.hash || '').replace('#', '');
        if (hash && document.getElementById(hash)) this.active = hash;
        else this.updateActive();

        window.addEventListener('scroll', () => this.updateActive(), { passive: true });
        window.addEventListener('resize', () => this.updateActive(), { passive: true });
    }
}"
    x-init="init()" @keydown.window.escape="closeMenu()">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
        {{-- Logo --}}
        <a href="#home" class="flex items-center gap-3" @click.prevent="goTo('home', false)">
            <img src="{{ asset('images/logo-laci-new.webp') }}" alt="Laci Digital"
                class="h-10 w-10 rounded-xl object-contain shadow-soft" />

            <div class="leading-tight">
                <p class="text-sm font-semibold">Laci Digital</p>
                <p class="text-xs text-slate-500">PC IPNU IPPNU Magetan</p>
            </div>
        </a>


        {{-- Desktop menu --}}
        <div class="hidden items-center gap-1 md:flex">
            <a href="#home" @click.prevent="goTo('home', false)"
                :class="[linkBase(), active==='home' ? linkActive() : linkIdleDesktop()]">Home</a>

            <a href="#fitur" @click.prevent="goTo('fitur', false)"
                :class="[linkBase(), active==='fitur' ? linkActive() : linkIdleDesktop()]">Fitur</a>

            <a href="#resources" @click.prevent="goTo('resources', false)"
                :class="[linkBase(), active==='resources' ? linkActive() : linkIdleDesktop()]">Resources</a>

            <a href="#kontak" @click.prevent="goTo('kontak', false)"
                :class="[linkBase(), active==='kontak' ? linkActive() : linkIdleDesktop()]">Kontak</a>
        </div>

        {{-- Desktop auth buttons (ini yang kamu minta: pakai route login/register) --}}
        <div class="hidden items-center gap-2 md:flex">
            @auth
                <a href="{{ route('dashboard') }}" wire:navigate
                    class="rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-soft hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-300">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" wire:navigate
                    class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    Login
                </a>
                <a href="{{ route('register') }}" wire:navigate
                    class="rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-soft hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-300">
                    Daftar
                </a>
            @endauth
        </div>

        {{-- Mobile hamburger --}}
        <button class="md:hidden rounded-xl p-2 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-200"
            aria-label="Buka menu" :aria-expanded="open ? 'true' : 'false'" @click="toggleMenu()">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </nav>

    {{-- Mobile Overlay --}}
    <div class="fixed inset-0 z-[60]" x-show="open" x-cloak role="dialog" aria-modal="true"
        aria-labelledby="mobileMenuTitle">
        <div class="absolute inset-0 bg-slate-900/40" @click="closeMenu()" x-transition.opacity></div>

        <div class="absolute left-0 right-0 top-0 px-4 pt-3 sm:px-6">
            <div class="mx-auto max-w-7xl" x-transition:enter="transition duration-200 ease-out"
                x-transition:enter-start="-translate-y-3 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition duration-200 ease-in"
                x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="-translate-y-3 opacity-0">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-soft">
                    <div class="flex items-center justify-between px-4 py-3 sm:px-5">
                        <p id="mobileMenuTitle" class="text-sm font-semibold text-slate-900">Menu</p>
                        <button
                            class="rounded-xl p-2 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-200"
                            aria-label="Tutup menu" @click="closeMenu()">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-4 pb-4 sm:px-5 sm:pb-5">
                        <div class="grid gap-1">
                            <a href="#home" @click.prevent="goTo('home', true)"
                                :class="[linkBase(), active==='home' ? linkActive() : linkIdleMobile()]">Home</a>

                            <a href="#fitur" @click.prevent="goTo('fitur', true)"
                                :class="[linkBase(), active==='fitur' ? linkActive() : linkIdleMobile()]">Fitur</a>

                            <a href="#resources" @click.prevent="goTo('resources', true)"
                                :class="[linkBase(), active==='resources' ? linkActive() : linkIdleMobile()]">Resources</a>

                            <a href="#kontak" @click.prevent="goTo('kontak', true)"
                                :class="[linkBase(), active==='kontak' ? linkActive() : linkIdleMobile()]">Kontak</a>
                        </div>

                        {{-- Mobile auth buttons --}}
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            @auth
                                <a href="{{ route('dashboard') }}" wire:navigate @click="closeMenu()"
                                    class="col-span-2 rounded-xl bg-brand-600 px-4 py-2 text-center text-sm font-semibold text-white shadow-soft hover:bg-brand-700">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" wire:navigate @click="closeMenu()"
                                    class="rounded-xl border border-slate-200 px-4 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" wire:navigate @click="closeMenu()"
                                    class="rounded-xl bg-brand-600 px-4 py-2 text-center text-sm font-semibold text-white shadow-soft hover:bg-brand-700">
                                    Daftar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
