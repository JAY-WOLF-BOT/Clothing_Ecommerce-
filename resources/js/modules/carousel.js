/**
 * Feed carousels. The track is a real scroll container, so touch dragging and
 * keyboard scrolling work before this module runs; it only keeps the dots and
 * the index honest.
 */
export function initCarousels() {
    document.querySelectorAll('[data-carousel]').forEach((carousel) => {
        const track = carousel.querySelector('[data-carousel-track]');
        const dots = carousel.querySelectorAll('[data-carousel-dot]');
        const index = carousel.querySelector('[data-carousel-index]');

        if (!track || dots.length === 0) {
            return;
        }

        const setCurrent = (position) => {
            dots.forEach((dot, i) => {
                const isCurrent = i === position;
                const bar = dot.querySelector('[data-carousel-bar]') ?? dot;

                bar.classList.toggle('w-6', isCurrent);
                bar.classList.toggle('bg-paper', isCurrent);
                bar.classList.toggle('w-1.5', !isCurrent);
                bar.classList.toggle('bg-paper/60', !isCurrent);

                if (isCurrent) {
                    dot.setAttribute('aria-current', 'true');
                } else {
                    dot.removeAttribute('aria-current');
                }
            });

            if (index) {
                index.textContent = String(position + 1);
            }
        };

        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const slide = track.children[Number(dot.dataset.carouselDot)];

                slide?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            });
        });

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        setCurrent(Number(entry.target.dataset.slide ?? 0));
                    }
                });
            },
            { root: track, threshold: 0.6 }
        );

        Array.from(track.children).forEach((slide, i) => {
            slide.dataset.slide = String(i);
            observer.observe(slide);
        });
    });
}
