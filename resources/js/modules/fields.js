/**
 * Input groups. An addon is part of the field it sits in, so a tap anywhere on
 * that boundary focuses the control — including the icon, which is scenery
 * rather than a target.
 */
export function initFields() {
    document.querySelectorAll('.input-group').forEach((group) => {
        const control = group.querySelector('.input-group-control');

        if (!control) {
            return;
        }

        group.addEventListener('click', (event) => {
            // A button in an addon is a target of its own.
            if (event.target.closest('button') || event.target === control) {
                return;
            }

            control.focus();
        });
    });
}
