<div
    x-data="{
        visible: false,
        init() {
            if (! localStorage.getItem('cookie-consent')) {
                this.visible = true;
            }
        },
        accept() {
            localStorage.setItem('cookie-consent', 'accepted');
            this.visible = false;
            window.dispatchEvent(new Event('consent-granted'));
        },
        decline() {
            localStorage.setItem('cookie-consent', 'declined');
            this.visible = false;
        }
    }"
    x-init="init()"
    x-show="visible"
    x-transition
    x-cloak
    class="fixed bottom-0 inset-x-0 z-[90] p-4 md:p-6"
    style="background: rgba(22,21,21,0.98); border-top: 1px solid rgba(236,177,67,0.2); backdrop-filter: blur(12px);"
>
    <div class="container-x flex flex-col md:flex-row items-start md:items-center gap-4">
        <div class="flex-1 text-sm text-charcoal-200 leading-relaxed">
            We use cookies to understand how visitors use our site. This helps us improve your experience.
            No personal data is sold or shared. <a href="/privacy" class="text-gold-400 hover:underline">Learn more</a>.
        </div>
        <div class="flex gap-3 flex-shrink-0">
            <button
                @click="decline()"
                type="button"
                class="px-5 py-2.5 text-xs uppercase tracking-widest text-charcoal-200 hover:text-gold-400 transition-colors"
                style="border: 1px solid rgba(239,201,103,0.2);">
                Decline
            </button>
            <button
                @click="accept()"
                type="button"
                class="btn-primary text-xs py-2.5">
                Accept
            </button>
        </div>
    </div>
</div>