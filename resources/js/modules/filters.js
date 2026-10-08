/**
 * Category filters. The form is a plain GET form that works without scripting;
 * with scripting the selects submit on change and the grid shows it is working.
 */
export function initFilters() {
    const form = document.querySelector('[data-filter-form]');

    if (!form) {
        return;
    }

    const button = form.querySelector('[data-filter-submit]');
    const results = document.querySelector('[data-filter-results]');

    // Redundant once change-submit is live, so it leaves.
    if (button) {
        button.hidden = true;
    }

    let submitting = false;

    const submit = () => {
        if (submitting) {
            return;
        }

        submitting = true;

        if (results) {
            results.setAttribute('aria-busy', 'true');
            results.style.transition = 'opacity .2s';
            results.style.opacity = '0.5';
        }

        form.submit();
    };

    form.querySelectorAll('select').forEach((select) => {
        select.addEventListener('change', submit);
    });
}
