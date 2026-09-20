@props(['service', 'index' => null])

<article class="card-elegant p-8 md:p-10 group h-full flex flex-col">
    @if ($index !== null)
        <div class="text-gradient-gold font-display text-3xl mb-6">
            {{ str_pad($index, 2, '0', STR_PAD_LEFT) }}
        </div>
    @endif

    <h3 class="text-xl font-display tracking-tightest text-cream-100 mb-4 uppercase group-hover:text-gold-400 transition-colors">
        {{ $service->title }}
    </h3>

    @if ($service->description)
        <p class="text-charcoal-200 leading-relaxed text-sm flex-1">
            {{ $service->description }}
        </p>
    @endif
</article>