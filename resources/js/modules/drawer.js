/**
 * Mobile navigation drawer. It is a real panel in the document that starts
 * hidden, so the categories are still reachable with scripting off.
 */
export function initDrawer() {
    const drawer = document.querySelector('[data-drawer]');

    if (!drawer) {
        return;
    }

    const openers = document.querySelectorAll('[data-drawer-open]');
    const closers = drawer.querySelectorAll('[data-drawer-close]');
    const lastFocus = { current: null };

    const open = () => {
        lastFocus.current = document.activeElement;
        drawer.hidden = false;
        document.body.style.overflow = 'hidden';

        openers.forEach((el) => el.setAttribute('aria-expanded', 'true'));
        drawer.querySelector('[data-drawer-close]')?.focus();
    };

    const close = () => {
        drawer.hidden = true;
        document.body.style.overflow = '';

        openers.forEach((el) => el.setAttribute('aria-expanded', 'false'));
        lastFocus.current?.focus?.();
    };

    openers.forEach((el) => el.addEventListener('click', open));
    closers.forEach((el) => el.addEventListener('click', close));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !drawer.hidden) {
            close();
        }
    });

    // A viewport that grows past the breakpoint must not keep the drawer's
    // scroll lock behind it.
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
        if (event.matches && !drawer.hidden) {
            close();
        }
    });
}
