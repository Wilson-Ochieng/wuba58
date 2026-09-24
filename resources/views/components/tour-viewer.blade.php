@props(['scenes', 'startScene'])

@php
    // Build the Pannellum scene config from DB
    $pannellumScenes = [];

    foreach ($scenes as $scene) {
        if (!$scene->hasMedia('panorama')) {
            continue;
        }

        $hotSpots = [];

        foreach ($scene->hotspots as $hotspot) {
            if ($hotspot->type === 'scene' && $hotspot->targetScene && $hotspot->targetScene->hasMedia('panorama')) {
                $hotSpots[] = [
                    'pitch' => (float) $hotspot->pitch,
                    'yaw' => (float) $hotspot->yaw,
                    'type' => 'scene',
                    'text' => $hotspot->label ?: 'Go here',
                    'sceneId' => $hotspot->targetScene->slug,
                    'targetYaw' => (float) $hotspot->targetScene->initial_yaw,
                    'targetPitch' => (float) $hotspot->targetScene->initial_pitch,
                ];
            } elseif ($hotspot->type === 'info') {
                $hotSpots[] = [
                    'pitch' => (float) $hotspot->pitch,
                    'yaw' => (float) $hotspot->yaw,
                    'type' => 'info',
                    'text' => $hotspot->label ?: $hotspot->description ?: 'Info',
                ];
            } elseif ($hotspot->type === 'url' && $hotspot->url) {
                $hotSpots[] = [
                    'pitch' => (float) $hotspot->pitch,
                    'yaw' => (float) $hotspot->yaw,
                    'type' => 'info',
                    'text' => $hotspot->label ?: 'Open link',
                    'URL' => $hotspot->url,
                ];
            }
        }

        $pannellumScenes[$scene->slug] = [
            'title' => $scene->name,
            'type' => 'equirectangular',
            'panorama' => $scene->getFirstMediaUrl('panorama'),
            'hfov' => (float) ($scene->initial_hfov ?: 100),
            'yaw' => (float) ($scene->initial_yaw ?: 0),
            'pitch' => (float) ($scene->initial_pitch ?: 0),
            'hotSpots' => $hotSpots,
        ];
    }

    $tourConfig = [
        'default' => [
            'firstScene' => $startScene->slug,
            'sceneFadeDuration' => 1000,
            'autoLoad' => true,
            'autoRotate' => -2,
            'showControls' => true,
            'compass' => false,
            'backgroundColor' => [22, 21, 21],
        ],
        'scenes' => $pannellumScenes,
    ];
@endphp

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/pannellum/pannellum.css') }}">
        <style>
            .pnlm-container { background: #161515 !important; }
            .pnlm-load-box { background: rgba(22,21,21,0.9) !important; border: 1px solid rgba(236,177,67,0.3) !important; }
            .pnlm-lbar { background: rgba(236,177,67,0.3) !important; }
            .pnlm-lbar-fill { background: linear-gradient(90deg, #EFC967, #E48633) !important; }
            .pnlm-lmsg { color: #F4F0E8 !important; font-family: Inter, sans-serif !important; }
            .pnlm-about-msg { display: none !important; }
            .pnlm-ctrl { background: rgba(22,21,21,0.85) !important; border-color: rgba(236,177,67,0.3) !important; color: #F4F0E8 !important; }
            .pnlm-ctrl:hover { background: rgba(236,177,67,0.9) !important; color: #161515 !important; }
            .pnlm-hotspot-base { filter: drop-shadow(0 4px 12px rgba(236,177,67,0.5)); }
            .pnlm-hotspot { background: rgba(22,21,21,0.9) !important; border: 1px solid #ECB143 !important; color: #F4F0E8 !important; font-family: Inter, sans-serif !important; font-size: 11px !important; letter-spacing: 0.1em !important; text-transform: uppercase !important; font-weight: 600 !important; padding: 6px 12px !important; backdrop-filter: blur(8px); }
            .pnlm-hotspot:hover { background: #ECB143 !important; color: #161515 !important; }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('vendor/pannellum/pannellum.js') }}"></script>
    @endpush
@endonce

<div
    x-data="{ tourOpen: false }"
    class="relative"
>
    <div class="relative" style="width: 100%; height: 70vh; min-height: 520px; max-height: 820px; background: #0e0d0c; border: 1px solid rgba(236,177,67,0.15); overflow: hidden;">
        <div id="tour-viewer" style="width: 100%; height: 100%;"></div>

        {{-- Info overlay --}}
        <div class="absolute top-4 left-4 px-4 py-3 hidden md:block"
             style="background: rgba(22,21,21,0.85); border: 1px solid rgba(236,177,67,0.2); backdrop-filter: blur(8px);">
            <div class="text-gradient-gold text-xs uppercase tracking-widest font-semibold">
                Interactive 360° Tour
            </div>
            <div class="text-charcoal-300 text-xs mt-1">
                Drag to look around · Click hotspots to move
            </div>
        </div>
    </div>

    {{-- Scene list below --}}
    <div class="mt-8 flex flex-wrap justify-center gap-3">
        @foreach ($scenes as $scene)
            @if ($scene->hasMedia('panorama'))
                <button
                    type="button"
                    onclick="pannellum.viewer('tour-viewer').loadScene('{{ $scene->slug }}')"
                    class="px-4 py-2 text-xs uppercase tracking-widest text-charcoal-200 transition-all duration-300 hover:border-gold-500/60 hover:text-gold-400"
                    style="border: 1px solid rgba(239,201,103,0.15);"
                >
                    {{ $scene->name }}
                </button>
            @endif
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof pannellum === 'undefined') return;

        var config = @json($tourConfig);

        if (!config.scenes || Object.keys(config.scenes).length === 0) return;

        window.pannellumViewer = pannellum.viewer('tour-viewer', config);
    });
</script>