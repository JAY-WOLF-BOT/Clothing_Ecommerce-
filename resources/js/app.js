import { initBag } from './modules/bag.js';
import { initCarousels } from './modules/carousel.js';
import { initDrawer } from './modules/drawer.js';
import { initFields } from './modules/fields.js';
import { initFilters } from './modules/filters.js';
import { initGallery } from './modules/gallery.js';
import { initOrderForm } from './modules/order.js';
import { initQuantity } from './modules/quantity.js';
import { initReveal } from './modules/reveal.js';
import { initSelects } from './modules/select.js';

const boot = () => {
    initDrawer();
    initBag();
    initCarousels();
    initGallery();
    initSelects();
    initFields();
    initFilters();
    initQuantity();
    initOrderForm();
    initReveal();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
