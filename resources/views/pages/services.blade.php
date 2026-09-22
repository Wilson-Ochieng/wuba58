@extends('layouts.app')

@section('title', 'Services — WUBA 58 City Models')
@section('description', 'Architectural models, real estate models, masterplan models, 3D visualization, illuminated models and custom model making.')

@section('content')

{{-- ═════════ PAGE HERO ═════════ --}}
<x-page-hero
    label="What We Create"
    title="Services"
    description="From physical scale models to photorealistic 3D visualizations — every service is built around making your development easier to understand, present, and sell."
/>

{{-- ═════════ SERVICE LIST ═════════ --}}
<x-section variant="dark">
    <x-section-heading
        label="Full Service Range"
        title="Models built to be experienced."
    />

    @if ($services->isEmpty())
        <div class="card-elegant p-12 text-center text-charcoal-300">
            No services published yet — add them in the admin.
        </div>
    @else
        <div class="grid md:grid-cols-2 gap-6 md:gap-8">
            @foreach ($services as $service)
                <article class="card-elegant p-8 md:p-10 group">
                    <div class="flex items-start justify-between gap-6 mb-6">
                        <div class="text-gradient-gold font-display text-4xl md:text-5xl leading-none">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        @if ($service->icon)
                            <div class="text-gold-500 opacity-60 group-hover:opacity-100 transition-opacity">
                                {{-- Heroicon name from admin, if set --}}
                            </div>
                        @endif
                    </div>

                    <h3 class="text-2xl font-display tracking-tightest text-cream-100 mb-4 uppercase group-hover:text-gold-400 transition-colors">
                        {{ $service->title }}
                    </h3>

                    @if ($service->description)
                        <p class="text-charcoal-200 leading-relaxed">
                            {{ $service->description }}
                        </p>
                    @endif

                    @if ($service->hasMedia('image'))
                        <div class="mt-6 aspect-[16/9] overflow-hidden bg-charcoal-800">
                            <img src="{{ $service->getFirstMediaUrl('image') }}"
                                 alt="{{ $service->title }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
</x-section>

{{-- ═════════ PROCESS RECAP ═════════ --}}
@if ($process->isNotEmpty())
    <x-section padding="lg">
        <x-section-heading
            label="How It Works"
            title="From drawing to model."
            size="xl"
        />

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-6">
            @foreach ($process as $step)
                <div class="relative">
                    <div class="text-gradient-ember font-display text-5xl mb-4">
                        {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="w-12 h-px mb-4" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                    <h3 class="text-lg font-display tracking-tightest text-cream-100 mb-3 uppercase">
                        {{ $step->title }}
                    </h3>
                    <p class="text-charcoal-200 text-sm leading-relaxed">{{ $step->description }}</p>
                </div>
            @endforeach
        </div>
    </x-section>
@endif

{{-- ═════════ WHY WUBA ═════════ --}}
<x-section variant="dark">
    <x-section-heading
        label="The WUBA Difference"
        title="What sets our work apart."
    />

    <div class="grid md:grid-cols-3 gap-8">
        <div class="card-elegant p-8">
            <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
            <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">
                Made in Kenya
            </h3>
            <p class="text-charcoal-200 text-sm leading-relaxed">
                Built locally, delivered locally. No import delays, no currency surprises.
            </p>
        </div>

        <div class="card-elegant p-8">
            <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
            <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">
                Digital + Physical
            </h3>
            <p class="text-charcoal-200 text-sm leading-relaxed">
                A single team producing both the physical model and the 3D visualization — consistent, fast, cohesive.
            </p>
        </div>

        <div class="card-elegant p-8">
            <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
            <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">
                Presentation Ready
            </h3>
            <p class="text-charcoal-200 text-sm leading-relaxed">
                Everything we deliver is built for sales galleries, exhibitions, and investor presentations.
            </p>
        </div>
    </div>
</x-section>

{{-- ═════════ CTA ═════════ --}}
<x-cta-section />

@endsection