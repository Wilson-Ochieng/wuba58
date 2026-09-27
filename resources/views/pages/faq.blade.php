@extends('layouts.app')

@section('title', 'Frequently Asked Questions — Wuba 58 City Models')
@section('description', 'Answers to common questions about architectural models, timelines, pricing, materials, and delivery from Wuba 58 City Models.')

@section('content')

<x-page-hero
    label="FAQ"
    title="Frequently asked questions"
    description="Everything you need to know about commissioning a physical model or 3D visualization from the Wuba 58 studio."
/>

<x-section>
    @php
        $categories = \App\Models\Faq::categories();
        $total = $faqs->flatten()->count();
    @endphp

    @if ($total === 0)
        <div class="card-elegant p-12 text-center text-charcoal-300">
            No FAQs published yet. Check back soon.
        </div>
    @else
        {{-- Category navigation --}}
        @if ($faqs->count() > 1)
            <div class="flex flex-wrap gap-2 mb-16">
                @foreach ($faqs as $category => $items)
                    <a href="#cat-{{ $category }}"
                       class="px-4 py-2 text-xs uppercase tracking-widest text-charcoal-200 hover:text-gold-400 transition-colors"
                       style="border: 1px solid rgba(239,201,103,0.15);">
                        {{ $categories[$category] ?? ucfirst($category) }}
                        <span class="ml-2 text-charcoal-400">{{ $items->count() }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- FAQ groups --}}
        <div class="max-w-3xl mx-auto space-y-16">
            @foreach ($faqs as $category => $items)
                <div id="cat-{{ $category }}" class="scroll-mt-32">
                    <div class="section-label mb-8">
                        {{ $categories[$category] ?? ucfirst($category) }}
                    </div>

                    <div class="space-y-3">
                        @foreach ($items as $faq)
                            <div
                                x-data="{ open: false }"
                                class="card-elegant overflow-hidden"
                            >
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="w-full flex items-start justify-between gap-6 p-6 md:p-7 text-left"
                                    :aria-expanded="open"
                                >
                                    <span class="font-display tracking-tightest text-cream-100 text-base md:text-lg uppercase leading-tight flex-1">
                                        {{ $faq->question }}
                                    </span>
                                    <span
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center transition-all duration-300"
                                        :class="open ? 'rotate-45 text-gold-400' : 'text-charcoal-300'"
                                        style="border: 1px solid rgba(239,201,103,0.2);"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </span>
                                </button>

                                <div
                                    x-show="open"
                                    x-collapse
                                    x-cloak
                                >
                                    <div class="px-6 md:px-7 pb-6 md:pb-7 text-charcoal-200 leading-relaxed">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-section>

{{-- JSON-LD FAQ schema for Google rich results --}}
@if ($total > 0)
    @push('structured-data')
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faqs->flatten()->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq->answer,
                    ],
                ])->values()->all(),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush
@endif

<x-cta-section />

@endsection