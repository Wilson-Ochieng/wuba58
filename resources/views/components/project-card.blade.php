@props(['project'])

<a href="{{ route('work.show', $project->slug) }}" class="group block">
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