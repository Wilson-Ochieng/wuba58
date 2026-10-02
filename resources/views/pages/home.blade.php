@extends('layouts.app')

@section('title', 'WUBA 58 City Models — Architectural Models & 3D Visualization')
@section('description', 'Precision architectural models and 3D visualizations that bring developments to life.')

@section('content')

    {{-- ═════════ HERO SLIDER ═════════ --}}
    <x-hero-slider :eyebrow="$hero['eyebrow']" :headline="$hero['headline']" :headline-accent="$hero['headline_accent']"
        :subtext="$hero['subtext']" :primary-cta="$hero['primary_cta']" :secondary-cta="$hero['secondary_cta']" />

    {{-- 01 — Portfolio Preview (moved up) --}}
    <x-section variant="dark">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
            <x-section-heading :label="\App\Models\Setting::get('portfolio.label', '01 — Selected Work')"
                :title="\App\Models\Setting::get('portfolio.title', 'Portfolio')" maxWidth="max-w-none" />
            <x-btn href="/work" variant="outline" class="self-start md:self-end">
                {{ \App\Models\Setting::get('portfolio.cta_label', 'View All Projects') }}
            </x-btn>
        </div>

        <div data-reveal-stagger class="grid md:grid-cols-2 gap-8">
            @forelse ($featured as $project)
                <x-project-card :project="$project" />
            @empty
                <div class="md:col-span-2 text-charcoal-300 py-12">No featured projects yet.</div>
            @endforelse
        </div>
    </x-section>

    {{-- 02 — Introduction --}}
    <x-section>
        <x-section-heading :label="\App\Models\Setting::get('intro.label', '02 — Introduction')"
            :title="\App\Models\Setting::get('intro.title', 'See the city before it\'s built.')" size="xl">
            {{ \App\Models\Setting::get('intro.body') }}
        </x-section-heading>

        <div data-reveal="up" data-reveal-delay="100" class="mt-10 max-w-3xl text-charcoal-300 leading-relaxed">
            {{ \App\Models\Setting::get('intro.body_2') }}
        </div>

        {{-- Stats row --}}
        <div data-reveal-stagger class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-charcoal-700 pt-10">
            <div>
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">
                    {{ \App\Models\Setting::get('stats.years', '18') }}
                </div>
                <div class="text-charcoal-300 text-xs uppercase tracking-widest">
                    {{ \App\Models\Setting::get('stats.years_label', 'Years of Craft') }}
                </div>
            </div>
            <div>
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">
                    {{ \App\Models\Setting::get('stats.projects', '3K+') }}
                </div>
                <div class="text-charcoal-300 text-xs uppercase tracking-widest">
                    {{ \App\Models\Setting::get('stats.projects_label', 'Projects Worldwide') }}
                </div>
            </div>
            <div>
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">
                    {{ \App\Models\Setting::get('stats.studios', '3') }}
                </div>
                <div class="text-charcoal-300 text-xs uppercase tracking-widest">
                    {{ \App\Models\Setting::get('stats.studios_label', 'Global Studios') }}
                </div>
            </div>
            <div>
                <div class="text-gradient-gold font-display text-5xl md:text-6xl leading-none mb-2">
                    {{ \App\Models\Setting::get('stats.partners', '100s') }}
                </div>
                <div class="text-charcoal-300 text-xs uppercase tracking-widest">
                    {{ \App\Models\Setting::get('stats.partners_label', 'Developer Partners') }}
                </div>
            </div>
        </div>
    </x-section>

    {{-- 03 — What We Create --}}
{{-- 03 — What We Create --}}
<x-section variant="dark">
    <x-section-heading
        :label="\App\Models\Setting::get('services.label', '03 — What We Create')"
        :title="\App\Models\Setting::get('services.title', 'Two ways to bring your project to life.')"
    />

    <div class="grid md:grid-cols-2 gap-6 md:gap-8">
        {{-- Architectural Scale Models --}}
        <a href="/services#scale-models" class="group card-elegant p-10 md:p-14 block hover:border-gold-500/40 transition-all">
            <div class="flex items-baseline gap-6 mb-8">
                <span class="text-gradient-gold font-display text-6xl md:text-7xl leading-none">01</span>
            </div>
            <h3 class="text-3xl md:text-4xl font-display tracking-tightest text-cream-100 mb-4 uppercase group-hover:text-gold-400 transition-colors">
                Architectural<br>Scale Models
            </h3>
            <p class="text-charcoal-200 leading-relaxed mb-8">
                Physical scale models for developments, buildings and masterplans — precision-built for sales galleries, planning, and investor presentations.
            </p>
            <span class="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-gradient-gold">
                Explore
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </a>

        {{-- 3D Visualizations --}}
        <a href="/services#visualizations" class="group card-elegant p-10 md:p-14 block hover:border-gold-500/40 transition-all">
            <div class="flex items-baseline gap-6 mb-8">
                <span class="text-gradient-ember font-display text-6xl md:text-7xl leading-none">02</span>
            </div>
            <h3 class="text-3xl md:text-4xl font-display tracking-tightest text-cream-100 mb-4 uppercase group-hover:text-gold-400 transition-colors">
                3D<br>Visualizations
            </h3>
            <p class="text-charcoal-200 leading-relaxed mb-8">
                Photorealistic renders and digital presentations that bring projects to life — stills, animations, and walkthrough experiences.
            </p>
            <span class="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-gradient-ember">
                Explore
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </a>
    </div>

    {{-- Lead CTA --}}
    @php
        $whatsappNumber = preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', ''));
        $contactEmail = \App\Models\Setting::get('contact.email', '');
        $message = \App\Models\Setting::get('services.cta_message', "Hi Wuba 58, I'd like to discuss a model project.");
    @endphp

    <div data-reveal="up" class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-4">
        @if ($whatsappNumber)
            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($message) }}"
               target="_blank" rel="noopener" class="btn-primary">
                WhatsApp us
            </a>
        @endif
        @if ($contactEmail)
            <a href="mailto:{{ $contactEmail }}?subject={{ urlencode('Service enquiry') }}&body={{ urlencode($message) }}"
               class="btn-outline">
                Email us
            </a>
        @endif
    </div>
</x-section>

    {{-- 04 — Process --}}
    <x-section padding="lg">
        <x-section-heading :label="\App\Models\Setting::get('process.label', '04 — The WUBA Experience')"
            :title="\App\Models\Setting::get('process.title', 'From drawing<br>to model.')" size="xl" />

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

    {{-- 05 — Why WUBA --}}
  {{-- 05 — Why WUBA --}}
<x-section variant="dark" padding="lg">
    <x-section-heading
        :label="\App\Models\Setting::get('values.label', '05 — Why WUBA')"
        :title="\App\Models\Setting::get('values.title', 'What sets our work apart.')"
    />

    <div data-reveal-stagger class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
        @foreach ($values as $value)
            <div>
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">{{ $value->title }}</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">{{ $value->description }}</p>
            </div>
        @endforeach
    </div>

    {{-- Lead CTA under values --}}
    @php
        $valuesCtaWhatsapp = \App\Models\Setting::get('values.cta_whatsapp_label', 'Chat on WhatsApp');
        $valuesCtaSecondary = \App\Models\Setting::get('values.cta_secondary_label', 'Start a Project →');
        $valuesCtaUrl = \App\Models\Setting::get('values.cta_secondary_url', '/contact');

        // These are used in the WhatsApp link below — define here if missing
        $whatsappNumber = $whatsappNumber ?? preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', ''));
        $servicesCtaMessage = $servicesCtaMessage ?? \App\Models\Setting::get('services.cta_message', "Hi Wuba 58, I'd like to discuss a model project.");
    @endphp

    <div data-reveal="up" class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-4">
        @if ($whatsappNumber)
            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($servicesCtaMessage) }}" target="_blank"
                rel="noopener" class="btn-primary">
                {{ $valuesCtaWhatsapp }}
            </a>
        @endif
        <a href="{{ $valuesCtaUrl }}" class="btn-outline">
            {{ $valuesCtaSecondary }}
        </a>
    </div>
</x-section>

    {{-- 06 — Before/After --}}
    <x-section>
        <x-section-heading :label="\App\Models\Setting::get('beforeafter.label', '06 — Before / After')"
            :title="\App\Models\Setting::get('beforeafter.title', 'Drawing → Model.')" />

        <div class="grid md:grid-cols-2 gap-6">
            <div data-reveal="left" class="card-elegant p-10 md:p-16">
                <div class="text-charcoal-300 text-xs tracking-widest uppercase mb-4">
                    {{ \App\Models\Setting::get('beforeafter.before_label', 'Architectural Drawing') }}
                </div>
                <div class="aspect-[4/3] bg-charcoal-800 flex items-center justify-center text-charcoal-400">
                    {{ \App\Models\Setting::get('beforeafter.before_caption', 'CAD / Plan') }}
                </div>
            </div>
            <div data-reveal="right" class="card-elegant p-10 md:p-16">
                <div class="text-gradient-gold text-xs tracking-widest uppercase mb-4">
                    {{ \App\Models\Setting::get('beforeafter.after_label', 'WUBA Model') }}
                </div>
                <div class="aspect-[4/3] bg-charcoal-800 flex items-center justify-center text-charcoal-400">
                    {{ \App\Models\Setting::get('beforeafter.after_caption', 'Physical Model') }}
                </div>
            </div>
        </div>
    </x-section>

    {{-- 07 — Clients --}}
    <x-section variant="dark">
        <x-section-heading :label="\App\Models\Setting::get('clients.label', '07 — Who We Work With')"
            :title="\App\Models\Setting::get('clients.title', 'Trusted by teams shaping<br>the built environment.')" />

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

    {{-- Testimonials --}}
    <x-testimonials />

    {{-- 08 — CTA --}}
    <x-cta-section />

@endsection