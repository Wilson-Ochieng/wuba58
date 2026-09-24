<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wuba 58 City Models')</title>
    <meta name="description" content="@yield('description', 'Precision architectural models and 3D visualizations.')">

    {{-- Favicon --}}
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.jpg') }}">

    {{-- Open Graph / Social sharing --}}
    <meta property="og:title" content="@yield('title', 'Wuba 58 City Models')">
    <meta property="og:description" content="@yield('description', 'Precision architectural models and 3D visualizations.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('img/logo.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Wuba 58 City Models')">
    <meta name="twitter:description" content="@yield('description', 'Precision architectural models and 3D visualizations.')">
    <meta name="twitter:image" content="{{ asset('img/logo.jpg') }}">

    @stack('styles')
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

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-3 shrink-0">
            <img src="{{ asset('img/logo.jpg') }}" alt="Wuba 58 City Models" class="h-10 md:h-12 w-auto">
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden lg:flex items-center gap-5 text-sm uppercase tracking-widest">

            {{-- Work dropdown --}}
            <div
                x-data="{
                    open: false,
                    timer: null,
                    show() { clearTimeout(this.timer); this.open = true; },
                    hide() { this.timer = setTimeout(() => { this.open = false; }, 200); }
                }"
                @mouseenter="show()"
                @mouseleave="hide()"
                @click.outside="open = false"
                class="relative"
            >
                <button
                    @click="open = !open"
                    type="button"
                    class="flex items-center gap-1.5 py-2 hover:text-gold-400 transition"
                    :class="open ? 'text-gold-400' : ''"
                >
                    Work
                    <svg class="w-3 h-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Invisible bridge --}}
                <div x-show="open" x-cloak class="absolute left-0 right-0 top-full h-4"></div>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    x-cloak
                    class="absolute left-0 top-full mt-4 min-w-[220px] py-2 z-50"
                    style="background: rgba(22,21,21,0.98); border: 1px solid rgba(236,177,67,0.15); backdrop-filter: blur(12px); box-shadow: 0 20px 40px -20px rgba(0,0,0,0.8);"
                >
                    <a href="/work" class="block px-5 py-3 hover:bg-charcoal-800 transition-colors text-cream-100 hover:text-gold-400 text-xs uppercase tracking-widest font-semibold whitespace-nowrap">
                        Portfolio
                    </a>
                    <a href="/work/physical-models" class="block px-5 py-3 hover:bg-charcoal-800 transition-colors text-cream-100 hover:text-gold-400 text-xs uppercase tracking-widest font-semibold whitespace-nowrap">
                        3D Physical Models
                    </a>
                    <a href="/work/360-tour" class="block px-5 py-3 hover:bg-charcoal-800 transition-colors text-cream-100 hover:text-gold-400 text-xs uppercase tracking-widest font-semibold whitespace-nowrap">
                        360° Virtual Tour
                    </a>
                </div>
            </div>

            <a href="/services" class="hover:text-gold-400 transition">Services</a>
            <a href="/about"    class="hover:text-gold-400 transition">About</a>
            <a href="/process"  class="hover:text-gold-400 transition">Process</a>
            <a href="/contact"  class="hover:text-gold-400 transition">Contact</a>
        </nav>

        {{-- Desktop CTA --}}
        <a href="/contact" class="hidden lg:inline-flex btn-primary text-xs py-3 px-6 shrink-0">
            Start a Project
        </a>

        {{-- Mobile hamburger --}}
        <button
            @click="open = !open"
            type="button"
            class="lg:hidden flex items-center justify-center w-11 h-11 -mr-2 text-cream-100 hover:text-gold-400 transition-colors"
            aria-label="Toggle menu"
            :aria-expanded="open"
        >
            {{-- Hamburger icon (visible when closed) --}}
            <svg x-show="!open" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

            {{-- Close (X) icon (visible when open) --}}
            <svg x-show="open" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="lg:hidden bg-charcoal-800 border-t border-charcoal-700">
        <div class="container-x py-6 flex flex-col gap-4 text-sm uppercase tracking-widest">
            <a href="/work" class="hover:text-gold-400 transition py-1">Work — Portfolio</a>
            <a href="/work/physical-models" class="hover:text-gold-400 transition py-1 pl-4 text-charcoal-300 text-xs">3D Physical Models</a>
            <a href="/work/360-tour" class="hover:text-gold-400 transition py-1 pl-4 text-charcoal-300 text-xs">360° Virtual Tour</a>
            <div class="h-px my-1" style="background: linear-gradient(90deg, transparent, rgba(236,177,67,0.3), transparent);"></div>
            <a href="/services" class="hover:text-gold-400 transition py-1">Services</a>
            <a href="/about"    class="hover:text-gold-400 transition py-1">About</a>
            <a href="/process"  class="hover:text-gold-400 transition py-1">Process</a>
            <a href="/contact"  class="hover:text-gold-400 transition py-1">Contact</a>
            <a href="/contact" class="btn-primary text-xs justify-center mt-3">Start a Project</a>
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
                        <img src="{{ asset('img/logo.jpg') }}" alt="Wuba 58 City Models" class="h-14 w-auto">
                    </div>
                    <p class="text-charcoal-200 max-w-md leading-relaxed">
                        {{ \App\Models\Setting::get('site.positioning', 'Architectural Models · 3D Visualization · Development Presentation') }}
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
                    <ul class="space-y-3 text-charcoal-100 text-sm">
                        @if (\App\Models\Setting::get('contact.phone'))
                            <li>
                                <a href="tel:{{ \App\Models\Setting::get('contact.phone') }}" class="hover:text-gold-400">
                                    {{ \App\Models\Setting::get('contact.phone') }}
                                </a>
                            </li>
                        @endif
                        @if (\App\Models\Setting::get('contact.phone_2'))
                            <li>
                                <a href="tel:{{ \App\Models\Setting::get('contact.phone_2') }}" class="hover:text-gold-400">
                                    {{ \App\Models\Setting::get('contact.phone_2') }}
                                </a>
                            </li>
                        @endif
                        @if (\App\Models\Setting::get('contact.phone_3'))
                            <li>
                                <a href="tel:{{ \App\Models\Setting::get('contact.phone_3') }}" class="hover:text-gold-400">
                                    {{ \App\Models\Setting::get('contact.phone_3') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="mailto:{{ \App\Models\Setting::get('contact.email') }}" class="hover:text-gold-400 break-all">
                                {{ \App\Models\Setting::get('contact.email') }}
                            </a>
                        </li>
                        <li class="pt-3 text-charcoal-300">
                            {!! nl2br(e(\App\Models\Setting::get('contact.address_physical', ''))) !!}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-charcoal-700 flex flex-col md:flex-row justify-between text-sm text-charcoal-300 gap-6">
                <div>© {{ date('Y') }} Wuba 58 City Models. All rights reserved.</div>
                <div class="flex gap-5">
                    @if (\App\Models\Setting::get('social.instagram'))
                        <a href="{{ \App\Models\Setting::get('social.instagram') }}" target="_blank" rel="noopener" class="hover:text-gold-400">Instagram</a>
                    @endif
                    @if (\App\Models\Setting::get('social.facebook'))
                        <a href="{{ \App\Models\Setting::get('social.facebook') }}" target="_blank" rel="noopener" class="hover:text-gold-400">Facebook</a>
                    @endif
                    @if (\App\Models\Setting::get('social.tiktok'))
                        <a href="{{ \App\Models\Setting::get('social.tiktok') }}" target="_blank" rel="noopener" class="hover:text-gold-400">TikTok</a>
                    @endif
                    @if (\App\Models\Setting::get('social.youtube'))
                        <a href="{{ \App\Models\Setting::get('social.youtube') }}" target="_blank" rel="noopener" class="hover:text-gold-400">YouTube</a>
                    @endif
                    @if (\App\Models\Setting::get('social.linkedin'))
                        <a href="{{ \App\Models\Setting::get('social.linkedin') }}" target="_blank" rel="noopener" class="hover:text-gold-400">LinkedIn</a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    {{-- WhatsApp floating button --}}
    @php
        $whatsapp = preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', ''));
    @endphp
    @if ($whatsapp)
        <a href="https://wa.me/{{ $whatsapp }}"
           target="_blank"
           rel="noopener"
           aria-label="Chat on WhatsApp"
           class="fixed bottom-6 right-6 z-40 w-14 h-14 flex items-center justify-center rounded-full transition-transform hover:scale-110"
           style="background: linear-gradient(135deg, #EFC967 0%, #E48633 100%); box-shadow: 0 8px 24px -6px rgba(236,177,67,0.6);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#161515" class="w-7 h-7">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        </a>
    @endif

    @stack('scripts')
</body>
</html>