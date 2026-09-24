@extends('layouts.app')

@section('title', '360° Virtual Tour — Wuba 58 City Models')
@section('description', 'Step inside our Nairobi factory with a full 360° interactive tour — walk through every stage of physical model-making.')

@section('content')

    {{-- ═════════ HERO ═════════ --}}
    <section class="relative pt-48 pb-16 md:pt-56 md:pb-20 overflow-hidden">
        <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);"></div>
        <div class="absolute inset-0 glow-hero opacity-70"></div>

        <div class="relative container-x">
            <div class="section-label mb-6">Virtual Experience</div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-display tracking-tightest text-cream-100 max-w-5xl leading-[1.05] text-balance">
                360° Tour
            </h1>
            <p class="mt-8 max-w-2xl text-lg md:text-xl text-charcoal-200 leading-relaxed">
                Step inside our Nairobi factory and walk through every stage of physical model-making — from design studio to CNC machines to the finished showroom.
            </p>
        </div>
    </section>

    {{-- ═════════ TOUR VIEWER ═════════ --}}
    <section class="pb-20">
        <div class="container-x">
            @if ($startScene && $startScene->hasMedia('panorama'))
                <x-tour-viewer :scenes="$scenes" :start-scene="$startScene" />
            @else
                <div class="card-elegant p-12 md:p-16 text-center max-w-3xl mx-auto">
                    <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-4">
                        Coming Soon
                    </div>
                    <p class="text-charcoal-200 leading-relaxed mb-6">
                        The 360° tour is being prepared. Check back shortly, or explore our physical models and portfolio in the meantime.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <x-btn href="/work/physical-models" variant="primary">See 3D Models</x-btn>
                        <x-btn href="/work" variant="outline">View Portfolio</x-btn>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- ═════════ WHAT YOU'LL SEE ═════════ --}}
    @if ($scenes->isNotEmpty())
        <x-section variant="dark">
            <x-section-heading
                label="In This Tour"
                title="The stops."
                align="center"
                maxWidth="max-w-2xl"
            />

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
                @foreach ($scenes as $scene)
                    <div class="card-elegant p-6">
                        <div class="text-gradient-gold font-display text-sm tracking-widest uppercase mb-2">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} · Stop
                        </div>
                        <h3 class="font-display tracking-tightest text-cream-100 text-lg uppercase mb-2">
                            {{ $scene->name }}
                        </h3>
                        @if ($scene->description)
                            <p class="text-charcoal-300 text-sm leading-relaxed">
                                {{ $scene->description }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-section>
    @endif

    {{-- ═════════ CTA ═════════ --}}
    <x-cta-section />

@endsection