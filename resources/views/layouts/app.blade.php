<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WUBA 58 City Models')</title>
    <meta name="description" content="@yield('description', 'Precision architectural models and 3D visualizations.')">

    @stack('styles') {{-- ◄── REQUIRED --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-charcoal-900 text-cream-100">

    {{-- Noise overlay --}}
    <div class="fixed inset-0 pointer-events-none z-[100] mix-blend-overlay opacity-60"
         style="background-image: url('/img/noise.svg');"></div>

    {{-- HEADER --}}
    <header x-data="{ scrolled: false, open: false }"
            @scroll.window="scrolled = window.scrollY > 40"
            :class="scrolled ? 'bg-charcoal-900/95 backdrop-blur-md border-b border-charcoal-700' : 'bg-transparent'"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="container-x flex items-center justify-between h-20 md:h-24">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('img/logo.jpg') }}" alt="WUBA 58 City Models" class="h-10 md:h-12 w-auto">
            </a>

            <nav class="hidden lg:flex items-center gap-5 text-sm uppercase tracking-widest">
                <a href="/work"     class="hover:text-gold-400 transition">Work</a>
                <a href="/services" class="hover:text-gold-400 transition">Services</a>
                <a href="/about"    class="hover:text-gold-400 transition">About</a>
                <a href="/process"  class="hover:text-gold-400 transition">Process</a>
                <a href="/contact"  class="hover:text-gold-400 transition">Contact</a>
            </nav>

            <a href="/contact" class="hidden lg:inline-flex btn-primary text-xs py-3 px-6">Start a Project</a>

            <button @click="open = !open" class="lg:hidden text-cream-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <div x-show="open" x-transition @click.outside="open = false"
             class="lg:hidden bg-charcoal-800 border-t border-charcoal-700">
            <div class="container-x py-6 flex flex-col gap-5 text-sm uppercase tracking-widest">
                <a href="/work"     class="hover:text-gold-400">Work</a>
                <a href="/services" class="hover:text-gold-400">Services</a>
                <a href="/about"    class="hover:text-gold-400">About</a>
                <a href="/process"  class="hover:text-gold-400">Process</a>
                <a href="/contact"  class="hover:text-gold-400">Contact</a>
                <a href="/contact" class="btn-primary text-xs justify-center">Start a Project</a>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-charcoal-900 border-t border-charcoal-700 pt-20 pb-10">
        <div class="container-x">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-2">
                    <div class="mb-4">
                        <img src="{{ asset('img/logo.jpg') }}" alt="WUBA 58 City Models" class="h-14 w-auto">
                    </div>
                    <p class="text-charcoal-200 max-w-md leading-relaxed">
                        Architectural Models · 3D Visualization · Development Presentation
                    </p>
                </div>
                <div>
                    <div class="section-label mb-5">Explore</div>
                    <ul class="space-y-3 text-charcoal-100">
                        <li><a href="/work"     class="hover:text-gold-400">Work</a></li>
                        <li><a href="/services" class="hover:text-gold-400">Services</a></li>
                        <li><a href="/about"    class="hover:text-gold-400">About</a></li>
                        <li><a href="/process"  class="hover:text-gold-400">Process</a></li>
                    </ul>
                </div>
                <div>
                    <div class="section-label mb-5">Contact</div>
                    <ul class="space-y-3 text-charcoal-100">
                        <li><a href="tel:{{ \App\Models\Setting::get('contact.phone') }}" class="hover:text-gold-400">
                            {{ \App\Models\Setting::get('contact.phone') }}
                        </a></li>
                        <li><a href="mailto:{{ \App\Models\Setting::get('contact.email') }}" class="hover:text-gold-400">
                            {{ \App\Models\Setting::get('contact.email') }}
                        </a></li>
                        <li><a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp')) }}" class="hover:text-gold-400">
                            WhatsApp
                        </a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-charcoal-700 flex flex-col md:flex-row justify-between text-sm text-charcoal-300 gap-4">
                <div>© {{ date('Y') }} WUBA 58 City Models. All rights reserved.</div>
                <div>Nairobi, Kenya</div>
            </div>
        </div>
    </footer>

    {{-- ═════════ REQUIRED: model-viewer library ═════════ --}}

    @stack('scripts') {{-- ◄── REQUIRED --}}
</body>
</html>