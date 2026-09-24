@extends('layouts.app')

@section('title', 'Process — Wuba 58 City Models')
@section('description', 'From drawing to model — how Wuba 58 transforms architectural plans into physical scale models and 3D visualizations.')

@section('content')

    {{-- ═════════ HERO ═════════ --}}
    <section class="relative pt-48 pb-20 md:pt-56 md:pb-28 overflow-hidden">
        <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);"></div>
        <div class="absolute inset-0 glow-hero opacity-70"></div>

        <div class="relative container-x">
            <div class="section-label mb-6">The Wuba Experience</div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-display tracking-tightest text-cream-100 max-w-5xl leading-[1.05] text-balance">
                From drawing<br>to model.
            </h1>
            <p class="mt-8 max-w-2xl text-lg md:text-xl text-charcoal-200 leading-relaxed">
                A clear, transparent process — designed so you always know exactly where your project is and what happens next.
            </p>
        </div>
    </section>

    {{-- ═════════ TIMELINE ═════════ --}}
    <x-section variant="dark" padding="lg">
        @if ($process->isEmpty())
            <div class="card-elegant p-12 text-center text-charcoal-300">
                No process steps yet — add them in the admin.
            </div>
        @else
            <div class="space-y-24 md:space-y-32">
                @foreach ($process as $step)
                    <div class="grid md:grid-cols-12 gap-8 md:gap-12 items-start relative">
                        {{-- Number + connector line --}}
                        <div class="md:col-span-3 relative">
                            <div class="text-gradient-ember font-display text-7xl md:text-8xl leading-none mb-4">
                                {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                            </div>

                            @if (!$loop->last)
                                {{-- Vertical connector (visible on desktop) --}}
                                <div class="hidden md:block absolute left-16 top-32 w-px h-32"
                                     style="background: linear-gradient(180deg, rgba(236,177,67,0.5), transparent);"></div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="md:col-span-9 md:pt-4">
                            <h2 class="text-2xl md:text-4xl font-display tracking-tightest text-cream-100 mb-6 uppercase">
                                {{ $step->title }}
                            </h2>
                            <div class="w-16 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                            <p class="text-charcoal-200 text-lg leading-relaxed max-w-2xl">
                                {{ $step->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-section>

    {{-- ═════════ WHAT WE NEED FROM YOU ═════════ --}}
    <x-section padding="lg">
        <x-section-heading
            label="What We Need"
            title="To get started."
            size="xl"
        />

        <div class="grid md:grid-cols-2 gap-6 md:gap-8 max-w-4xl">
            <div class="card-elegant p-8">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">Drawings</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    CAD files (.dwg, .dxf), PDFs, elevations, site plans, or architectural sketches.
                </p>
            </div>

            <div class="card-elegant p-8">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">Visual References</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Renders, mood boards, material samples, or previous models for style alignment.
                </p>
            </div>

            <div class="card-elegant p-8">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">Site Information</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Location, orientation, landmarks, and any landscaping details you want represented.
                </p>
            </div>

            <div class="card-elegant p-8">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">Purpose</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Sales gallery, investor presentation, exhibition, or planning approval — it shapes the outcome.
                </p>
            </div>
        </div>
    </x-section>

    {{-- ═════════ WHAT WE CREATE ═════════ --}}
    @if ($services->isNotEmpty())
        <x-section variant="dark">
            <x-section-heading
                label="Where It Leads"
                title="Models built to be experienced."
            />

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $s)
                    <x-service-card :service="$s" :index="$loop->iteration" />
                @endforeach
            </div>
        </x-section>
    @endif

    {{-- ═════════ CTA ═════════ --}}
    <x-cta-section />

@endsection