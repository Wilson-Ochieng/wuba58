@extends('layouts.app')

@section('title', '3D Physical Models — Wuba 58 City Models')
@section('description', 'Explore interactive 3D models of our physical architectural scale models.')

@section('content')

    <x-page-hero
        label="Interactive 3D"
        title="Physical Models"
        description="Rotate, zoom, and explore our physical scale models in full 3D. Each model is a real Wuba 58 build — captured and delivered to you in the browser."
    />

    @if ($projects->isEmpty())
        <x-section variant="dark">
            <div class="card-elegant p-12 md:p-16 text-center max-w-2xl mx-auto">
                <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-4">
                    Coming Soon
                </div>
                <p class="text-charcoal-200 leading-relaxed mb-8">
                    Interactive 3D model viewing is being finalized. Check back shortly, or browse our full portfolio.
                </p>
                <x-btn href="/work" variant="primary">View Portfolio</x-btn>
            </div>
        </x-section>
    @else
        @foreach ($projects as $index => $project)
            <x-section :variant="$index % 2 === 0 ? 'dark' : 'default'" padding="lg">
                <x-section-heading
                    :label="$project->category ? ucfirst(str_replace('_', ' ', $project->category)) : 'Model'"
                    :title="$project->title"
                >
                    {{ $project->excerpt }}
                </x-section-heading>

                @php
                    $modelUrl = parse_url($project->getFirstMediaUrl('model'), PHP_URL_PATH);
                @endphp

                <div style="width: 100%; height: 600px; background: #0e0d0c; border: 1px solid rgba(236,177,67,0.15); overflow: hidden; position: relative;">
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
                        style="width: 100%; height: 100%; background: #0e0d0c; --poster-color: #0e0d0c;"
                    >
                        @foreach ($project->hotspots as $hotspot)
                            <button
                                slot="hotspot-{{ $hotspot->id }}"
                                data-position="{{ $hotspot->position_x }} {{ $hotspot->position_y }} {{ $hotspot->position_z }}"
                                data-normal="{{ $hotspot->normal_x }} {{ $hotspot->normal_y }} {{ $hotspot->normal_z }}"
                                data-visibility-attribute="visible"
                                style="display: flex; align-items: center; gap: 8px; padding: 6px 12px; background: rgba(22,21,21,0.85); border: 1px solid {{ $hotspot->color }}; color: #F4F0E8; font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; font-weight: 600; cursor: pointer; white-space: nowrap;"
                            >
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $hotspot->color }};"></span>
                                {{ $hotspot->label }}
                            </button>
                        @endforeach
                    </model-viewer>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <p class="text-charcoal-300 text-xs uppercase tracking-widest">
                        Drag to rotate · Scroll to zoom
                    </p>
                    <x-btn href="/work/{{ $project->slug }}" variant="outline" size="sm">
                        View full project →
                    </x-btn>
                </div>
            </x-section>
        @endforeach
    @endif

    <x-cta-section />

    <script type="module" src="{{ asset('js/model-viewer.min.js') }}"></script>

@endsection