@props([
    'label' => null,
    'title' => null,
    'description' => null,
    'size' => 'md',   // sm | md | lg
])

@php
    $padding = match ($size) {
        'sm' => 'pt-40 pb-16 md:pt-44 md:pb-24',
        'lg' => 'pt-56 pb-24 md:pt-64 md:pb-32',
        default => 'pt-48 pb-20 md:pt-56 md:pb-28',
    };
@endphp

<section class="relative {{ $padding }} overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);"></div>
    <div class="absolute inset-0 glow-hero opacity-70"></div>

    <div class="relative container-x">
        @if ($label)
            <div class="section-label mb-6">{{ $label }}</div>
        @endif

        @if ($title)
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-display tracking-tightest text-cream-100 max-w-5xl leading-[1.05] text-balance">
                {{ $title }}
            </h1>
        @endif

        @if ($description)
            <p class="mt-8 max-w-2xl text-lg md:text-xl text-charcoal-200 leading-relaxed">
                {{ $description }}
            </p>
        @endif

        @if ($slot->isNotEmpty())
            <div class="mt-10">
                {{ $slot }}
            </div>
        @endif
    </div>
</section>