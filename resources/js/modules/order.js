/**
 * Checkout hands the order to WhatsApp. The form is a plain GET form pointed at
 * wa.me and carries the order text in a hidden field, so it works with
 * scripting off; here the shopper's own details are woven into that message
 * instead of being left behind as stray query parameters.
 */
export function initOrderForm() {
    const form = document.querySelector('[data-order-form]');

    if (!form) {
        return;
    }

    form.addEventListener('submit', (event) => {
        const text = form.querySelector('[data-order-text]');
        const name = form.querySelector('[data-order-name]');
        const phone = form.querySelector('[data-order-phone]');
        const area = form.querySelector('[data-order-area]');
        const note = form.querySelector('[data-order-note]');

        if (!text) {
            return;
        }

        const lines = [text.value, ''];

        if (name?.value.trim()) {
            lines.push(`Name: ${name.value.trim()}`);
        }

        if (phone?.value.trim()) {
            lines.push(`My WhatsApp: ${phone.value.trim()}`);
        }

        if (area?.value) {
            lines.push(`Delivery area: ${area.value}`);
        }

        if (note?.value.trim()) {
            lines.push(`Note: ${note.value.trim()}`);
        }

        text.value = lines.join('\n');

        // The hidden field is submitted by the browser; the message is what
        // wa.me reads. Keeping the submit native preserves the new-tab gesture.
        event.stopPropagation();
    });
}
