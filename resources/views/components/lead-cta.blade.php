@props([
    'position' => 'bottom-right',   // bottom-right | bottom-left
    'label'    => null,             // optional heading for the expanded state
    'message'  => "I'd like to discuss a model project.",
])

@php
    $whatsapp = preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', ''));
    $email = \App\Models\Setting::get('contact.email', '');
    $hasWhatsapp = ! empty($whatsapp);
    $hasEmail = ! empty($email);
@endphp

@if ($hasWhatsapp || $hasEmail)
    <div
        x-data="{ open: false }"
        @click.outside="open = false"
        class="fixed z-[60] {{ $position === 'bottom-left' ? 'bottom-6 left-6' : 'bottom-6 right-6' }}"
    >
        {{-- Expanded panel --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 scale-95"
            x-cloak
            class="mb-3 w-72 p-5"
            style="background: rgba(22,21,21,0.98); border: 1px solid rgba(236,177,67,0.25); backdrop-filter: blur(12px); box-shadow: 0 20px 40px -10px rgba(0,0,0,0.8);"
        >
            <div class="text-gradient-gold text-xs uppercase tracking-widest font-semibold mb-2">
                Start a project
            </div>
            <p class="text-charcoal-200 text-sm leading-relaxed mb-5">
                Talk to our team about your architectural model — timeline, scale, and budget.
            </p>

            <div class="space-y-2">
                @if ($hasWhatsapp)
                    <a href="https://wa.me/{{ $whatsapp }}?text={{ urlencode($message) }}"
                       target="_blank" rel="noopener"
                       class="flex items-center gap-3 px-4 py-3 text-sm transition-colors"
                       style="border: 1px solid rgba(236,177,67,0.3); color: #F4F0E8;"
                       onmouseover="this.style.background='rgba(236,177,67,0.08)'"
                       onmouseout="this.style.background='transparent'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ECB143" class="w-5 h-5 shrink-0">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <div>
                            <div class="font-semibold">WhatsApp</div>
                            <div class="text-xs text-charcoal-300">Instant reply during business hours</div>
                        </div>
                    </a>
                @endif

                @if ($hasEmail)
                    <a href="mailto:{{ $email }}?subject={{ urlencode('Project enquiry') }}&body={{ urlencode($message) }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm transition-colors"
                       style="border: 1px solid rgba(236,177,67,0.3); color: #F4F0E8;"
                       onmouseover="this.style.background='rgba(236,177,67,0.08)'"
                       onmouseout="this.style.background='transparent'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#ECB143" class="w-5 h-5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <div>
                            <div class="font-semibold">Email</div>
                            <div class="text-xs text-charcoal-300 break-all">{{ $email }}</div>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        {{-- Trigger --}}
        <button
            type="button"
            @click="open = !open"
            class="flex items-center gap-3 pl-4 pr-5 py-3.5 rounded-full transition-transform hover:scale-105"
            style="background: linear-gradient(135deg, #EFC967 0%, #ECB143 50%, #E48633 100%); box-shadow: 0 12px 32px -8px rgba(236,177,67,0.6);"
            aria-label="Contact us"
        >
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#161515" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
            </svg>
            <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#161515" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
            <span x-show="!open" class="text-xs uppercase tracking-widest font-semibold text-charcoal-900 whitespace-nowrap">
                {{ $label ?? 'Talk to us' }}
            </span>
        </button>
    </div>
@endif