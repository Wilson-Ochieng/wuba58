@extends('layouts.app')

@section('title', 'WUBA 58 City Models — Architectural Models & 3D Visualization')
@section('description', 'Precision architectural models and 3D visualizations that bring developments to life.')

@section('content')

{{-- ═════════ HERO ═════════ --}}
<section class="relative min-h-screen flex items-end overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #2a1a0f 45%, #161515 100%);"></div>
    <div class="absolute inset-0 glow-hero"></div>

    <div class="relative container-x pb-16 md:pb-24 pt-32 w-full">
        <h1 data-reveal="up" class="text-4xl xs:text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-display tracking-tightest text-cream-100 max-w-5xl leading-[0.95] text-balance">
            WE TURN ARCHITECTURE<br>
            INTO <span class="text-gradient-ember">SOMETHING YOU CAN SEE.</span>
        </h1>
        <p data-reveal="up" data-reveal-delay="200" class="mt-8 max-w-xl text-charcoal-200 text-lg leading-relaxed">
            {{ $hero['subtext'] }}
        </p>
        <div data-reveal="up" data-reveal-delay="400" class="mt-10 flex flex-col sm:flex-row gap-4">
            <x-btn href="/work" variant="primary">Explore Our Work</x-btn>
            <x-btn href="/contact" variant="outline">Start a Project</x-btn>
        </div>
    </div>
</section>

{{-- 01 — Introduction --}}
<x-section>
    <x-section-heading label="01 — Introduction" title="See the city before it's built." size="xl">
        {{ \App\Models\Setting::get('intro.body') }}
    </x-section-heading>

    <div data-reveal="up" data-reveal-delay="100" class="mt-10 max-w-3xl text-charcoal-300 leading-relaxed">
        {{ \App\Models\Setting::get('intro.body_2') }}
    </div>

    {{-- Stats row --}}
    <div data-reveal-stagger class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-charcoal-700 pt-10">
        <div>
            <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">18</div>
            <div class="text-charcoal-300 text-xs uppercase tracking-widest">Years of Craft</div>
        </div>
        <div>
            <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">3K+</div>
            <div class="text-charcoal-300 text-xs uppercase tracking-widest">Projects Worldwide</div>
        </div>
        <div>
            <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">3</div>
            <div class="text-charcoal-300 text-xs uppercase tracking-widest">Global Studios</div>
        </div>
        <div>
            <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">100s</div>
            <div class="text-charcoal-300 text-xs uppercase tracking-widest">Developer Partners</div>
        </div>
    </div>
</x-section>

{{-- 02 — What We Create --}}
<x-section variant="dark">
    <x-section-heading label="02 — What We Create" title="Models built to be experienced." />
    <div data-reveal-stagger class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($services as $s)
            <x-service-card :service="$s" :index="$loop->iteration" />
        @empty
            <div class="card-elegant p-10 text-charcoal-300 col-span-full">
                No services yet — add them in the admin.
            </div>
        @endforelse
    </div>
</x-section>

{{-- 03 — Process --}}
<x-section padding="lg">
    <x-section-heading label="03 — The WUBA Experience" title="From drawing<br>to model." size="xl" />
    <div data-reveal-stagger class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-6">
        @foreach ($process as $step)
            <div class="relative">
                <div class="text-gradient-ember font-display text-5xl mb-4">
                    {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                </div>
                <div class="w-12 h-px mb-4" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="text-lg font-display tracking-tightest text-cream-100 mb-3 uppercase">{{ $step->title }}</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">{{ $step->description }}</p>
            </div>
        @endforeach
    </div>
</x-section>

{{-- 04 — Portfolio Preview --}}
<x-section variant="dark">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
        <x-section-heading label="04 — Selected Work" title="Portfolio" maxWidth="max-w-none" />
        <x-btn href="/work" variant="outline" class="self-start md:self-end">View All Projects</x-btn>
    </div>
    <div data-reveal-stagger class="grid md:grid-cols-2 gap-8">
        @forelse ($featured as $project)
            <x-project-card :project="$project" />
        @empty
            <div class="md:col-span-2 text-charcoal-300 py-12">No featured projects yet.</div>
        @endforelse
    </div>
</x-section>

{{-- 05 — Why WUBA --}}
<x-section padding="lg">
    <x-section-heading label="05 — Why WUBA" title="What sets our work apart." />
    <div data-reveal-stagger class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
        @foreach ($values as $value)
            <div>
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">{{ $value->title }}</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">{{ $value->description }}</p>
            </div>
        @endforeach
    </div>
</x-section>

{{-- 06 — Before/After --}}
<x-section variant="dark">
    <x-section-heading label="06 — Before / After" title="Drawing → Model." />
    <div class="grid md:grid-cols-2 gap-6">
        <div data-reveal="left" class="card-elegant p-10 md:p-16">
            <div class="text-charcoal-300 text-xs tracking-widest uppercase mb-4">Architectural Drawing</div>
            <div class="aspect-[4/3] bg-charcoal-800 flex items-center justify-center text-charcoal-400">CAD / Plan</div>
        </div>
        <div data-reveal="right" class="card-elegant p-10 md:p-16">
            <div class="text-gradient-gold text-xs tracking-widest uppercase mb-4">WUBA Model</div>
            <div class="aspect-[4/3] bg-charcoal-800 flex items-center justify-center text-charcoal-400">Physical Model</div>
        </div>
    </div>
</x-section>

{{-- 07 — Clients --}}
<x-section>
    <x-section-heading label="07 — Who We Work With" title="Trusted by teams shaping<br>the built environment." />
    <div data-reveal-stagger class="flex flex-wrap gap-3 md:gap-4">
        @foreach ($clients as $client)
            <div class="px-6 py-4 text-charcoal-100 text-sm uppercase tracking-widest transition-all duration-300 hover:text-gold-400"
                 style="border: 1px solid rgba(239, 201, 103, 0.15);"
                 onmouseover="this.style.borderColor='rgba(236,177,67,0.6)'; this.style.boxShadow='0 0 24px -6px rgba(236,177,67,0.4)';"
                 onmouseout="this.style.borderColor='rgba(239,201,103,0.15)'; this.style.boxShadow='none';">
                {{ $client->name }}
            </div>
        @endforeach
    </div>
</x-section>

{{-- 08 — CTA --}}
<x-cta-section />

@endsection