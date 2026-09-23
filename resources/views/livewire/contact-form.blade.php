<div>
    @if ($sent)
        <div class="card-elegant p-10 md:p-14 text-center">
            <div class="text-gradient-gold font-display text-2xl tracking-tightest uppercase mb-4">
                Message received
            </div>
            <p class="text-charcoal-200 leading-relaxed mb-6">
                Thank you for getting in touch. We'll respond within one business day.
            </p>
            <button wire:click="$set('sent', false)"
                    class="btn-outline text-xs">
                Send another message
            </button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-6">

            {{-- Honeypot (hidden from users, bots fill it) --}}
            <div style="position:absolute;left:-9999px;" aria-hidden="true">
                <label>Website</label>
                <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                        Name <span class="text-gold-500">*</span>
                    </label>
                    <input type="text" id="name" wire:model.blur="name"
                           class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors"
                           placeholder="Your full name">
                    @error('name') <p class="text-xs text-red-400 mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                        Email <span class="text-gold-500">*</span>
                    </label>
                    <input type="email" id="email" wire:model.blur="email"
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
                    <input type="tel" id="phone" wire:model.blur="phone"
                           class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors"
                           placeholder="+254 ...">
                    @error('phone') <p class="text-xs text-red-400 mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="company" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                        Company
                    </label>
                    <input type="text" id="company" wire:model.blur="company"
                           class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors"
                           placeholder="Optional">
                    @error('company') <p class="text-xs text-red-400 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="project_type" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                    Project Type
                </label>
                <select id="project_type" wire:model="project_type"
                        class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors">
                    <option value="">Select a category</option>
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                    <option value="masterplan">Masterplan</option>
                    <option value="mixed_use">Mixed Use</option>
                    <option value="industrial">Industrial / Engineering</option>
                    <option value="other">Other</option>
                </select>
                @error('project_type') <p class="text-xs text-red-400 mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="message" class="block text-xs uppercase tracking-widest text-charcoal-300 mb-3">
                    Message <span class="text-gold-500">*</span>
                </label>
                <textarea id="message" wire:model.blur="message" rows="6"
                          class="w-full bg-charcoal-800 border border-charcoal-700 px-4 py-3 text-cream-100 focus:border-gold-500 focus:outline-none transition-colors resize-y"
                          placeholder="Tell us about your project — scale, location, timeline, and what you're looking to achieve."></textarea>
                @error('message') <p class="text-xs text-red-400 mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pt-2">
                <button type="submit" class="btn-primary w-full sm:w-auto justify-center"
                        wire:loading.attr="disabled"
                        wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Send Message →</span>
                    <span wire:loading wire:target="submit">Sending…</span>
                </button>

                <p class="text-xs text-charcoal-400 leading-relaxed max-w-md">
                    By sending this message you agree to be contacted about your enquiry. We never share your details.
                </p>
            </div>
        </form>
    @endif
</div>