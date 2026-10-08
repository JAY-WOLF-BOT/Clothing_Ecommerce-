/**
 * The page's one authored motion: elements settle into place as they arrive.
 * Content is visible by default in CSS — the hiding only exists under html.js,
 * and this module clears that flag if it never runs.
 */
export function initReveal() {
    const targets = document.querySelectorAll('.reveal');

    window.__revealReady = true;

    if (targets.length === 0 || !('IntersectionObserver' in window)) {
        document.documentElement.classList.remove('js');

        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                // An anchor jump or a restored scroll can put an element above
                // the viewport without it ever having intersected. Those settle
                // immediately, or they would stay invisible for good.
                const above = entry.boundingClientRect.bottom < 0;

                if (!entry.isIntersecting && !above) {
                    return;
                }

                entry.target.classList.add('is-in');
                observer.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.05 }
    );

    targets.forEach((target) => observer.observe(target));
}
