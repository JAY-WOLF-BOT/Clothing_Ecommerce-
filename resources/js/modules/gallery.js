/** Product gallery: thumbnails swap the main plate in place. */
export function initGallery() {
    document.querySelectorAll('[data-gallery]').forEach((gallery) => {
        const main = gallery.querySelector('[data-gallery-main]');
        const thumbs = gallery.querySelectorAll('[data-gallery-thumb]');

        if (!main || thumbs.length < 2) {
            return;
        }

        main.style.transition = 'opacity .25s';

        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                if (thumb.getAttribute('aria-current') === 'true') {
                    return;
                }

                main.style.opacity = '0';

                window.setTimeout(() => {
                    main.src = thumb.dataset.src;
                    main.alt = thumb.dataset.alt ?? main.alt;
                    main.style.opacity = '1';
                }, 140);

                thumbs.forEach((el) => el.removeAttribute('aria-current'));
                thumb.setAttribute('aria-current', 'true');
            });
        });
    });
}
