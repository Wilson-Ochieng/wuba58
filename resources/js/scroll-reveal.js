/**
 * Scroll reveal — animates [data-reveal] elements as they enter the viewport.
 */

const REVEALED = 'is-revealed';

function shouldReduceMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function observeAll() {
    if (shouldReduceMotion()) {
        document
            .querySelectorAll('[data-reveal], [data-reveal-stagger]')
            .forEach(el => el.classList.add(REVEALED));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add(REVEALED);
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -60px 0px',
    });

    document
        .querySelectorAll('[data-reveal]:not(.is-revealed), [data-reveal-stagger]:not(.is-revealed)')
        .forEach(el => observer.observe(el));
}

document.addEventListener('DOMContentLoaded', observeAll);
document.addEventListener('livewire:navigated', observeAll);
document.addEventListener('livewire:initialized', observeAll);