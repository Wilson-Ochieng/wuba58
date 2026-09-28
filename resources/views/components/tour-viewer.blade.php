@props(['scenes', 'startScene'])

@php
    // Build the Pannellum scene config from DB
    $pannellumScenes = [];

    foreach ($scenes as $scene) {
        if (! $scene->hasMedia('panorama')) {
            continue;
        }

        $hotSpots = [];

        foreach ($scene->hotspots as $hotspot) {
            if ($hotspot->type === 'scene' && $hotspot->targetScene && $hotspot->targetScene->hasMedia('panorama')) {
                $hotSpots[] = [
                    'pitch'    => (float) $hotspot->pitch,
                    'yaw'      => (float) $hotspot->yaw,
                    'type'     => 'scene',
                    'text'     => $hotspot->label ?: 'Move forward',
                    'sceneId'  => $hotspot->targetScene->slug,
                    'targetYaw'   => (float) $hotspot->targetScene->initial_yaw,
                    'targetPitch' => (float) $hotspot->targetScene->initial_pitch,
                    'cssClass' => 'arrow-hotspot',
                ];
            } elseif ($hotspot->type === 'info') {
                $hotSpots[] = [
                    'pitch'    => (float) $hotspot->pitch,
                    'yaw'      => (float) $hotspot->yaw,
                    'type'     => 'info',
                    'text'     => $hotspot->label ?: $hotspot->description ?: 'Info',
                    'cssClass' => 'info-hotspot',
                ];
            } elseif ($hotspot->type === 'url' && $hotspot->url) {
                $hotSpots[] = [
                    'pitch'    => (float) $hotspot->pitch,
                    'yaw'      => (float) $hotspot->yaw,
                    'type'     => 'info',
                    'text'     => $hotspot->label ?: 'Open link',
                    'URL'      => $hotspot->url,
                    'cssClass' => 'info-hotspot',
                ];
            }
        }

        $pannellumScenes[$scene->slug] = [
            'title'     => $scene->name,
            'type'      => 'equirectangular',
            'panorama'  => parse_url($scene->getFirstMediaUrl('panorama'), PHP_URL_PATH),
            'hfov'      => (float) ($scene->initial_hfov ?: 100),
            'yaw'       => (float) ($scene->initial_yaw ?: 0),
            'pitch'     => (float) ($scene->initial_pitch ?: 0),
            'hotSpots'  => $hotSpots,
        ];
    }

    $tourConfig = [
        'default' => [
            'firstScene'        => $startScene->slug,
            'sceneFadeDuration' => 1000,
            'autoLoad'          => true,
            'autoRotate'        => -2,
            'autoRotateInactivityDelay' => 2000,
            'showControls'      => true,
            'showFullscreenCtrl'=> true,
            'showZoomCtrl'      => false,
            'compass'           => true,       // Pannellum's built-in compass ring
            'northOffset'       => 0,
            'backgroundColor'   => [22, 21, 21],
            'hfov'              => 100,
            'minHfov'           => 50,
            'maxHfov'           => 120,
            'escapeHTML'        => true,
        ],
        'scenes' => $pannellumScenes,
    ];
@endphp

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/pannellum/pannellum.css') }}">
        <style>
            /* ─── Base viewer theme ─── */
            .pnlm-container { background: #161515 !important; font-family: Inter, sans-serif !important; }

            /* ─── Loading ─── */
            .pnlm-load-box {
                background: rgba(22,21,21,0.92) !important;
                border: 1px solid rgba(236,177,67,0.3) !important;
                padding: 24px 32px !important;
            }
            .pnlm-lbar { background: rgba(236,177,67,0.15) !important; height: 3px !important; }
            .pnlm-lbar-fill { background: linear-gradient(90deg, #EFC967, #E48633) !important; }
            .pnlm-lmsg { color: #F4F0E8 !important; }
            .pnlm-about-msg { display: none !important; }

            /* ─── Controls ─── */
            .pnlm-ctrl {
                background: rgba(22,21,21,0.85) !important;
                border: 1px solid rgba(236,177,67,0.3) !important;
                color: #F4F0E8 !important;
                border-radius: 0 !important;
            }
            .pnlm-ctrl:hover {
                background: linear-gradient(135deg, #EFC967, #E48633) !important;
                color: #161515 !important;
            }

            /* ─── Compass ring (top-right) ─── */
            .pnlm-compass {
                width: 60px !important;
                height: 60px !important;
                right: 20px !important;
                top: 20px !important;
                background-color: transparent !important;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='46' fill='rgba(22,21,21,0.75)' stroke='rgba(236,177,67,0.5)' stroke-width='1.5'/%3E%3Ctext x='50' y='22' text-anchor='middle' fill='%23ECB143' font-size='14' font-weight='700' font-family='Inter, sans-serif'%3EN%3C/text%3E%3Cpath d='M50 30 L46 50 L50 46 L54 50 Z' fill='%23ECB143'/%3E%3Cpath d='M50 70 L46 50 L50 54 L54 50 Z' fill='%23F4F0E8' opacity='0.4'/%3E%3C/svg%3E") !important;
                background-size: contain !important;
                background-repeat: no-repeat !important;
                background-position: center !important;
                border: none !important;
                box-shadow: 0 4px 20px -4px rgba(0,0,0,0.6) !important;
            }

            /* ─── Scene hotspot: chevron arrow (Street View style) ─── */
            .arrow-hotspot {
                width: 56px !important;
                height: 56px !important;
                background: none !important;
                border: none !important;
                position: relative;
                cursor: pointer;
                transition: transform 0.3s ease;
                filter: drop-shadow(0 6px 16px rgba(0,0,0,0.7));
                /* Point the hotspot toward the floor */
                transform: translateY(30px);
            }
            .arrow-hotspot::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 56 56'%3E%3Cg%3E%3Ccircle cx='28' cy='28' r='26' fill='rgba(22,21,21,0.55)' stroke='%23ECB143' stroke-width='1.5' opacity='0.9'/%3E%3Cpath d='M28 14 L18 32 L25 32 L25 44 L31 44 L31 32 L38 32 Z' fill='%23ECB143'/%3E%3C/g%3E%3C/svg%3E");
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
                animation: arrow-pulse 2s ease-in-out infinite;
            }
            .arrow-hotspot:hover::before {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 56 56'%3E%3Cg%3E%3Ccircle cx='28' cy='28' r='26' fill='%23ECB143' stroke='%23ECB143' stroke-width='2'/%3E%3Cpath d='M28 14 L18 32 L25 32 L25 44 L31 44 L31 32 L38 32 Z' fill='%23161515'/%3E%3C/g%3E%3C/svg%3E");
                animation: none;
            }
            .arrow-hotspot:hover { transform: translateY(28px) scale(1.15); }

            @keyframes arrow-pulse {
                0%, 100% { opacity: 0.85; }
                50%      { opacity: 1; }
            }

            /* ─── Hotspot label (text below arrow) ─── */
            .arrow-hotspot .pnlm-hotspot-text,
            .pnlm-hotspot.arrow-hotspot > div {
                position: absolute !important;
                left: 50% !important;
                top: 100% !important;
                transform: translateX(-50%) !important;
                margin-top: 8px !important;
                white-space: nowrap;
                background: rgba(22,21,21,0.9) !important;
                border: 1px solid rgba(236,177,67,0.4) !important;
                color: #F4F0E8 !important;
                padding: 6px 12px !important;
                font-size: 11px !important;
                letter-spacing: 0.15em !important;
                text-transform: uppercase !important;
                font-weight: 600 !important;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.25s ease;
            }
            .arrow-hotspot:hover .pnlm-hotspot-text,
            .pnlm-hotspot.arrow-hotspot:hover > div {
                opacity: 1 !important;
            }

            /* ─── Info hotspot (small dot) ─── */
            .info-hotspot {
                width: 24px !important;
                height: 24px !important;
                background: rgba(22,21,21,0.85) !important;
                border: 2px solid #ECB143 !important;
                border-radius: 50% !important;
                box-shadow: 0 0 12px rgba(236,177,67,0.6);
                cursor: pointer;
                transition: transform 0.2s ease;
            }
            .info-hotspot::before {
                content: 'i';
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ECB143;
                font-weight: 700;
                font-size: 12px;
                font-family: Inter, sans-serif;
            }
            .info-hotspot:hover {
                background: #ECB143 !important;
                transform: scale(1.2);
            }
            .info-hotspot:hover::before { color: #161515; }

            /* ─── Mobile ─── */
            @media (max-width: 640px) {
                .arrow-hotspot { width: 44px !important; height: 44px !important; }
                .arrow-hotspot .pnlm-hotspot-text { display: none !important; }
                .pnlm-compass { width: 46px !important; height: 46px !important; right: 12px !important; top: 12px !important; }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('vendor/pannellum/pannellum.js') }}"></script>
    @endpush
@endonce

<div class="relative">
    <div class="relative" style="width: 100%; height: 70vh; min-height: 520px; max-height: 820px; background: #0e0d0c; border: 1px solid rgba(236,177,67,0.15); overflow: hidden;">
        <div id="tour-viewer" style="width: 100%; height: 100%;"></div>

        {{-- Info overlay top-left --}}
        <div class="absolute top-4 left-4 px-4 py-3 hidden md:block"
             style="background: rgba(22,21,21,0.85); border: 1px solid rgba(236,177,67,0.2); backdrop-filter: blur(8px);">
            <div class="text-gradient-gold text-xs uppercase tracking-widest font-semibold">
                Interactive 360° Tour
            </div>
            <div class="text-charcoal-300 text-xs mt-1">
                Drag to look around · Click arrows to move
            </div>
        </div>

        {{-- Scene name (bottom-left) --}}
        <div class="absolute bottom-4 left-4 px-4 py-2 hidden md:block"
             style="background: rgba(22,21,21,0.85); border: 1px solid rgba(236,177,67,0.2); backdrop-filter: blur(8px);">
            <div class="text-charcoal-400 text-[10px] uppercase tracking-widest mb-0.5">Current scene</div>
            <div id="current-scene-name" class="text-cream-100 text-sm font-semibold">
                {{ $startScene->name }}
            </div>
        </div>
    </div>

    {{-- Scene list below --}}
    <div class="mt-8 flex flex-wrap justify-center gap-3">
        @foreach ($scenes as $scene)
            @if ($scene->hasMedia('panorama'))
                <button
                    type="button"
                    data-scene-id="{{ $scene->slug }}"
                    onclick="window.wubaTour && window.wubaTour.loadScene('{{ $scene->slug }}')"
                    class="scene-nav-btn px-4 py-2 text-xs uppercase tracking-widest text-charcoal-200 transition-all duration-300 hover:border-gold-500/60 hover:text-gold-400 {{ $scene->slug === $startScene->slug ? 'active text-gold-400' : '' }}"
                    style="border: 1px solid {{ $scene->slug === $startScene->slug ? 'rgba(236,177,67,0.6)' : 'rgba(239,201,103,0.15)' }};"
                >
                    {{ $scene->name }}
                </button>
            @endif
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof pannellum === 'undefined') {
            console.warn('Pannellum not loaded');
            return;
        }

        var config = @json($tourConfig);

        if (!config.scenes || Object.keys(config.scenes).length === 0) {
            console.warn('No scenes configured');
            return;
        }

        // Add hfov to firstScene-only fallback
        var viewer = pannellum.viewer('tour-viewer', config);
        window.wubaTour = viewer;

        // Update scene name when scene changes
        function updateSceneUI(sceneId) {
            var nameEl = document.getElementById('current-scene-name');
            if (nameEl && config.scenes[sceneId]) {
                nameEl.textContent = config.scenes[sceneId].title;
            }

            document.querySelectorAll('.scene-nav-btn').forEach(function (btn) {
                var isActive = btn.dataset.sceneId === sceneId;
                btn.classList.toggle('active', isActive);
                btn.classList.toggle('text-gold-400', isActive);
                btn.style.borderColor = isActive ? 'rgba(236,177,67,0.6)' : 'rgba(239,201,103,0.15)';
            });
        }

        viewer.on('scenechange', function (sceneId) {
            updateSceneUI(sceneId);
        });

        // Pause auto-rotate while user is interacting
        viewer.on('mousedown', function () { viewer.stopAutoRotate(); });
        viewer.on('touchstart', function () { viewer.stopAutoRotate(); });

        // Restart auto-rotate after 8s of inactivity
        var idleTimer;
        function scheduleAutoRotate() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(function () {
                viewer.startAutoRotate(-2);
            }, 8000);
        }
        viewer.on('mousedown', scheduleAutoRotate);
        viewer.on('touchstart', scheduleAutoRotate);
        viewer.on('mouseup', scheduleAutoRotate);
        viewer.on('touchend', scheduleAutoRotate);
        scheduleAutoRotate();

        updateSceneUI('{{ $startScene->slug }}');
    });
</script>