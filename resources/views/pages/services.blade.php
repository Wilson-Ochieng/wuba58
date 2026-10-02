@extends('layouts.app')

@section('title', 'Services — Wuba 58 City Models')
@section('description', 'Architectural scale models and 3D visualizations for developers, architects, and investors across Nairobi and beyond.')

@section('content')

    {{-- ═════════ PAGE HERO ═════════ --}}
    <x-page-hero label="What We Create" title="Services"
        description="Two ways we bring your development to life — architectural scale models, and photorealistic 3D visualizations." />

    {{-- ═════════ SERVICE CATEGORIES (ACCORDIONS) ═════════ --}}
    <x-section variant="dark">
        <x-section-heading label="Our Services" title="Explore by category." size="xl" />

        @php
            $categories = [
                [
                    'key' => 'scale_models',
                    'label' => '01',
                    'title' => 'Architectural Scale Models',
                    'tagline' => 'Physical scale models for developments, buildings and masterplans.',
                    'description' => 'Precision hand-built models designed for sales galleries, planning approval, and investor presentations. Every model is crafted in-house with carefully selected materials, finishes, and lighting.',
                    'services' => $servicesByGroup['scale_models'],
                    'accent' => 'gold',
                    'open' => true,
                ],
                [
                    'key' => 'visualizations',
                    'label' => '02',
                    'title' => '3D Visualizations',
                    'tagline' => 'Photorealistic renders and digital presentations.',
                    'description' => 'Digital visualizations that bring projects to life before ground is broken — still renders, animations, and walkthrough experiences for marketing, planning, and investor decks.',
                    'services' => $servicesByGroup['visualizations'],
                    'accent' => 'ember',
                    'open' => false,
                ],
            ];
        @endphp

        <div class="space-y-4">
            @foreach ($categories as $cat)
                @if ($cat['services']->isNotEmpty())
                    <div id="{{ $cat['key'] === 'scale_models' ? 'scale-models' : 'visualizations' }}"
                        x-data="{ open: {{ $cat['open'] ? 'true' : 'false' }} }" class="card-elegant overflow-hidden scroll-mt-32"
                        style="border-color: rgba(236,177,67,0.15);">
                        {{-- Accordion header --}}
                        <button type="button" @click="open = !open"
                            class="w-full grid grid-cols-12 gap-6 items-start text-left p-8 md:p-10 hover:bg-charcoal-800/40 transition-colors"
                            :aria-expanded="open">
                            {{-- Big number --}}
                            <div class="col-span-2 md:col-span-1">
                                <span
                                    class="font-display text-5xl md:text-7xl leading-none
                                                        {{ $cat['accent'] === 'gold' ? 'text-gradient-gold' : 'text-gradient-ember' }}">
                                    {{ $cat['label'] }}
                                </span>
                            </div>

                            {{-- Title + tagline --}}
                            <div class="col-span-10 md:col-span-9">
                                <h3
                                    class="text-2xl md:text-4xl font-display tracking-tightest text-cream-100 mb-3 leading-tight uppercase">
                                    {{ $cat['title'] }}
                                </h3>
                                <p class="text-charcoal-200 text-base md:text-lg leading-relaxed max-w-2xl">
                                    {{ $cat['tagline'] }}
                                </p>
                                <div class="mt-4 text-charcoal-400 text-xs uppercase tracking-widest">
                                    {{ $cat['services']->count() }} {{ Str::plural('service', $cat['services']->count()) }}
                                </div>
                            </div>

                            {{-- Chevron --}}
                            <div class="col-span-12 md:col-span-2 flex md:justify-end items-center">
                                <span class="flex items-center gap-3 text-charcoal-300 transition-all duration-300"
                                    :class="open ? 'text-gold-400' : ''">
                                    <span class="text-xs uppercase tracking-widest hidden md:inline"
                                        x-text="open ? 'Close' : 'View services'"></span>
                                    <span class="w-10 h-10 flex items-center justify-center transition-transform duration-300"
                                        :class="open ? 'rotate-45' : ''" style="border: 1px solid rgba(236,177,67,0.3);">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </span>
                                </span>
                            </div>
                        </button>

                        {{-- Accordion body --}}
                        <div x-show="open" x-collapse x-cloak>
                            <div class="border-t border-charcoal-700 px-8 md:px-10 py-10 md:py-12">
                                <div class="grid lg:grid-cols-12 gap-10 lg:gap-16">

                                    {{-- Description --}}
                                    <div class="lg:col-span-5">
                                        <div class="section-label mb-5">About this category</div>
                                        <p class="text-charcoal-200 leading-relaxed">
                                            {{ $cat['description'] }}
                                        </p>

                                        <div class="mt-8 flex flex-wrap gap-3">
                                            @if ($cat['key'] === 'scale_models')
                                                <x-btn href="/work" variant="outline" size="sm">
                                                    See models in portfolio →
                                                </x-btn>
                                            @else
                                                <x-btn href="/work/physical-models" variant="outline" size="sm">
                                                    See 3D work →
                                                </x-btn>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Services list --}}
                                    <div class="lg:col-span-7">
                                        <div class="section-label mb-5">What's included</div>
                                        <ul class="space-y-3">
                                            @foreach ($cat['services'] as $i => $service)
                                                <li class="card-elegant p-5 md:p-6 group flex items-start gap-5">
                                                    <span
                                                        class="font-display text-lg leading-none pt-1
                                                                                    {{ $cat['accent'] === 'gold' ? 'text-gradient-gold' : 'text-gradient-ember' }}">
                                                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                                    </span>
                                                    <div class="flex-1">
                                                        <h4
                                                            class="text-cream-100 font-display tracking-tightest text-lg uppercase mb-1.5 group-hover:text-gold-400 transition-colors">
                                                            {{ $service->title }}
                                                        </h4>
                                                        @if ($service->description)
                                                            <p class="text-charcoal-300 text-sm leading-relaxed">
                                                                {{ $service->description }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </x-section>

    {{-- ═════════ LEAD CTA ═════════ --}}
    @php
        $whatsappNumber = preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', ''));
        $contactEmail = \App\Models\Setting::get('contact.email', '');
        $message = \App\Models\Setting::get('services.cta_message', "Hi Wuba 58, I'd like to discuss a model project.");
    @endphp

    <x-section>
        <div class="max-w-3xl mx-auto text-center">
            <div class="section-label mb-5">Start a Project</div>
            <h2 class="text-3xl md:text-4xl font-display tracking-tightest text-cream-100 mb-6">
                Not sure which category fits?
            </h2>
            <p class="text-charcoal-200 text-lg leading-relaxed mb-10">
                Send us your drawings and project details — we'll recommend the right approach and give you a clear quote.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if ($whatsappNumber)
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($message) }}" target="_blank" rel="noopener"
                        class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        WhatsApp us
                    </a>
                @endif

                @if ($contactEmail)
                    <a href="mailto:{{ $contactEmail }}?subject={{ urlencode('Service enquiry') }}&body={{ urlencode($message) }}"
                        class="btn-outline">
                        Email us
                    </a>
                @endif

                <a href="/contact" class="btn-outline">
                    Send a brief →
                </a>
            </div>
        </div>
    </x-section>

    {{-- ═════════ PROCESS RECAP ═════════ --}}
    @if ($process->isNotEmpty())
        <x-section variant="dark" padding="lg">
            <x-section-heading label="How It Works" title="From drawing to model." size="xl" />

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
    <x-section>
        <x-section-heading label="The WUBA Difference" title="What sets our work apart." />

        <div class="grid md:grid-cols-3 gap-8">
            <div class="card-elegant p-8">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">Made in Kenya</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Built locally, delivered locally. No import delays, no currency surprises.
                </p>
            </div>

            <div class="card-elegant p-8">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">Digital + Physical</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    A single team producing both the physical model and the 3D visualization — consistent, fast, cohesive.
                </p>
            </div>

            <div class="card-elegant p-8">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <h3 class="font-display tracking-tightest text-cream-100 text-lg mb-3 uppercase">Presentation Ready</h3>
                <p class="text-charcoal-200 text-sm leading-relaxed">
                    Everything we deliver is built for sales galleries, exhibitions, and investor presentations.
                </p>
            </div>
        </div>
    </x-section>

    <x-cta-section />

@endsection