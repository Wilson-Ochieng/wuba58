@extends('layouts.app')

@section('title', $brochure->title . ' — Wuba 58 City Models')
@section('description', $brochure->description ?: 'Download our PDF brochure.')

@section('content')

<section class="relative pt-48 pb-20 md:pt-56 md:pb-28 overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);"></div>
    <div class="absolute inset-0 glow-hero opacity-70"></div>

    <div class="relative container-x">
        <a href="{{ route('brochures.index') }}" class="text-charcoal-300 text-xs uppercase tracking-widest hover:text-gold-400 transition mb-6 inline-block">
            ← All brochures
        </a>

        <div class="section-label mb-5">PDF Brochure</div>

        <h1 class="text-3xl md:text-5xl lg:text-6xl font-display tracking-tightest text-cream-100 max-w-4xl leading-[1.05] text-balance mb-6">
            {{ $brochure->title }}
        </h1>

        @if ($brochure->description)
            <p class="max-w-2xl text-lg md:text-xl text-charcoal-200 leading-relaxed">
                {{ $brochure->description }}
            </p>
        @endif
    </div>
</section>

<x-section>
    <div class="grid lg:grid-cols-5 gap-12 lg:gap-20 max-w-6xl mx-auto">

        {{-- Cover --}}
        <div class="lg:col-span-2">
            <div class="aspect-[4/5] overflow-hidden bg-charcoal-800 relative sticky top-32">
                @if ($brochure->hasMedia('cover'))
                    <img src="{{ $brochure->getFirstMediaUrl('cover') }}"
                         alt="{{ $brochure->title }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-charcoal-500 p-8 text-center"
                         style="background: linear-gradient(160deg, #1e1e1e 0%, #2a1a0f 100%);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 mb-6 text-gold-500 opacity-40">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <div class="font-display tracking-widest text-xs uppercase text-charcoal-400 mb-2">
                            PDF Brochure
                        </div>
                        <div class="text-xs text-charcoal-500">
                            {{ $brochure->file_size }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Form --}}
        <div class="lg:col-span-3">
            <div class="section-label mb-5">Get the PDF</div>
            <h2 class="text-2xl md:text-3xl font-display tracking-tightest text-cream-100 mb-4">
                Fill in your details
            </h2>
            <p class="text-charcoal-200 leading-relaxed mb-10">
                We'll send the brochure straight to your inbox. No spam — just the PDF.
            </p>

            @if (session('error'))
                <div class="card-elegant p-5 mb-8" style="border-color: rgba(220, 53, 69, 0.4);">
                    <p class="text-red-400 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('brochures.request') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="brochure_id" value="{{ $brochure->id }}">

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                            Name <span class="text-gold-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors"
                               placeholder="Your full name">
                        @error('name') <p class="text-xs text-red-400 mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                            Email <span class="text-gold-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors"
                               placeholder="you@company.com">
                        @error('email') <p class="text-xs text-red-400 mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                            Phone
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors"
                               placeholder="+254 ...">
                    </div>

                    <div>
                        <label for="company" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                            Company
                        </label>
                        <input type="text" id="company" name="company" value="{{ old('company') }}"
                               class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors"
                               placeholder="Optional">
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                        Anything else?
                    </label>
                    <textarea id="message" name="message" rows="3"
                              class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors resize-y"
                              placeholder="Optional — tell us about your project.">{{ old('message') }}</textarea>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pt-2">
                    <button type="submit" class="btn-primary w-full sm:w-auto justify-center">
                        Email me the brochure →
                    </button>
                    <p class="text-xs text-charcoal-400 leading-relaxed max-w-md">
                        We'll never share your details. Unsubscribe any time.
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-section>

<x-cta-section />

@endsection