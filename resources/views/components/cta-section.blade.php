@php
    $whatsapp = preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp'));
    $phone    = \App\Models\Setting::get('contact.phone');
    $email    = \App\Models\Setting::get('contact.email');
@endphp

<section class="relative py-32 md:py-48 overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #1f1310 50%, #161515 100%);"></div>
    <div class="absolute inset-0 glow-copper"></div>

    <div class="relative container-x text-center">
        <h2 class="text-4xl md:text-6xl lg:text-7xl font-display tracking-tightest text-cream-100 mb-8 max-w-4xl mx-auto text-balance">
            HAVE A <span class="text-gradient-ember">PROJECT</span> IN MIND?
        </h2>

        <p class="text-lg md:text-xl text-charcoal-200 max-w-2xl mx-auto mb-12">
            Let's turn your drawings into something people can experience.
        </p>

        <x-btn href="/contact" size="lg">
            Start Your Project →
        </x-btn>

        <div class="mt-16 flex flex-col sm:flex-row justify-center gap-6 sm:gap-10 text-sm uppercase tracking-widest text-charcoal-200">
            @if ($whatsapp)
                <a href="https://wa.me/{{ $whatsapp }}" class="hover:text-gold-400 transition">WhatsApp</a>
            @endif
            @if ($phone)
                <a href="tel:{{ $phone }}" class="hover:text-gold-400 transition">Call</a>
            @endif
            @if ($email)
                <a href="mailto:{{ $email }}" class="hover:text-gold-400 transition">Email</a>
            @endif
        </div>
    </div>
</section>