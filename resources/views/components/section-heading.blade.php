@props([
    'label' => null,
    'title' => null,
    'align' => 'left',      // left | center
    'size' => 'lg',         // md | lg | xl
    'maxWidth' => 'max-w-4xl',
])

@php
    $alignClass = $align === 'center' ? 'text-center mx-auto' : '';
    $sizeClass = match ($size) {
        'md' => 'text-3xl md:text-4xl',
        'xl' => 'text-4xl md:text-6xl lg:text-7xl',
        default => 'text-3xl md:text-5xl',
    };
@endphp

<div class="{{ $alignClass }} {{ $maxWidth }} mb-12 md:mb-16">
    @if ($label)
        <div class="section-label mb-5">{{ $label }}</div>
    @endif

    @if ($title)
                <h2 class="{{ $sizeClass }} font-display tracking-tightest text-cream-100 leading-[1.05] text-balance">
            {!! $title !!}
        </h2>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-6 text-charcoal-200 text-lg leading-relaxed max-w-2xl {{ $align === 'center' ? 'mx-auto' : '' }}">
            {{ $slot }}
        </div>
    @endif
</div>