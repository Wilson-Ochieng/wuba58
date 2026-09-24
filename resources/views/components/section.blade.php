@props([
    'variant' => 'default',   // default | dark | warm | none
    'padding' => 'md',        // sm | md | lg
    'id' => null,
    'reveal' => 'up',         // up | down | left | right | scale | fade | none
])

@php
    $paddingClass = match ($padding) {
        'sm' => 'py-16 md:py-20',
        'lg' => 'py-32 md:py-40',
        default => 'py-24 md:py-32',
    };

    $bgClass = match ($variant) {
        'dark' => 'bg-section-dark',
        'warm' => 'bg-section-warm',
        'none' => '',
        default => '',
    };
@endphp

<section
    @if($id) id="{{ $id }}" @endif
    @if($reveal !== 'none') data-reveal="{{ $reveal }}" @endif
    class="{{ $paddingClass }} {{ $bgClass }}"
>
    <div class="container-x">
        {{ $slot }}
    </div>
</section>