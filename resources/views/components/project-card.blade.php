@props(['project'])

<a href="/work/{{ $project->slug }}" class="group block">
    <div class="aspect-[4/3] overflow-hidden bg-charcoal-800 relative">
        @if ($project->hasMedia('hero'))
            <img src="{{ $project->getFirstMediaUrl('hero', 'thumb') }}"
                 alt="{{ $project->title }}"
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        @else
            <div class="w-full h-full flex items-center justify-center text-charcoal-400 text-sm font-display uppercase tracking-widest">
                {{ $project->title }}
            </div>
        @endif

        {{-- Hover overlay --}}
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
             style="background: linear-gradient(to top, rgba(22,21,21,0.85) 0%, rgba(22,21,21,0.2) 40%, transparent 100%);"></div>

        {{-- Category badge --}}
        <div class="absolute top-4 left-4 px-3 py-1.5 text-xs uppercase tracking-widest text-cream-100 backdrop-blur-sm"
             style="background: rgba(22,21,21,0.6); border: 1px solid rgba(239,201,103,0.2);">
            {{ ucfirst(str_replace('_', ' ', $project->category)) }}
        </div>

        {{-- View Project button — pushed lower --}}
        <div class="absolute inset-x-0 bottom-0 top-auto flex items-end justify-center pb-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            <span class="inline-flex items-center gap-2 px-6 py-3 text-xs uppercase tracking-widest font-semibold text-charcoal-900"
                  style="background: linear-gradient(135deg, #EFC967 0%, #ECB143 50%, #E48633 100%); box-shadow: 0 8px 24px -8px rgba(236,177,67,0.6);">
                View Project
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </div>
    </div>

    <div class="mt-5 flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h3 class="font-display tracking-tightest text-cream-100 text-lg uppercase group-hover:text-gold-400 transition-colors truncate">
                {{ $project->title }}
            </h3>
            <div class="text-charcoal-300 text-sm mt-1 truncate">
                {{ $project->location ?? 'Nairobi, Kenya' }}
            </div>
        </div>

        @if ($project->scale)
            <div class="text-gradient-gold text-xs tracking-widest uppercase whitespace-nowrap pt-1">
                {{ $project->scale }}
            </div>
        @endif
    </div>
</a>