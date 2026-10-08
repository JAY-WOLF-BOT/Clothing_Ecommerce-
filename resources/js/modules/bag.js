import { toast } from './toast.js';

/**
 * Every bag interaction is a real form submit first. This module upgrades it:
 * same endpoint, same payload, no full page reload. If a request fails, the
 * shopper is told and the page keeps the server's truth.
 */
export function initBag() {
    const request = async (url, { method = 'POST', body } = {}) => {
        const response = await fetch(url, {
            method,
            body,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken(),
            },
        });

        const payload = await response.json().catch(() => null);

        return { ok: response.ok, payload };
    };

    const applyPayload = (payload) => {
        if (!payload) {
            return;
        }

        document.querySelectorAll('[data-bag-count]').forEach((el) => {
            el.textContent = payload.count;
            el.classList.toggle('hidden', payload.count === 0);

            if (payload.count > 0) {
                el.classList.remove('bag-badge-pop');
                void el.offsetWidth;
                el.classList.add('bag-badge-pop');
            }
        });

        document.querySelectorAll('[data-bag-count-text]').forEach((el) => {
            el.textContent = `${payload.count} item${payload.count === 1 ? '' : 's'}`;
        });

        document.querySelectorAll('[data-bag-subtotal], [data-bag-total]').forEach((el) => {
            el.textContent = payload.subtotal_label;
        });

        (payload.lines ?? []).forEach((line) => {
            const row = document.querySelector(`[data-bag-line="${line.key}"]`);

            if (!row) {
                return;
            }

            const qty = row.querySelector('[data-line-qty]');
            const total = row.querySelector('[data-line-total]');

            if (qty) {
                qty.textContent = line.quantity;
            }

            if (total) {
                total.textContent = line.total_label;
            }

            syncStepper(row, line.quantity);
        });
    };

    const syncStepper = (row, quantity) => {
        const form = row.querySelector('[data-bag-qty]');

        if (!form) {
            return;
        }

        const stock = Number(form.dataset.stock ?? quantity);
        const [dec, inc] = form.querySelectorAll('button[name="quantity"]');

        if (dec) {
            dec.value = String(Math.max(1, quantity - 1));
            dec.disabled = quantity <= 1;
        }

        if (inc) {
            inc.value = String(Math.min(stock, quantity + 1));
            inc.disabled = quantity >= stock;
        }
    };

    // Add to bag — from a feed post, the hero, or the product page.
    document.querySelectorAll('form[data-bag-add]').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const data = new FormData(form);

            if (button) {
                button.disabled = true;
                button.dataset.label = button.textContent;
                button.textContent = 'Adding…';
            }

            const { ok, payload } = await request(form.action, { body: data });

            if (button) {
                button.disabled = false;
                button.textContent = button.dataset.label ?? 'Add';
            }

            if (ok) {
                applyPayload(payload);
                toast(payload?.message ?? 'Added to your bag.');
            } else {
                toast(payload?.message ?? 'That size is not available right now.', { tone: 'signal' });
            }
        });
    });

    // Quantity steppers on the bag.
    document.querySelectorAll('form[data-bag-qty]').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitter = event.submitter;
            const data = new FormData(form);

            if (submitter?.name) {
                data.set(submitter.name, submitter.value);
            }

            const { ok, payload } = await request(form.action, { method: 'PATCH', body: data });

            if (ok) {
                applyPayload(payload);
            } else {
                toast('That change did not stick. Reloading the bag.', { tone: 'signal' });
                window.setTimeout(() => window.location.reload(), 900);
            }
        });
    });

    // Remove a line.
    document.querySelectorAll('form[data-bag-remove]').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const row = document.querySelector(`[data-bag-line="${form.dataset.key}"]`);
            const { ok, payload } = await request(form.action, { method: 'DELETE', body: new FormData(form) });

            if (!ok) {
                toast('Could not remove that. Reloading the bag.', { tone: 'signal' });
                window.setTimeout(() => window.location.reload(), 900);

                return;
            }

            applyPayload(payload);

            if (payload?.empty) {
                // Let the server render the true empty state rather than
                // leaving a half-empty summary on screen.
                window.location.reload();

                return;
            }

            row?.remove();
            toast('Removed from your bag.');
        });
    });
}

function csrfToken() {
    return (
        document.querySelector('meta[name="csrf-token"]')?.content ??
        document.querySelector('input[name="_token"]')?.value ??
        ''
    );
}
