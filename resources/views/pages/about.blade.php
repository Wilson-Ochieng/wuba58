@extends('layouts.app')

@section('title', 'About — Wuba 58 City Models')
@section('description', '18 years of meticulous craftsmanship. Headquartered in Shenzhen, with branches in Nanchang and Nairobi. 3,000+ projects delivered worldwide.')

@section('content')

    {{-- ═════════ HERO ═════════ --}}
    <section class="relative pt-48 pb-20 md:pt-56 md:pb-28 overflow-hidden">
        <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);"></div>
        <div class="absolute inset-0 glow-hero opacity-70"></div>

        <div class="relative container-x">
            <div class="section-label mb-6">About Wuba 58</div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-display tracking-tightest text-cream-100 max-w-5xl leading-[1.05] text-balance">
                18 years of <span class="text-gradient-ember">meticulous craftsmanship.</span>
            </h1>
            <p class="mt-8 max-w-3xl text-lg md:text-xl text-charcoal-200 leading-relaxed">
                Wuba 58 City Models is a tier-1 architectural model maker headquartered in Shenzhen, China, with branches in Nanchang and Nairobi. We combine precision physical model-making with 3D visualization and development presentation — helping developers, architects, and investors communicate their vision with clarity and confidence.
            </p>
        </div>
    </section>

    {{-- ═════════ KEY FACTS ═════════ --}}
    <x-section variant="dark">
        <x-section-heading label="By the Numbers" title="Built over nearly two decades." />

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <div class="card-elegant p-8">
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-4">18</div>
                <h3 class="text-cream-100 font-display tracking-tightest uppercase mb-2 text-sm">Years of Craftsmanship</h3>
                <p class="text-charcoal-300 text-sm leading-relaxed">Meticulous model-making experience.</p>
            </div>

            <div class="card-elegant p-8">
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-4">3K+</div>
                <h3 class="text-cream-100 font-display tracking-tightest uppercase mb-2 text-sm">Projects Completed</h3>
                <p class="text-charcoal-300 text-sm leading-relaxed">Delivered globally.</p>
            </div>

            <div class="card-elegant p-8">
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-4">3</div>
                <h3 class="text-cream-100 font-display tracking-tightest uppercase mb-2 text-sm">Global Studios</h3>
                <p class="text-charcoal-300 text-sm leading-relaxed">Shenzhen · Nanchang · Nairobi</p>
            </div>

            <div class="card-elegant p-8">
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-4">100s</div>
                <h3 class="text-cream-100 font-display tracking-tightest uppercase mb-2 text-sm">Developer Partners</h3>
                <p class="text-charcoal-300 text-sm leading-relaxed">Strategic partnerships worldwide.</p>
            </div>
        </div>
    </x-section>

    {{-- ═════════ STORY / POSITIONING ═════════ --}}
    <x-section padding="lg">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <div>
                <x-section-heading
                    label="Our Story"
                    title="From Shenzhen to Nairobi."
                    size="lg"
                    maxWidth="max-w-none"
                />

                <div class="space-y-6 text-charcoal-200 leading-relaxed">
                    <p>
                        Wuba 58 City Models was founded on a simple idea: a physical model makes an architectural vision real in a way that drawings and screens simply cannot. Over 18 years, we've refined that idea into a craft — combining traditional model-making techniques with modern CNC equipment, lighting design, and digital visualization.
                    </p>
                    <p>
                        From our headquarters in Shenzhen, we've delivered more than 3,000 projects across China, Africa, and beyond. Our Nairobi branch brings that same tier-1 capability directly to East African developers, architects, and investors — with local turnaround and local accountability.
                    </p>
                    <p>
                        Today we serve property developers, real estate marketers, urban planners, government institutions, and engineering firms with a single integrated studio: physical models, 3D visualization, and development presentation under one roof.
                    </p>
                </div>
            </div>

            {{-- Highlights --}}
            <div class="grid gap-6">
                <div class="card-elegant p-8">
                    <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                    <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">
                        Tier-1 Industry Brand
                    </h3>
                    <p class="text-charcoal-200 text-sm leading-relaxed">
                        Recognized across the industry for cutting-edge production capabilities and consistent quality at scale.
                    </p>
                </div>

                <div class="card-elegant p-8">
                    <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                    <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">
                        Integrated Design Team
                    </h3>
                    <p class="text-charcoal-200 text-sm leading-relaxed">
                        Specialists in architectural design, landscape design, and lighting design working under one roof.
                    </p>
                </div>

                <div class="card-elegant p-8">
                    <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                    <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">
                        Precision Equipment
                    </h3>
                    <p class="text-charcoal-200 text-sm leading-relaxed">
                        30+ precision CNC carving machines, 3D engravers, laser cutters, and 8 water-circulation spray-painting systems.
                    </p>
                </div>

                <div class="card-elegant p-8">
                    <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                    <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">
                        Expert Lighting Programmers
                    </h3>
                    <p class="text-charcoal-200 text-sm leading-relaxed">
                        Custom light-and-sound effects designed and coded for every illuminated model we deliver.
                    </p>
                </div>
            </div>
        </div>
    </x-section>

    {{-- ═════════ WHO WE SERVE ═════════ --}}
    <x-section variant="dark">
        <x-section-heading
            label="Who We Work With"
            title="Trusted by teams shaping the built environment."
            align="center"
            maxWidth="max-w-3xl"
        />

        @php
            $clients = [
                'Architects',
                'Property Developers',
                'Real Estate Marketers',
                'Construction Companies',
                'Government & Institutions',
                'Urban Planners',
                'Engineering Firms',
            ];
        @endphp

        <div class="flex flex-wrap justify-center gap-3 md:gap-4">
            @foreach ($clients as $client)
                <div class="px-5 py-3 text-charcoal-100 text-xs md:text-sm uppercase tracking-widest transition-all duration-300 hover:text-gold-400"
                     style="border: 1px solid rgba(239, 201, 103, 0.15);"
                     onmouseover="this.style.borderColor='rgba(236,177,67,0.6)'; this.style.boxShadow='0 0 24px -6px rgba(236,177,67,0.4)';"
                     onmouseout="this.style.borderColor='rgba(239,201,103,0.15)'; this.style.boxShadow='none';">
                    {{ $client }}
                </div>
            @endforeach
        </div>
    </x-section>

    {{-- ═════════ LONG-TERM PARTNERS ═════════ --}}
    <x-section padding="lg">
        <x-section-heading
            label="Long-Term Partners"
            title="Trusted by developers worldwide."
            align="center"
            maxWidth="max-w-3xl"
        />

        @php
            $partnersRaw = \App\Models\Setting::get('about.partners', '');
            $partners = collect(explode('|', $partnersRaw))
                ->map(fn($p) => trim($p))
                ->filter()
                ->values();
        @endphp

        @if ($partners->isNotEmpty())
            <div class="flex flex-wrap justify-center gap-x-10 gap-y-6 max-w-5xl mx-auto">
                @foreach ($partners as $partner)
                    <div class="text-charcoal-200 uppercase tracking-widest text-sm md:text-base font-medium hover:text-gold-400 transition-colors">
                        {{ $partner }}
                    </div>
                @endforeach
            </div>

            <p class="text-center text-charcoal-400 text-xs uppercase tracking-widest mt-12">
                And hundreds of others across Asia, Africa, the Middle East, and Europe
            </p>
        @endif
    </x-section>

    {{-- ═════════ GLOBAL PRESENCE ═════════ --}}
    <x-section variant="dark">
        <x-section-heading
            label="Global Studios"
            title="Three cities. One standard."
            align="center"
            maxWidth="max-w-3xl"
        />

        <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <div class="card-elegant p-8 text-center">
                <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-3">
                    Shenzhen
                </div>
                <div class="text-charcoal-300 text-xs uppercase tracking-widest mb-4">
                    Headquarters
                </div>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Our founding studio. Where the design team, engineering, and production facilities operate at full scale.
                </p>
            </div>

            <div class="card-elegant p-8 text-center">
                <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-3">
                    Nanchang
                </div>
                <div class="text-charcoal-300 text-xs uppercase tracking-widest mb-4">
                    Branch
                </div>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Regional production hub supporting ongoing project demand across China and Southeast Asia.
                </p>
            </div>

            <div class="card-elegant p-8 text-center">
                <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-3">
                    Nairobi
                </div>
                <div class="text-charcoal-300 text-xs uppercase tracking-widest mb-4">
                    East Africa
                </div>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Our East African branch — bringing tier-1 model-making capability directly to the region.
                </p>
            </div>
        </div>
    </x-section>

    {{-- ═════════ CTA ═════════ --}}
    <x-cta-section />

@endsection