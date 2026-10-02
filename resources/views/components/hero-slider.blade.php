@props([
    'limit' => 6,
    'eyebrow' => null,
    'headline' => null,
    'headlineAccent' => null,
    'subtext' => null,
    'primaryCta' => ['label' => 'Explore Our Work', 'url' => '/work'],
    'secondaryCta' => ['label' => 'Start a Project', 'url' => '/contact'],
])

@php
    $slides = \App\Models\Slide::published()
        ->orderBy('order')
        ->take($limit)
        ->get();

    // Default hero text (used when the active slide has no override)
    $defaults = [
        'eyebrow'         => $eyebrow ?: 'Nairobi · Shenzhen · Nanchang',
        'headline'        => $headline ?: "WE TURN ARCHITECTURE\nINTO SOMETHING YOU CAN SEE.",
        'headline_accent' => $headlineAccent ?: 'SOMETHING YOU CAN SEE.',
        'subtext'         => $subtext ?: 'Precision architectural models and 3D visualizations that bring developments to life.',
    ];

    // Build a per-slide payload — if a slide has a title/subtitle, use it; otherwise fall back
    $slidePayload = [];
    foreach ($slides as $i => $slide) {
        $slideHeadline = $slide->title ?: $defaults['headline'];

        // If the slide has a title, use it directly (no gradient split) and use subtitle as subtext
        $slidePayload[] = [
            'eyebrow'         => $slide->location
                                    ? trim($slide->location . ($slide->scale ? ' · Scale ' . $slide->scale : ''))
                                    : $defaults['eyebrow'],
            'headline'        => $slideHeadline,
            'headline_accent' => $slide->title ? null : $defaults['headline_accent'],
            'subtext'         => $slide->subtitle ?: ($slide->title ? null : $defaults['subtext']),
        ];
    }
@endphp

<section
    class="relative w-full overflow-hidden flex items-end"
    style="min-height: 100vh; background: #0e0d0c;"
    x-data="{
        active: 0,
        total: {{ max($slides->count(), 1) }},
        payload: {{ Js::from($slidePayload) }},
        paused: false,
        timer: null,
        reduced: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
        init() { if (this.total > 1 && !this.reduced) this.start(); },
        start() {
            this.stop();
            this.timer = setInterval(() => {
                if (!this.paused) this.active = (this.active + 1) % this.total;
            }, 7000);
        },
        stop() { clearInterval(this.timer); },
        next() { this.active = (this.active + 1) % this.total; this.start(); },
        prev() { this.active = (this.active - 1 + this.total) % this.total; this.start(); },
        go(i) { this.active = i; this.start(); },
        get current() { return this.payload[this.active] || {{ Js::from($defaults) }}; }
    }"
    @mouseenter="paused = true"
    @mouseleave="paused = false"
    @keydown.window.arrow-right="next()"
    @keydown.window.arrow-left="prev()"
    aria-roledescription="carousel"
>
    {{-- ═════════ BACKGROUND SLIDES ═════════ --}}
    @if ($slides->isNotEmpty())
        @foreach ($slides as $i => $slide)
            @php $image = $slide->getFirstMediaUrl('image'); @endphp
            <div
                x-show="active === {{ $i }}"
                x-transition:enter="transition ease-out duration-[1400ms]"
                x-transition:enter-start="opacity-0 scale-105"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-900"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-105"
                @if ($i !== 0) x-cloak @endif
                class="absolute inset-0"
                role="group"
                aria-roledescription="slide"
                aria-label="Slide {{ $i + 1 }} of {{ $slides->count() }}"
            >
                @if ($image)
                    <img src="{{ $image }}"
                         alt="{{ $slide->title }}"
                         class="absolute inset-0 w-full h-full object-cover"
                         loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                @endif
            </div>
        @endforeach
    @else
        <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #2a1a0f 45%, #161515 100%);"></div>
    @endif

    {{-- ═════════ OVERLAYS ═════════ --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background: linear-gradient(180deg, rgba(22,21,21,0.5) 0%, rgba(22,21,21,0.3) 35%, rgba(22,21,21,0.85) 85%, rgba(22,21,21,0.98) 100%);"></div>
    <div class="absolute inset-0 pointer-events-none glow-hero opacity-50"></div>
    <div class="absolute inset-0 pointer-events-none"
         style="background: linear-gradient(90deg, rgba(14,13,12,0.7) 0%, rgba(14,13,12,0.25) 55%, transparent 80%);"></div>

    {{-- ═════════ HERO CONTENT ═════════ --}}
    <div class="relative container-x pb-20 md:pb-28 pt-32 w-full z-10">
        <div class="max-w-4xl">

            {{-- Eyebrow — updates per slide --}}
            <div class="flex items-center gap-3 mb-6 md:mb-8 h-4">
                <span class="block w-10 h-px" style="background: linear-gradient(90deg, transparent, #ECB143);"></span>
                <span x-text="current.eyebrow"
                      x-transition:enter="transition ease-out duration-500"
                      x-transition:enter-start="opacity-0"
                      x-transition:enter-end="opacity-100"
                      class="text-xs md:text-sm uppercase tracking-[0.35em] font-semibold text-gradient-gold">
                    {{ $defaults['eyebrow'] }}
                </span>
            </div>

            {{-- Headline — updates per slide --}}
            <h1 class="text-[2.25rem] xs:text-5xl sm:text-6xl md:text-7xl lg:text-[5.5rem] xl:text-[6rem]
                       font-display tracking-tightest text-cream-100 leading-[0.95] text-balance"
                style="font-weight: 900; letter-spacing: -0.045em;">

                {{-- Slide with custom title: show title only --}}
                <template x-if="current.headline_accent === null">
                    <span x-text="current.headline" class="block"></span>
                </template>

                {{-- Default: split into cream + gradient accent --}}
                <template x-if="current.headline_accent !== null">
                    <span>
                        <span x-text="current.headline.split('\n')[0]"></span>
                        <br class="hidden sm:block">
                        <span class="text-gradient-ember" x-text="current.headline.split('\n').slice(1).join(' ')"></span>
                    </span>
                </template>
            </h1>

            {{-- Subtext — updates per slide, hides when empty --}}
            <p x-show="current.subtext"
               x-text="current.subtext"
               x-transition:enter="transition ease-out duration-500"
               x-transition:enter-start="opacity-0 translate-y-2"
               x-transition:enter-end="opacity-100 translate-y-0"
               class="mt-8 md:mt-10 max-w-xl text-charcoal-100 text-lg md:text-xl leading-relaxed">
            </p>

            {{-- CTAs (static, always shown) --}}
            <div class="mt-10 md:mt-12 flex flex-col sm:flex-row gap-4">
                @if (! empty($primaryCta['label']))
                    <x-btn href="{{ $primaryCta['url'] }}" variant="primary">
                        {{ $primaryCta['label'] }}
                    </x-btn>
                @endif
                @if (! empty($secondaryCta['label']))
                    <x-btn href="{{ $secondaryCta['url'] }}" variant="outline">
                        {{ $secondaryCta['label'] }}
                    </x-btn>
                @endif
            </div>
        </div>
    </div>

    {{-- ═════════ CHEVRONS ═════════ --}}
    @if ($slides->count() > 1)
        <button
            type="button"
            @click="prev()"
            class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 hidden md:flex items-center justify-center text-cream-100 transition-all duration-300 hover:text-gold-400 hover:scale-110"
            style="background: rgba(22,21,21,0.6); border: 1px solid rgba(236,177,67,0.2); backdrop-filter: blur(8px);"
            aria-label="Previous slide"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button
            type="button"
            @click="next()"
            class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 hidden md:flex items-center justify-center text-cream-100 transition-all duration-300 hover:text-gold-400 hover:scale-110"
            style="background: rgba(22,21,21,0.6); border: 1px solid rgba(236,177,67,0.2); backdrop-filter: blur(8px);"
            aria-label="Next slide"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    @endif

    {{-- ═════════ DOTS ═════════ --}}
    @if ($slides->count() > 1)
        <div class="absolute bottom-6 md:bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            @foreach ($slides as $i => $s)
                <button
                    type="button"
                    @click="go({{ $i }})"
                    class="transition-all duration-500"
                    :style="active === {{ $i }}
                        ? 'width: 48px; height: 3px; border-radius: 2px; background: linear-gradient(90deg, #EFC967, #E48633); box-shadow: 0 0 12px rgba(236,177,67,0.6);'
                        : 'width: 20px; height: 3px; border-radius: 2px; background: rgba(244,240,232,0.3);'"
                    aria-label="Go to slide {{ $i + 1 }}"
                ></button>
            @endforeach
        </div>
    @endif

    {{-- ═════════ SLIDE COUNTER ═════════ --}}
    @if ($slides->count() > 1)
        <div class="absolute top-24 md:top-28 right-4 md:right-8 z-20 px-4 py-2 text-xs uppercase tracking-[0.25em] text-cream-100 hidden md:flex items-center gap-2"
             style="background: rgba(22,21,21,0.6); border: 1px solid rgba(236,177,67,0.2); backdrop-filter: blur(8px);">
            <span x-text="String(active + 1).padStart(2, '0')" class="text-gradient-gold font-semibold"></span>
            <span class="text-charcoal-500">/</span>
            <span class="text-charcoal-300">{{ str_pad($slides->count(), 2, '0', STR_PAD_LEFT) }}</span>
        </div>
    @endif

    {{-- ═════════ SCROLL HINT ═════════ --}}
    <div class="absolute bottom-6 md:bottom-8 right-4 md:right-8 z-20 hidden md:flex items-center gap-3 text-xs uppercase tracking-[0.25em] text-charcoal-300">
        <span>Scroll</span>
        <span class="block w-8 h-px bg-charcoal-500"></span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 animate-bounce">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
        </svg>
    </div>

    {{-- ═════════ TOUCH SWIPE ═════════ --}}
    @if ($slides->count() > 1)
        <div
            x-data="{ startX: 0 }"
            @touchstart.passive="startX = $event.touches[0].clientX"
            @touchend.passive="
                let endX = $event.changedTouches[0].clientX;
                if (Math.abs(endX - startX) > 40) {
                    endX < startX ? $dispatch('slide-next') : $dispatch('slide-prev');
                }
            "
            @slide-next.window="next()"
            @slide-prev.window="prev()"
            class="absolute inset-x-0 bottom-0 h-[55%] z-[5] md:hidden"
            aria-hidden="true"
        ></div>
    @endif
</section>