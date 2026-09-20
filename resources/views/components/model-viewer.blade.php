
@props(['project'])

@php
    $modelUrl = $project->hasMedia('model')
        ? $project->getFirstMediaUrl('model')
        : asset('models/sample.glb');
    $hotspots = $project->hotspots;
    $viewerId = 'mv-' . $project->id;
@endphp

{{-- Load model-viewer script only once per page --}}
@once
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
@endonce

<div
    x-data="{ activeHotspot: null }"
    class="relative w-full"
>
    <div class="relative aspect-[16/10] md:aspect-[16/9] bg-charcoal-900 card-elegant overflow-hidden">

        <model-viewer
            id="{{ $viewerId }}"
            src="{{ $modelUrl }}"
            alt="{{ $project->title }} 3D model"
            camera-controls
            auto-rotate
            auto-rotate-delay="3000"
            rotation-per-second="20deg"
            shadow-intensity="1"
            exposure="1"
            environment-image="neutral"
            camera-orbit="45deg 65deg 3m"
            min-camera-orbit="auto 20deg 1.5m"
            max-camera-orbit="auto 90deg 8m"
            touch-action="pan-y"
            draco-decoder-location="https://www.gstatic.com/draco/versioned/decoders/1.5.7/"
            style="width: 100%; height: 100%; background: transparent; --poster-color: transparent;"
        >
            {{-- Hotspots from DB --}}
            @foreach ($hotspots as $hotspot)
                <button
                    slot="hotspot-{{ $hotspot->id }}"
                    data-position="{{ $hotspot->position_x }} {{ $hotspot->position_y }} {{ $hotspot->position_z }}"
                    data-normal="{{ $hotspot->normal_x }} {{ $hotspot->normal_y }} {{ $hotspot->normal_z }}"
                    data-visibility-attribute="visible"
                    @click="activeHotspot = activeHotspot === {{ $hotspot->id }} ? null : {{ $hotspot->id }}"
                    class="hotspot-btn"
                    style="--hotspot-color: {{ $hotspot->color }};"
                    aria-label="{{ $hotspot->label }}"
                >
                    <span class="hotspot-dot"></span>
                    <span class="hotspot-label">{{ $hotspot->label }}</span>
                </button>
            @endforeach
        </model-viewer>

        {{-- Hotspot info panel --}}
        <div
            x-show="activeHotspot"
            x-transition.opacity
            x-cloak
            @click.outside="activeHotspot = null"
            class="absolute top-4 right-4 max-w-xs p-5 text-cream-100"
            style="background: rgba(22,21,21,0.9); border: 1px solid rgba(236,177,67,0.3); backdrop-filter: blur(12px);"
        >
            @foreach ($hotspots as $hotspot)
                <div x-show="activeHotspot === {{ $hotspot->id }}" x-cloak>
                    <div class="text-gradient-gold text-xs tracking-widest uppercase mb-2">
                        {{ $hotspot->label }}
                    </div>
                    @if ($hotspot->description)
                        <p class="text-charcoal-200 text-sm leading-relaxed">{{ $hotspot->description }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Instruction chip --}}
        <div class="absolute bottom-4 left-4 px-3 py-2 text-xs uppercase tracking-widest text-charcoal-200 hidden md:flex items-center gap-2 pointer-events-none"
             style="background: rgba(22,21,21,0.7); border: 1px solid rgba(239,201,103,0.2); backdrop-filter: blur(8px);">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
            </svg>
            Drag to rotate · Scroll to zoom
        </div>
    </div>

    {{-- Hotspot legend below viewer --}}
    @if ($hotspots->isNotEmpty())
        <div class="mt-6 flex flex-wrap gap-3">
            @foreach ($hotspots as $hotspot)
                <button
                    @click="activeHotspot = activeHotspot === {{ $hotspot->id }} ? null : {{ $hotspot->id }}"
                    :class="activeHotspot === {{ $hotspot->id }} ? 'text-gold-400 border-gold-500/60' : 'text-charcoal-200 border-charcoal-700'"
                    class="px-4 py-2 text-xs uppercase tracking-widest transition-all duration-300 hover:border-gold-500/60 hover:text-gold-400"
                    style="border-width: 1px;"
                >
                    {{ $hotspot->label }}
                </button>
            @endforeach
        </div>
    @endif
</div>

@once
    <style>
        .hotspot-btn {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px 6px 8px;
            background: rgba(22,21,21,0.85);
            border: 1px solid var(--hotspot-color, #ECB143);
            color: #F4F0E8;
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
            white-space: nowrap;
        }
        .hotspot-btn:hover {
            background: var(--hotspot-color, #ECB143);
            color: #161515;
        }
        .hotspot-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--hotspot-color, #ECB143);
            box-shadow: 0 0 12px var(--hotspot-color, #ECB143);
            flex-shrink: 0;
        }
        .hotspot-btn:hover .hotspot-dot {
            background: #161515;
            box-shadow: none;
        }
        @media (max-width: 640px) {
            .hotspot-label { display: none; }
            .hotspot-btn { padding: 6px; }
        }
    </style>
@endonce