@extends('layouts.app')

@section('title', 'Your conversation — Wuba 58 City Models')

@section('content')

<section class="relative pt-40 pb-16 md:pt-48 overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(160deg, #161515 0%, #241811 50%, #161515 100%);"></div>
    <div class="absolute inset-0 glow-hero opacity-60"></div>

    <div class="relative container-x">
        <div class="section-label mb-6">Your Conversation</div>
        <h1 class="text-3xl md:text-5xl font-display tracking-tightest text-cream-100">
            Hi {{ explode(' ', $msg->name)[0] }},
        </h1>
        <p class="mt-4 text-charcoal-200 max-w-2xl">
            You can add anything else here — drawings, references, or a follow-up question. Our team sees everything on the same thread.
        </p>
    </div>
</section>

<section class="pb-24">
    <div class="container-x max-w-3xl">

        @if (session('replied'))
            <div class="card-elegant p-6 mb-8 text-center" style="border-color: rgba(236,177,67,0.4);">
                <div class="text-gradient-gold text-xs uppercase tracking-widest mb-2">Sent</div>
                <div class="text-charcoal-100">Your reply has been added to the thread.</div>
            </div>
        @endif

        {{-- Conversation thread --}}
        <div class="space-y-6 mb-12">
            {{-- Original message --}}
            <div class="card-elegant p-6 md:p-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-xs uppercase tracking-widest text-gradient-gold font-semibold">You wrote</div>
                    <div class="text-xs text-charcoal-400">{{ $msg->created_at->format('M j, Y · g:i A') }}</div>
                </div>
                <div class="text-charcoal-100 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</div>
            </div>

            {{-- Replies --}}
            @foreach ($replies as $reply)
                @if ($reply->direction === 'outbound')
                    <div class="card-elegant p-6 md:p-8" style="border-color: rgba(236,177,67,0.3); background: linear-gradient(180deg, rgba(236,177,67,0.04), transparent);">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-xs uppercase tracking-widest text-gradient-gold font-semibold">Wuba 58 Team</div>
                            <div class="text-xs text-charcoal-400">{{ $reply->created_at->format('M j, Y · g:i A') }}</div>
                        </div>
                        <div class="text-charcoal-100 leading-relaxed whitespace-pre-wrap">{{ $reply->body }}</div>
                    </div>
                @else
                    <div class="card-elegant p-6 md:p-8">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-xs uppercase tracking-widest text-charcoal-300 font-semibold">You wrote</div>
                            <div class="text-xs text-charcoal-400">{{ $reply->created_at->format('M j, Y · g:i A') }}</div>
                        </div>
                        <div class="text-charcoal-100 leading-relaxed whitespace-pre-wrap">{{ $reply->body }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Reply form --}}
        <form method="POST" action="{{ route('contact.thread.store', $msg->token) }}"
              class="card-elegant p-6 md:p-8">
            @csrf
            <label for="body" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                Add to the conversation
            </label>
            <textarea name="body" id="body" rows="6" required minlength="2" maxlength="3000"
                      class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors resize-y"
                      placeholder="Type your reply here…"></textarea>
            @error('body')
                <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
            @enderror

            <div class="mt-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <button type="submit" class="btn-primary">Send Reply →</button>
                <p class="text-xs text-charcoal-400">
                    We'll notify the team right away.
                </p>
            </div>
        </form>

    </div>
</section>

@endsection