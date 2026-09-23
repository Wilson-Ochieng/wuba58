<div>

    {{-- Filter bar --}}
    <div class="mb-10 md:mb-14">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

            {{-- Category tabs --}}
            <div class="flex flex-wrap gap-2 md:gap-3">
                @php
                    $categories = [
                        'all'         => 'All Work',
                        'residential' => 'Residential',
                        'commercial'  => 'Commercial',
                        'masterplan'  => 'Masterplan',
                        'mixed_use'   => 'Mixed Use',
                    ];
                @endphp

                @foreach ($categories as $key => $label)
                    <button
                        wire:click="setCategory('{{ $key }}')"
                        type="button"
                        class="group px-4 md:px-5 py-2.5 text-xs uppercase tracking-widest transition-all duration-300"
                        style="border: 1px solid {{ $category === $key ? 'rgba(236,177,67,0.7)' : 'rgba(239,201,103,0.15)' }}; {{ $category === $key ? 'background: linear-gradient(135deg, rgba(239,201,103,0.15), rgba(228,134,51,0.08));' : '' }}"
                    >
                        <span class="{{ $category === $key ? 'text-gradient-gold font-semibold' : 'text-charcoal-200 group-hover:text-gold-400' }} transition-colors">
                            {{ $label }}
                        </span>
                        <span class="ml-2 text-charcoal-400 text-[10px]">
                            {{ $counts[$key] }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="relative w-full lg:w-80">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search projects…"
                    class="w-full bg-charcoal-800 border border-charcoal-700 pl-11 pr-11 py-3 text-sm text-cream-100 placeholder-charcoal-400 focus:border-gold-500 focus:outline-none transition-colors"
                >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-charcoal-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

                @if ($search !== '')
                    <button
                        type="button"
                        wire:click="clearSearch"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-charcoal-400 hover:text-gold-400 transition-colors"
                        aria-label="Clear search"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        {{-- Result count --}}
        <div class="text-xs uppercase tracking-widest text-charcoal-400">
            Showing
            <span class="text-gold-400">{{ $projects->firstItem() ?? 0 }}–{{ $projects->lastItem() ?? 0 }}</span>
            of
            <span class="text-gold-400">{{ $projects->total() }}</span>
            {{ Str::plural('project', $projects->total()) }}
            @if ($category !== 'all' || $search !== '')
                <button type="button" wire:click="setCategory('all'); $set('search', '')"
                        class="ml-3 text-charcoal-300 hover:text-gold-400 underline">
                    Clear filters
                </button>
            @endif
        </div>
    </div>

    {{-- Loading overlay --}}
    <div wire:loading.delay.flex wire:target="category,search,setCategory,clearSearch"
         class="hidden items-center justify-center py-24">
        <div class="text-center">
            <div class="inline-block w-8 h-8 border-2 border-gold-500/30 border-t-gold-500 rounded-full animate-spin mb-4"></div>
            <div class="text-xs uppercase tracking-widest text-charcoal-400">Loading projects…</div>
        </div>
    </div>

    {{-- Projects grid --}}
    <div wire:loading.remove wire:target="category,search,setCategory,clearSearch">
        @if ($projects->isEmpty())
            <div class="card-elegant p-12 md:p-16 text-center">
                <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-4">
                    No projects found
                </div>
                <p class="text-charcoal-300 mb-6">
                    @if ($search !== '')
                        Nothing matches "{{ $search }}".
                    @else
                        Nothing published in this category yet.
                    @endif
                </p>
                <button type="button" wire:click="setCategory('all'); $set('search', '')"
                        class="btn-outline text-xs">
                    View all work
                </button>
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-8 md:gap-10">
                @foreach ($projects as $project)
                    <x-project-card :project="$project" wire:key="project-{{ $project->id }}" />
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($projects->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif
        @endif
    </div>
</div>