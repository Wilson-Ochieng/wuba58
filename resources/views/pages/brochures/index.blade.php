@extends('layouts.app')

@section('title', 'E-Brochures — Wuba 58 City Models')
@section('description', 'Download our architectural model and 3D visualization brochures — PDF guides for developers, architects, and investors.')

@section('content')

<x-page-hero
    label="Downloads"
    title="E-Brochures"
    description="Detailed guides covering our services, capabilities, and project experience. Fill in your details and we'll email you the PDF instantly."
/>

<x-section>
    @if ($brochures->isEmpty())
        <div class="card-elegant p-12 text-center text-charcoal-300">
            No brochures yet. Check back soon.
        </div>
    @else
        <div data-reveal-stagger class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($brochures as $brochure)
                <a href="{{ route('brochures.show', $brochure->slug) }}" class="group block">
                    <div class="aspect-[4/5] overflow-hidden bg-charcoal-800 relative mb-5">
                        @if ($brochure->hasMedia('cover'))
                            <img src="{{ $brochure->getFirstMediaUrl('cover') }}"
                                 alt="{{ $brochure->title }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-charcoal-500 p-6 text-center"
                                 style="background: linear-gradient(160deg, #1e1e1e 0%, #2a1a0f 100%);">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 mb-4 text-gold-500 opacity-40">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <div class="font-display tracking-widest text-xs uppercase text-charcoal-400">
                                    PDF Brochure
                                </div>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4 px-3 py-1.5 text-xs uppercase tracking-widest text-cream-100 backdrop-blur-sm"
                             style="background: rgba(22,21,21,0.6); border: 1px solid rgba(236,177,67,0.3);">
                            PDF
                        </div>
                    </div>

                    <h3 class="font-display tracking-tightest text-cream-100 text-lg uppercase group-hover:text-gold-400 transition-colors">
                        {{ $brochure->title }}
                    </h3>

                    @if ($brochure->description)
                        <p class="text-charcoal-300 text-sm leading-relaxed mt-2 line-clamp-2">
                            {{ $brochure->description }}
                        </p>
                    @endif

                    <div class="mt-4 flex items-center gap-4 text-xs uppercase tracking-widest text-charcoal-400">
                        <span>{{ $brochure->download_count }} {{ Str::plural('download', $brochure->download_count) }}</span>
                        @if ($brochure->file_size)
                            <span>·</span>
                            <span>{{ $brochure->file_size }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-section>

<x-cta-section />

@endsection