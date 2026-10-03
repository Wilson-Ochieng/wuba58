@extends('layouts.app')

@section('title', 'Brochure sent — Wuba 58 City Models')

@section('content')

<section class="relative min-h-[70vh] flex items-center overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #2a1a0f 45%, #161515 100%);"></div>
    <div class="absolute inset-0 glow-hero opacity-70"></div>

    <div class="relative container-x max-w-2xl text-center py-32">
        <div class="w-20 h-20 mx-auto mb-8 flex items-center justify-center rounded-full"
             style="background: linear-gradient(135deg, rgba(239,201,103,0.15), rgba(228,134,51,0.08)); border: 1px solid rgba(236,177,67,0.4);">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#ECB143" class="w-9 h-9">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>

        <div class="section-label mb-5">Sent</div>

        <h1 class="text-3xl md:text-5xl font-display tracking-tightest text-cream-100 mb-6 leading-tight">
            Check your inbox
        </h1>

        <p class="text-charcoal-200 text-lg leading-relaxed mb-10">
            @if (session('lead_name'))
                Thanks, {{ explode(' ', session('lead_name'))[0] }}.
            @endif
            We've emailed <strong class="text-cream-100">{{ $brochure->title }}</strong> to you. It should arrive within a minute.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if ($brochure->file_url)
                <a href="{{ $brochure->file_url }}" target="_blank" rel="noopener" class="btn-primary">
                    Download now →
                </a>
            @endif
            <a href="{{ route('brochures.index') }}" class="btn-outline">
                Other brochures
            </a>
        </div>

        <p class="text-charcoal-400 text-xs uppercase tracking-widest mt-12">
            Can't find the email? Check spam.
        </p>
    </div>
</section>

@endsection