@props([
    'href' => null,
    'variant' => 'primary',  // primary | outline | ghost
    'size' => 'md',          // sm | md | lg
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-semibold uppercase tracking-widest transition-all duration-300 whitespace-nowrap';

    $sizes = [
        'sm' => 'px-6 py-3 text-xs',
        'md' => 'px-8 py-4 text-sm',
        'lg' => 'px-10 py-5 text-base',
    ];

    $variants = [
        'primary' => 'btn-primary',
        'outline' => 'btn-outline',
        'ghost' => 'text-cream-100 hover:text-gold-400',
    ];

    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif