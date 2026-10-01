import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
document.addEventListener('submit', (e) => {
    if (!e.defaultPrevented) {
        window.dispatchEvent(new CustomEvent('mostrar-carga'));
    }
});

// Al volver con el botón "atrás" del navegador, ocultar el loader
window.addEventListener('pageshow', (e) => {
    if (e.persisted) location.reload();
});
