{{-- ═════════ 3D MODEL VIEWER ═════════ --}}
@php
    $modelUrl = $project->hasMedia('model')
        ? $project->getFirstMediaUrl('model')
        : 'https://modelviewer.dev/shared-assets/models/Astronaut.glb';
@endphp

<section class="py-20 md:py-28" style="background: linear-gradient(180deg, #161515 0%, #232222 50%, #161515 100%);">
    {{-- Script BEFORE the element so model-viewer is defined first --}}
    <script type="module" src="{{ asset('js/model-viewer.min.js') }}"></script>

    <div class="container-x">
        <div class="text-center mb-12">
            <div class="section-label mb-5">Interactive Model</div>
            <h2 class="text-3xl md:text-5xl font-display tracking-tightest text-cream-100">
                Explore in 3D
            </h2>
        </div>

        <div style="width: 100%; height: 600px; background: #0e0d0c; border: 1px solid rgba(236,177,67,0.15); overflow: hidden;">
            <model-viewer
                src="{{ $modelUrl }}"
                alt="{{ $project->title }} 3D model"
                camera-controls
                auto-rotate
                auto-rotate-delay="2000"
                rotation-per-second="20deg"
                environment-image="neutral"
                exposure="1.4"
                shadow-intensity="0.8"
                camera-orbit="0deg 75deg auto"
                touch-action="pan-y"
                loading="eager"
                draco-decoder-location="https://www.gstatic.com/draco/versioned/decoders/1.5.7/"
                style="width: 100%; height: 100%; background: #0e0d0c; --poster-color: #0e0d0c;"
            >
                @foreach ($project->hotspots as $hotspot)
                    <button
                        slot="hotspot-{{ $hotspot->id }}"
                        data-position="{{ $hotspot->position_x }} {{ $hotspot->position_y }} {{ $hotspot->position_z }}"
                        data-normal="{{ $hotspot->normal_x }} {{ $hotspot->normal_y }} {{ $hotspot->normal_z }}"
                        data-visibility-attribute="visible"
                        style="
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            padding: 6px 12px;
                            background: rgba(22,21,21,0.85);
                            border: 1px solid {{ $hotspot->color }};
                            color: #F4F0E8;
                            font-size: 11px;
                            letter-spacing: 0.15em;
                            text-transform: uppercase;
                            font-weight: 600;
                            cursor: pointer;
                            white-space: nowrap;
                        "
                    >
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $hotspot->color }};"></span>
                        {{ $hotspot->label }}
                    </button>
                @endforeach
            </model-viewer>
        </div>

        <p class="text-center text-charcoal-300 text-sm mt-6 uppercase tracking-widest">
            Drag to rotate · Scroll to zoom
        </p>

        @if ($project->hotspots->isNotEmpty())
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                @foreach ($project->hotspots as $hotspot)
                    <span class="px-4 py-2 text-xs uppercase tracking-widest text-charcoal-200"
                          style="border: 1px solid rgba(236,177,67,0.3);">
                        {{ $hotspot->label }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</section>