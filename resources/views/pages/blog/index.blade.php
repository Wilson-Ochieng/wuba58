@extends('layouts.app')

@section('title', 'Journal — Wuba 58 City Models')
@section('description', 'Insights, project updates, and news from Wuba 58 City Models.')

@section('content')

    <x-page-hero label="Journal" title="News & Insights"
        description="Project updates, model-making craft, and thoughts on architectural presentation from the Wuba 58 studio." />

    <x-section>
        @if (isset($categories) && $categories->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-12">
                <a href="/journal" class="px-4 py-2 text-xs uppercase tracking-widest transition-colors
                          {{ !request('category') ? 'text-gold-400' : 'text-charcoal-200 hover:text-gold-400' }}"
                    style="border: 1px solid {{ !request('category') ? 'rgba(236,177,67,0.6)' : 'rgba(239,201,103,0.15)' }};">
                    All
                </a>
                @foreach ($categories as $cat)
                    <a href="/journal?category={{ $cat->slug }}"
                        class="px-4 py-2 text-xs uppercase tracking-widest transition-colors
                                  {{ request('category') === $cat->slug ? 'text-gold-400' : 'text-charcoal-200 hover:text-gold-400' }}"
                        style="border: 1px solid {{ request('category') === $cat->slug ? 'rgba(236,177,67,0.6)' : 'rgba(239,201,103,0.15)' }};">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        @endif
        {{-- Featured post --}}
        @if ($featured)
            <a href="/journal/{{ $featured->slug }}" class="group block mb-16 md:mb-24">
                <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <div class="aspect-[4/3] overflow-hidden bg-charcoal-800">
                        @if ($featured->hasMedia('hero'))
                            <img src="{{ $featured->getFirstMediaUrl('hero', 'thumb') }}" alt="{{ $featured->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-charcoal-500 text-sm">
                                {{ $featured->title }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="section-label mb-5">
                            Featured
                            @if ($featured->category)
                                · {{ $featured->category->name }}
                            @endif
                        </div>
                        <h2
                            class="text-3xl md:text-4xl lg:text-5xl font-display tracking-tightest text-cream-100 mb-6 group-hover:text-gold-400 transition-colors leading-tight">
                            {{ $featured->title }}
                        </h2>
                        <p class="text-charcoal-200 text-lg leading-relaxed mb-6">
                            {{ $featured->excerpt }}
                        </p>
                        <div class="flex items-center gap-4 text-charcoal-400 text-xs uppercase tracking-widest">
                            <span>{{ $featured->published_at?->format('M j, Y') }}</span>
                            <span>·</span>
                            <span>{{ $featured->reading_time }} min read</span>
                        </div>
                    </div>
                </div>
            </a>
        @endif

        {{-- All posts --}}
        @if ($posts->isEmpty())
            <div class="card-elegant p-12 text-center text-charcoal-300">
                No posts yet. Check back soon.
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $post)
                    <a href="/journal/{{ $post->slug }}" class="group block">
                        <div class="aspect-[4/3] overflow-hidden bg-charcoal-800 mb-5">
                            @if ($post->hasMedia('hero'))
                                <img src="{{ $post->getFirstMediaUrl('hero', 'thumb') }}" alt="{{ $post->title }}" loading="lazy"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-charcoal-500 text-sm">
                                    {{ $post->title }}
                                </div>
                            @endif
                        </div>
                        @if ($post->category)
                            <div class="text-xs uppercase tracking-widest mb-3" style="color: {{ $post->category->color }};">
                                {{ $post->category->name }}
                            </div>
                        @endif

                        <h3
                            class="font-display tracking-tightest text-cream-100 text-xl mb-3 uppercase group-hover:text-gold-400 transition-colors leading-tight">
                            {{ $post->title }}
                        </h3>
                        @if ($post->excerpt)
                            <p class="text-charcoal-300 text-sm leading-relaxed mb-4 line-clamp-3">
                                {{ $post->excerpt }}
                            </p>
                        @endif
                        <div class="text-charcoal-400 text-xs uppercase tracking-widest">
                            {{ $post->published_at?->format('M j, Y') }} · {{ $post->reading_time }} min
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($posts->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </x-section>

    <x-cta-section />

@endsection