@extends('layouts.app')

@section('title', $post->title . ' — Wuba 58 City Models')
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->body), 150))

@section('content')

    {{-- Hero --}}
    <section class="relative pt-40 pb-16 md:pt-48 md:pb-20 overflow-hidden">
        @if ($post->hasMedia('hero'))
            <img src="{{ $post->getFirstMediaUrl('hero') }}" alt="{{ $post->title }}"
                class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="absolute inset-0" style="background: linear-gradient(180deg, #161515ee 0%, #161515ff 100%);"></div>
        @else
            <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);">
            </div>
        @endif
        <div class="absolute inset-0 glow-hero opacity-40"></div>

        <div class="relative container-x max-w-3xl">
            <a href="/journal"
                class="text-charcoal-300 text-xs uppercase tracking-widest hover:text-gold-400 transition mb-6 inline-block">
                ← Back to Journal
            </a>

            @if ($post->category)
                <div class="section-label mb-5">{{ $post->category->name }}</div>
            @endif

            <h1
                class="text-3xl md:text-5xl lg:text-6xl font-display tracking-tightest text-cream-100 leading-[1.1] text-balance mb-6">
                {{ $post->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-4 text-charcoal-300 text-xs uppercase tracking-widest">
                <span>{{ $post->published_at?->format('F j, Y') }}</span>
                <span>·</span>
                <span>{{ $post->reading_time }} min read</span>
                @if ($post->tags)
                    <span>·</span>
                    <span>{{ implode(' · ', $post->tags) }}</span>
                @endif
            </div>
        </div>
    </section>

    {{-- Body --}}
    <x-section>
        <div class="max-w-3xl mx-auto">
            @if ($post->hasMedia('hero'))
                <img src="{{ $post->getFirstMediaUrl('hero') }}" alt="{{ $post->title }}"
                    class="w-full aspect-[16/9] object-cover mb-12">
            @endif

            <div class="prose prose-invert prose-lg max-w-none
                        prose-headings:font-display prose-headings:tracking-tightest prose-headings:uppercase prose-headings:text-cream-100
                        prose-p:text-charcoal-200 prose-p:leading-relaxed
                        prose-a:text-gold-400 prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-cream-100
                        prose-li:text-charcoal-200
                        prose-blockquote:border-gold-500 prose-blockquote:text-charcoal-200
                        prose-code:text-gold-400 prose-code:bg-charcoal-800 prose-code:px-1 prose-code:py-0.5">
                {!! $post->body !!}
            </div>
        </div>
    </x-section>

    {{-- Gallery --}}
    @if ($post->hasMedia('gallery'))
        <x-section variant="dark">
            <div class="max-w-3xl mx-auto">
                <div class="section-label mb-5">Gallery</div>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($post->getMedia('gallery') as $media)
                        <div class="aspect-[4/3] overflow-hidden bg-charcoal-800">
                            <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" loading="lazy"
                                class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        </x-section>
    @endif

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <x-section variant="dark">
            <x-section-heading label="Related Posts" title="Read next." />

            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($related as $r)
                    <a href="/journal/{{ $r->slug }}" class="group block">
                        <div class="aspect-[4/3] overflow-hidden bg-charcoal-800 mb-4">
                            @if ($r->hasMedia('hero'))
                                <img src="{{ $r->getFirstMediaUrl('hero', 'thumb') }}" alt="{{ $r->title }}" loading="lazy"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @endif
                        </div>
                        <h3
                            class="font-display tracking-tightest text-cream-100 text-lg uppercase group-hover:text-gold-400 transition-colors leading-tight">
                            {{ $r->title }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </x-section>
    @endif

    <x-cta-section />

@endsection