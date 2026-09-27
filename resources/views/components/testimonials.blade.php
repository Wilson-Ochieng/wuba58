@props(['limit' => 6])

@php
    $testimonials = \App\Models\Testimonial::published()
        ->orderByDesc('featured')
        ->orderBy('order')
        ->take($limit)
        ->get();
@endphp

@if ($testimonials->isNotEmpty())
    <section class="py-24 md:py-32" style="background: linear-gradient(180deg, #161515 0%, #232222 50%, #161515 100%);">
        <div class="container-x">

            <div class="text-center mb-16">
                <div class="section-label mb-5">What Clients Say</div>
                <h2 class="text-3xl md:text-5xl font-display tracking-tightest text-cream-100 max-w-3xl mx-auto">
                    Trusted by developers<br>across the region.
                </h2>
            </div>

            <div
                x-data="{
                    active: 0,
                    total: {{ $testimonials->count() }},
                    interval: null,
                    start() {
                        this.interval = setInterval(() => {
                            this.active = (this.active + 1) % this.total;
                        }, 6500);
                    },
                    stop() { clearInterval(this.interval); },
                    go(i) { this.active = i; this.stop(); this.start(); }
                }"
                x-init="start()"
                @mouseenter="stop()"
                @mouseleave="start()"
                class="relative"
            >
                {{-- Slides --}}
                <div class="relative min-h-[320px] md:min-h-[280px]">
                    @foreach ($testimonials as $i => $t)
                        <div
                            x-show="active === {{ $i }}"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-4"
                            x-cloak
                            class="absolute inset-0"
                        >
                            <div class="card-elegant p-8 md:p-12 max-w-4xl mx-auto h-full flex flex-col">

                                {{-- Rating --}}
                                <div class="text-gold-500 text-2xl tracking-widest mb-6">
                                    {{ str_repeat('★', $t->rating) }}{{ str_repeat('☆', 5 - $t->rating) }}
                                </div>

                                {{-- Quote --}}
                                <blockquote class="text-lg md:text-xl leading-relaxed text-cream-100 mb-8 flex-1">
                                    "{{ $t->body }}"
                                </blockquote>

                                {{-- Author --}}
                                <div class="flex items-center gap-4">
                                    @if ($t->author_avatar_url)
                                        <img src="{{ $t->author_avatar_url }}"
                                             alt="{{ $t->author_name }}"
                                             class="w-12 h-12 rounded-full object-cover"
                                             loading="lazy"
                                             onerror="this.style.display='none'">
                                    @else
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-charcoal-900 font-display text-lg"
                                             style="background: linear-gradient(135deg, #EFC967 0%, #E48633 100%);">
                                            {{ $t->initials }}
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <div class="text-cream-100 font-semibold truncate">
                                            {{ $t->author_name }}
                                        </div>
                                        <div class="text-charcoal-300 text-sm truncate">
                                            @if ($t->author_role) {{ $t->author_role }} @endif
                                            @if ($t->author_role && $t->author_company) · @endif
                                            @if ($t->author_company) {{ $t->author_company }} @endif
                                        </div>
                                    </div>

                                    @if ($t->source === 'google')
                                        <div class="ml-auto flex items-center gap-2 text-charcoal-300 text-xs uppercase tracking-widest">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5">
                                                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.9 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/>
                                                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 18.9 12 24 12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                                                <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.1-11.3-7.6l-6.5 5C9.5 39.6 16.2 44 24 44z"/>
                                                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.2 4.2-4.1 5.6l6.2 5.2C41 35.6 44 30.3 44 24c0-1.3-.1-2.4-.4-3.5z"/>
                                            </svg>
                                            Google
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Dots --}}
                @if ($testimonials->count() > 1)
                    <div class="flex justify-center gap-3 mt-8">
                        @foreach ($testimonials as $i => $t)
                            <button
                                @click="go({{ $i }})"
                                type="button"
                                class="transition-all duration-300"
                                :class="active === {{ $i }} ? 'w-8' : 'w-2'"
                                :style="active === {{ $i }}
                                    ? 'height: 8px; background: linear-gradient(90deg, #EFC967, #E48633);'
                                    : 'height: 8px; background: rgba(239,201,103,0.25);'"
                                style="height: 8px; border-radius: 4px;"
                                aria-label="Go to testimonial {{ $i + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </section>
@endif