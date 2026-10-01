@extends('layouts.app')

@section('title', 'Search — Wuba 58 City Models')
@section('description', 'Search across projects, services, journal articles, and FAQs.')

@section('content')

    <section class="relative pt-48 pb-16 md:pt-56 md:pb-20 overflow-hidden">
        <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);">
        </div>
        <div class="absolute inset-0 glow-hero opacity-70"></div>

        <div class="relative container-x max-w-3xl">
            <div class="section-label mb-6">Search</div>
            <h1 class="text-3xl md:text-5xl font-display tracking-tightest text-cream-100 mb-10">
                What are you looking for?
            </h1>

            <form method="GET" action="/search" class="relative">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search projects, services, articles…"
                    class="w-full bg-charcoal-800 border border-charcoal-700 pl-14 pr-4 py-5 text-base text-cream-100 placeholder-charcoal-400 focus:border-gold-500 focus:outline-none transition-colors"
                    autofocus>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-charcoal-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </form>
        </div>
    </section>

    <x-section>
        @if (strlen($query) < 2)
            <div class="max-w-2xl mx-auto text-center py-16">
                <p class="text-charcoal-300 text-lg">
                    Type at least two characters to search.
                </p>
            </div>
        @else
            {{-- Results header --}}
            <div class="max-w-4xl mx-auto mb-10">
                <div class="text-charcoal-300 text-sm">
                    @if ($total > 0)
                        Found <span class="text-gold-400 font-semibold">{{ $total }}</span>
                        {{ Str::plural('result', $total) }} for
                        "<span class="text-cream-100">{{ $query }}</span>"
                    @else
                        No results for "<span class="text-cream-100">{{ $query }}</span>"
                    @endif
                </div>
            </div>

            {{-- Filter pills --}}
            @if ($total > 0 || $query !== '')
                <div class="max-w-4xl mx-auto flex flex-wrap gap-2 mb-12">
                    @php
                        $tabs = [
                            'all' => 'All' . ($type === 'all' && $total ? ' (' . $total . ')' : ''),
                            'projects' => 'Projects' . ($counts['projects'] ? ' (' . $counts['projects'] . ')' : ''),
                            'services' => 'Services' . ($counts['services'] ? ' (' . $counts['services'] . ')' : ''),
                            'posts' => 'Journal' . ($counts['posts'] ? ' (' . $counts['posts'] . ')' : ''),
                            'faqs' => 'FAQ' . ($counts['faqs'] ? ' (' . $counts['faqs'] . ')' : ''),
                            'testimonials' => 'Testimonials' . ($counts['testimonials'] ? ' (' . $counts['testimonials'] . ')' : ''),
                        ];
                    @endphp
                    @foreach ($tabs as $key => $label)
                        <a href="/search?q={{ urlencode($query) }}&type={{ $key }}" class="px-4 py-2 text-xs uppercase tracking-widest transition-colors
                                              {{ $type === $key ? 'text-gold-400' : 'text-charcoal-200 hover:text-gold-400' }}"
                            style="border: 1px solid {{ $type === $key ? 'rgba(236,177,67,0.6)' : 'rgba(239,201,103,0.15)' }};">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Results list --}}
            @if ($total > 0)
                <div class="max-w-4xl mx-auto space-y-4">
                    @foreach ($results as $result)
                        <a href="{{ $result['url'] }}" class="card-elegant p-6 flex gap-5 group">
                            @if ($result['image'])
                                <div class="w-24 h-24 flex-shrink-0 overflow-hidden bg-charcoal-800">
                                    <img src="{{ $result['image'] }}" alt="{{ $result['title'] }}" loading="lazy"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="w-24 h-24 flex-shrink-0 flex items-center justify-center text-charcoal-500 text-xs uppercase tracking-widest"
                                    style="background: linear-gradient(180deg, rgba(65,64,63,0.35) 0%, rgba(35,34,34,0.35) 100%); border: 1px solid rgba(239,201,103,0.08);">
                                    {{ $result['type'] }}
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="text-xs uppercase tracking-widest text-gradient-gold mb-2">
                                    {{ $result['meta'] }}
                                </div>
                                <h3
                                    class="font-display tracking-tightest text-cream-100 text-lg mb-2 uppercase leading-tight group-hover:text-gold-400 transition-colors">
                                    {{ $result['title'] }}
                                </h3>
                                @if ($result['excerpt'])
                                    <p class="text-charcoal-300 text-sm leading-relaxed line-clamp-2">
                                        {{ $result['excerpt'] }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex-shrink-0 self-center text-charcoal-500 group-hover:text-gold-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @elseif (strlen($query) >= 2)
                <div class="max-w-2xl mx-auto text-center py-16">
                    <div class="card-elegant p-10">
                        <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-4">
                            No matches
                        </div>
                        <p class="text-charcoal-300 mb-6">
                            Try different keywords, or browse our portfolio and journal.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <x-btn href="/work" variant="primary">Browse Portfolio</x-btn>
                            <x-btn href="/journal" variant="outline">Read Journal</x-btn>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </x-section>

    <x-cta-section />

@endsection