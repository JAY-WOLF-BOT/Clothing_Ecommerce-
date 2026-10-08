/**
 * Dropdown menus.
 *
 * Each of these is a real <select> underneath. It holds the value, it is what
 * the form submits, and it is the control the shopper sees when scripting is
 * not there to replace it. What this module replaces is only the list the
 * operating system draws — so the trigger, the listbox, the keyboard and the
 * typeahead belong to the store rather than to the platform.
 *
 * It follows the select-only combobox pattern: focus never leaves the trigger,
 * and the option under the keyboard is named by aria-activedescendant. That
 * keeps Tab behaving the way it does everywhere else on the page, because the
 * focused element never moves out of its place in the document.
 */

const GAP = 4; // The distance the list sits from its trigger.
const MARGIN = 8; // The closest the list may come to the viewport edge.
const MIN_WIDTH = 128; // 8rem — narrower than this and the list reads as a stub.
const MAX_HEIGHT = 304; // 19rem, the cap the stylesheet also declares.
const TYPEAHEAD_RESET = 700;

// The same authored check the Blade icon component draws, so the mark in the
// list and the marks on the page are one glyph.
const CHECK =
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" ' +
    'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" ' +
    'class="h-3 w-3"><path d="M4.5 12.5 9 17l10.5-10.5"/></svg>';

let openMenu = null;
let menuSeq = 0;

const printable = (event) => event.key.length === 1 && !event.metaKey && !event.ctrlKey && !event.altKey;

class SelectMenu {
    constructor(root) {
        this.root = root;
        this.select = root.querySelector('[data-select-native]');
        this.trigger = root.querySelector('[data-select-trigger]');
        this.output = root.querySelector('[data-select-label]');

        if (!this.select || !this.trigger || this.select.disabled) {
            return;
        }

        this.activeIndex = 0;
        this.typed = '';
        this.typedAt = 0;

        this.list = this.buildList();

        this.trigger.addEventListener('click', () => this.toggle());
        this.trigger.addEventListener('keydown', (event) => this.onKey(event));

        this.stabilize();

        // Measured against the fallback face at first paint, so it is measured
        // again once the real one has loaded.
        document.fonts?.ready.then(() => this.stabilize());
    }

    // A select holds the width of its widest option, so choosing a shorter
    // label never makes the control jump under the pointer.
    stabilize() {
        if (!this.output) {
            return;
        }

        const chosen = this.output.textContent;
        let widest = 0;

        this.options().forEach((option) => {
            this.output.textContent = option.textContent.trim();
            widest = Math.max(widest, this.trigger.offsetWidth);
        });

        this.output.textContent = chosen;
        this.root.style.minWidth = `${Math.ceil(widest)}px`;
    }

    buildList() {
        const list = document.createElement('div');

        menuSeq += 1;
        list.className = 'menu';
        list.id = `store-menu-${menuSeq}`;
        list.setAttribute('role', 'listbox');
        list.setAttribute('aria-label', this.trigger.getAttribute('aria-label') ?? '');
        list.hidden = true;

        // Nothing in the list may take focus: the trigger keeps it, so the
        // pointer must not be allowed to move it.
        list.addEventListener('pointerdown', (event) => event.preventDefault());

        this.trigger.setAttribute('aria-controls', list.id);
        document.body.append(list);

        return list;
    }

    options() {
        return Array.from(this.select.options);
    }

    items() {
        return Array.from(this.list.children);
    }

    /* ---------------------------------------------------------------- state */

    render() {
        const list = this.list;

        list.replaceChildren();

        this.options().forEach((option, index) => {
            const item = document.createElement('div');
            item.className = 'menu-item';
            item.id = `${list.id}-option-${index}`;
            item.setAttribute('role', 'option');
            item.setAttribute('aria-selected', option.selected ? 'true' : 'false');

            const mark = document.createElement('span');
            mark.className = 'menu-indicator';
            mark.innerHTML = CHECK;

            item.append(mark, document.createTextNode(option.textContent.trim()));

            item.addEventListener('pointerenter', () => this.setActive(index));
            item.addEventListener('click', () => this.choose(index));

            list.append(item);
        });
    }

    setActive(index) {
        const items = this.items();

        if (items.length === 0) {
            return;
        }

        this.activeIndex = ((index % items.length) + items.length) % items.length;

        items.forEach((item, i) => {
            if (i === this.activeIndex) {
                item.setAttribute('data-active', 'true');
            } else {
                item.removeAttribute('data-active');
            }
        });

        this.trigger.setAttribute('aria-activedescendant', items[this.activeIndex].id);
        this.reveal(items[this.activeIndex]);
    }

    // Keep the active option inside the list's own scroll box without letting
    // scrollIntoView reach the document behind it.
    reveal(item) {
        const list = this.list;
        const top = item.offsetTop;
        const bottom = top + item.offsetHeight;

        if (top < list.scrollTop) {
            list.scrollTop = top - 4;
        } else if (bottom > list.scrollTop + list.clientHeight) {
            list.scrollTop = bottom - list.clientHeight + 4;
        }
    }

    sync() {
        const option = this.select.selectedOptions[0];

        if (option && this.output) {
            this.output.textContent = option.textContent.trim();
        }
    }

    /* --------------------------------------------------------------- layout */

    place() {
        const list = this.list;
        const rect = this.trigger.getBoundingClientRect();

        // A trigger that has been scrolled out of the viewport has nothing
        // left to hang a list from.
        if (rect.bottom < 0 || rect.top > window.innerHeight) {
            this.close();

            return;
        }

        list.style.visibility = 'hidden';
        list.hidden = false;

        const edge = window.innerWidth - MARGIN * 2;
        list.style.width = 'auto';
        list.style.minWidth = `${Math.min(Math.max(Math.round(rect.width), MIN_WIDTH), edge)}px`;
        list.style.maxWidth = `${edge}px`;
        list.style.maxHeight = '';

        const natural = list.offsetHeight;
        const below = window.innerHeight - rect.bottom - GAP - MARGIN;
        const above = rect.top - GAP - MARGIN;

        // Flip only when the list genuinely does not fit below and there is
        // more room above — a two-item list near the foot of the page is
        // better slightly clipped than turned upside down.
        const flip = below < Math.min(natural, 160) && above > below;
        const room = Math.max(flip ? above : below, 0);

        list.style.maxHeight = `${Math.max(96, Math.min(room, MAX_HEIGHT))}px`;

        const height = Math.min(natural, list.offsetHeight);
        const top = Math.min(
            Math.max(flip ? rect.top - GAP - height : rect.bottom + GAP, MARGIN),
            Math.max(window.innerHeight - MARGIN - height, MARGIN)
        );
        const left = Math.min(
            Math.max(rect.left, MARGIN),
            Math.max(window.innerWidth - MARGIN - list.offsetWidth, MARGIN)
        );

        list.style.top = `${Math.round(top)}px`;
        list.style.left = `${Math.round(left)}px`;
        // The list grows out of the middle of the trigger it belongs to.
        list.style.transformOrigin = `top ${Math.round(rect.left - left + rect.width / 2)}px`;
        list.style.visibility = '';
    }

    /* --------------------------------------------------------------- public */

    open() {
        if (this.options().length === 0) {
            return;
        }

        if (openMenu && openMenu !== this) {
            openMenu.close();
        }

        openMenu = this;

        this.render();
        this.place();

        this.list.classList.remove('menu-in');
        void this.list.offsetWidth;
        this.list.classList.add('menu-in');

        this.trigger.setAttribute('aria-expanded', 'true');

        this.setActive(Math.max(0, this.options().findIndex((option) => option.selected)));
    }

    close() {
        if (this.list.hidden) {
            return;
        }

        this.list.hidden = true;
        this.list.classList.remove('menu-in');
        this.trigger.setAttribute('aria-expanded', 'false');
        this.trigger.removeAttribute('aria-activedescendant');

        if (openMenu === this) {
            openMenu = null;
        }
    }

    toggle() {
        if (this.list.hidden) {
            this.open();
        } else {
            this.close();
        }
    }

    choose(index) {
        const option = this.options()[index];

        if (!option) {
            return;
        }

        this.close();

        if (this.select.value === option.value) {
            return;
        }

        this.select.value = option.value;
        this.sync();

        // The filters submit on change and the order form reads the value at
        // submit time; neither has to know this module exists.
        this.select.dispatchEvent(new Event('change', { bubbles: true }));
    }

    typeahead(char) {
        const now = Date.now();

        this.typed = now - this.typedAt > TYPEAHEAD_RESET ? char : this.typed + char;
        this.typedAt = now;

        const needle = this.typed.toLowerCase();
        const options = this.options();

        for (let step = 1; step <= options.length; step += 1) {
            const index = (this.activeIndex + step) % options.length;

            if (options[index].textContent.trim().toLowerCase().startsWith(needle)) {
                this.setActive(index);

                return;
            }
        }
    }

    onKey(event) {
        const isOpen = !this.list.hidden;

        switch (event.key) {
            case 'ArrowDown':
            case 'ArrowUp': {
                event.preventDefault();

                const step = event.key === 'ArrowDown' ? 1 : -1;

                if (!isOpen) {
                    this.open();

                    // Opening lands on the chosen option, so an upward step
                    // starts from the one before it.
                    if (step === -1) {
                        this.setActive(this.activeIndex - 1);
                    }

                    return;
                }

                this.setActive(this.activeIndex + step);

                return;
            }

            case 'Home':
            case 'End': {
                if (!isOpen) {
                    return;
                }

                event.preventDefault();
                this.setActive(event.key === 'Home' ? 0 : this.items().length - 1);

                return;
            }

            case 'Enter':
            case ' ': {
                event.preventDefault();

                if (isOpen) {
                    this.choose(this.activeIndex);
                } else {
                    this.open();
                }

                return;
            }

            case 'Escape': {
                if (!isOpen) {
                    return;
                }

                event.preventDefault();
                this.close();

                return;
            }

            case 'Tab': {
                // Focus is on the trigger, so the default move is already the
                // right one; the list only has to get out of the way.
                this.close();

                return;
            }

            default: {
                if (!printable(event)) {
                    return;
                }

                event.preventDefault();

                if (!isOpen) {
                    this.open();
                }

                this.typeahead(event.key);
            }
        }
    }
}

export function initSelects() {
    document.querySelectorAll('[data-select]').forEach((root) => new SelectMenu(root));

    // The list is out of the document flow, so it follows its trigger rather
    // than scrolling with it.
    const follow = () => openMenu?.place();

    window.addEventListener('scroll', follow, { passive: true, capture: true });
    window.addEventListener('resize', follow);

    document.addEventListener('pointerdown', (event) => {
        if (!openMenu) {
            return;
        }

        if (openMenu.trigger.contains(event.target) || openMenu.list.contains(event.target)) {
            return;
        }

        openMenu.close();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && openMenu) {
            openMenu.close();
        }
    });
}
