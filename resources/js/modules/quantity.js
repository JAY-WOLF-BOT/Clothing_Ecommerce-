/** Product quantity stepper, bounded so the field can never go below one. */
export function initQuantity() {
    document.querySelectorAll('[data-size-form]').forEach((form) => {
        const input = form.querySelector('[data-qty-input]');
        const steps = form.querySelectorAll('[data-qty-step]');

        if (!input || steps.length === 0) {
            return;
        }

        const clamp = (value) => Math.min(10, Math.max(1, Number.isFinite(value) ? value : 1));

        steps.forEach((step) => {
            step.addEventListener('click', () => {
                input.value = String(clamp(Number(input.value) + Number(step.dataset.qtyStep)));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        input.addEventListener('change', () => {
            input.value = String(clamp(Number(input.value)));
        });
    });
}
