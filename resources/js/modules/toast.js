const ICONS = {
    ink: '<path d="M4.5 12.5 9 17l10.5-10.5"/>',
    signal: '<path d="M12 4.5 21 19.5H3l9-15Z"/><path d="M12 10v4.5"/><path d="M12 17.2h.01"/>',
};

/**
 * One toast, appended to the host the layout already renders. The message is
 * written with textContent so a product name can never inject markup.
 */
export function toast(message, { tone = 'ink', timeout = 4600 } = {}) {
    const host = document.querySelector('[data-toast-host]');

    if (!host) {
        return;
    }

    const el = document.createElement('div');
    el.dataset.toast = '';
    el.setAttribute('role', 'status');
    el.className =
        'toast-in pointer-events-auto flex w-full max-w-md items-start gap-3 rounded-card bg-paper px-4 py-3 shadow-lift';

    const badge = document.createElement('span');
    badge.className =
        'mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full ' +
        (tone === 'signal' ? 'bg-signal-soft text-signal' : 'bg-ink text-paper');
    badge.innerHTML =
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" ' +
        'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="h-3.5 w-3.5">' +
        (ICONS[tone] ?? ICONS.ink) +
        '</svg>';

    const text = document.createElement('p');
    text.className = 'text-sm leading-relaxed text-ink';
    text.textContent = message;

    el.append(badge, text);
    host.appendChild(el);

    window.setTimeout(() => {
        el.style.transition = 'opacity .35s, transform .35s';
        el.style.opacity = '0';
        el.style.transform = 'translateY(6px)';
        window.setTimeout(() => el.remove(), 360);
    }, timeout);
}
