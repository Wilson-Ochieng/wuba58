@extends('layouts.app')

@section('title', 'Contact — Wuba 58 City Models')
@section('description', 'Start your project with Wuba 58 City Models. Nairobi branch — Kabarnet Rd, off Ngong Road. Call, WhatsApp, or send us a message.')

@section('content')

{{-- ═════════ HERO ═════════ --}}
<section class="relative pt-48 pb-20 md:pt-56 md:pb-28 overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);"></div>
    <div class="absolute inset-0 glow-hero opacity-70"></div>

    <div class="relative container-x">
        <div class="section-label mb-6">Get in Touch</div>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-display tracking-tightest text-cream-100 max-w-5xl leading-[1.05] text-balance">
            Have a project in mind?
        </h1>
        <p class="mt-8 max-w-2xl text-lg md:text-xl text-charcoal-200 leading-relaxed">
            Let's turn your drawings into something people can experience. Reach us by phone, WhatsApp, email, or drop by the Nairobi studio.
        </p>
    </div>
</section>

{{-- ═════════ QUICK CONTACT CARDS ═════════ --}}
<section class="py-16 md:py-20" style="background: linear-gradient(180deg, #161515 0%, #232222 50%, #161515 100%);">
    <div class="container-x">
        <div class="grid md:grid-cols-3 gap-6">
            @php
                $whatsapp = preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', ''));
            @endphp

            <a href="https://wa.me/{{ $whatsapp }}"
               target="_blank" rel="noopener"
               class="card-elegant p-8 group">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <div class="text-gradient-gold font-display text-xs tracking-widest uppercase mb-3">WhatsApp</div>
                <div class="text-cream-100 font-display text-lg tracking-tightest group-hover:text-gold-400 transition-colors">
                    Chat with us
                </div>
                <div class="text-charcoal-300 text-sm mt-2">{{ \App\Models\Setting::get('contact.whatsapp') }}</div>
            </a>

            <a href="tel:{{ \App\Models\Setting::get('contact.phone') }}"
               class="card-elegant p-8 group">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <div class="text-gradient-gold font-display text-xs tracking-widest uppercase mb-3">Call</div>
                <div class="text-cream-100 font-display text-lg tracking-tightest group-hover:text-gold-400 transition-colors">
                    Speak with sales
                </div>
                <div class="text-charcoal-300 text-sm mt-2">{{ \App\Models\Setting::get('contact.phone') }}</div>
            </a>

            <a href="mailto:{{ \App\Models\Setting::get('contact.email') }}"
               class="card-elegant p-8 group">
                <div class="w-10 h-px mb-6" style="background: linear-gradient(90deg, #ECB143, #E48633);"></div>
                <div class="text-gradient-gold font-display text-xs tracking-widest uppercase mb-3">Email</div>
                <div class="text-cream-100 font-display text-lg tracking-tightest group-hover:text-gold-400 transition-colors">
                    Send us details
                </div>
                <div class="text-charcoal-300 text-sm mt-2 break-all">{{ \App\Models\Setting::get('contact.email') }}</div>
            </a>
        </div>
    </div>
</section>

{{-- ═════════ FORM + INFO ═════════ --}}
<section class="py-20 md:py-28">
    <div class="container-x">
        <div class="grid lg:grid-cols-5 gap-12 lg:gap-20">

            {{-- Info column --}}
            <div class="lg:col-span-2">
                <div class="section-label mb-6">Studio & Offices</div>
                <h2 class="text-3xl md:text-4xl font-display tracking-tightest text-cream-100 mb-10">
                    Nairobi, Kenya
                </h2>

                <div class="space-y-8">
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gold-500 mb-3">Physical Address</div>
                        <div class="text-charcoal-100 leading-relaxed">
                            {!! nl2br(e(\App\Models\Setting::get('contact.address_physical', ''))) !!}
                        </div>
                    </div>

                    @if (\App\Models\Setting::get('contact.address_postal'))
                        <div>
                            <div class="text-xs uppercase tracking-widest text-gold-500 mb-3">Postal Address</div>
                            <div class="text-charcoal-100 leading-relaxed">
                                {!! nl2br(e(\App\Models\Setting::get('contact.address_postal'))) !!}
                            </div>
                        </div>
                    @endif

                    <div>
                        <div class="text-xs uppercase tracking-widest text-gold-500 mb-3">Sales Contacts</div>
                        <ul class="space-y-2 text-charcoal-100">
                            @foreach (['contact.phone', 'contact.phone_2', 'contact.phone_3'] as $key)
                                @php $num = \App\Models\Setting::get($key); @endphp
                                @if ($num)
                                    <li>
                                        <a href="tel:{{ $num }}" class="hover:text-gold-400 transition-colors">{{ $num }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <div class="text-xs uppercase tracking-widest text-gold-500 mb-3">Global Studios</div>
                        <ul class="text-charcoal-100 space-y-2">
                            <li>Shenzhen, China — Headquarters</li>
                            <li>Nanchang, China</li>
                            <li>Nairobi, Kenya</li>
                        </ul>
                    </div>

                    {{-- Socials --}}
                    <div>
                        <div class="text-xs uppercase tracking-widest text-gold-500 mb-3">Follow Us</div>
                        <div class="flex flex-wrap gap-3">
                            @foreach ([
                                'social.instagram' => 'Instagram',
                                'social.facebook'  => 'Facebook',
                                'social.tiktok'    => 'TikTok',
                                'social.youtube'   => 'YouTube',
                                'social.linkedin'  => 'LinkedIn',
                            ] as $key => $label)
                                @php $url = \App\Models\Setting::get($key); @endphp
                                @if ($url)
                                    <a href="{{ $url }}" target="_blank" rel="noopener"
                                       class="px-4 py-2 text-xs uppercase tracking-widest text-charcoal-100 hover:text-gold-400 transition-colors"
                                       style="border: 1px solid rgba(239,201,103,0.2);">
                                        {{ $label }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form column --}}
            <div class="lg:col-span-3">
                <div class="section-label mb-6">Send a Message</div>
                <h2 class="text-3xl md:text-4xl font-display tracking-tightest text-cream-100 mb-10">
                    Start your project
                </h2>

                <livewire:contact-form />
            </div>
        </div>
    </div>
</section>

{{-- ═════════ GOOGLE MAP ═════════ --}}
<section class="pb-20 md:pb-28">
    <div class="container-x">
        <div class="section-label mb-6">Find Us</div>
        <h2 class="text-3xl md:text-4xl font-display tracking-tightest text-cream-100 mb-10">
            Visit the studio
        </h2>
    </div>

    <div style="width: 100%; height: 480px; border-top: 1px solid rgba(236,177,67,0.15); border-bottom: 1px solid rgba(236,177,67,0.15);">
        <iframe
            src="https://www.google.com/maps?q=Kabarnet+Road,+Nairobi,+Kenya&output=embed"
            width="100%"
            height="100%"
            style="border: 0; filter: invert(90%) hue-rotate(180deg) contrast(0.9);"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Wuba 58 City Models — Kabarnet Road, Nairobi"
        ></iframe>
    </div>
</section>

@endsection