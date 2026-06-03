/**
 * Mobile Menu - Casa Xu'unan
 * Works WITH the slideDown class system
 */
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // NOTE: antes este script hacia return en desktop (>= 993) porque el
    // menu hamburguesa solo era mobile. Ahora tambien se usa en home desktop
    // (sidebar lateral), por lo que dejamos que corra en cualquier ancho.
    // Si el #menu-btn esta oculto por CSS en otras paginas desktop, el JS
    // no causa conflicto porque el boton simplemente no es clickeable.

    var overlay = document.getElementById('menu-overlay');
    var menuBtn = document.getElementById('menu-btn');
    var mainMenu = document.getElementById('mainmenu');

    if (!overlay || !menuBtn) return;
    if (mainMenu && window.innerWidth < 993) mainMenu.style.display = 'none';

    // Clone buttons to remove ALL existing event listeners
    var newMenuBtn = menuBtn.cloneNode(true);
    menuBtn.parentNode.replaceChild(newMenuBtn, menuBtn);

    var oldCloseBtn = document.getElementById('mo-button-close');
    var newCloseBtn = null;
    if (oldCloseBtn) {
        newCloseBtn = oldCloseBtn.cloneNode(true);
        oldCloseBtn.parentNode.replaceChild(newCloseBtn, oldCloseBtn);
    }

    // Clone menu links too
    document.querySelectorAll('#mo-menu a').forEach(function(link) {
        var newLink = link.cloneNode(true);
        link.parentNode.replaceChild(newLink, link);
    });

    var isOpen = false;
    var isAnimating = false;

    // Ensure starts closed
    overlay.classList.add('slideDown');

    // Backdrop para desktop Y mobile (clickeable para cerrar)
    // En mobile, el backdrop aparece detras del sidebar fullscreen.
    // Aunque no se vea (el sidebar lo cubre), permite cerrar al tap fuera
    // si el usuario llegara a ver una porcion (en tablets portrait).
    var backdrop = null;
    function isDesktop() { return window.innerWidth >= 768; }

    function ensureBackdrop() {
        if (backdrop) return backdrop;
        backdrop = document.createElement('div');
        backdrop.className = 'dsm-backdrop';
        backdrop.addEventListener('click', closeMenu);
        document.body.appendChild(backdrop);
        return backdrop;
    }

    function showBackdrop() {
        // Mostrar backdrop tanto en desktop como en mobile (el CSS de cada
        // breakpoint controla si se ve o no, JS solo se asegura de tenerlo)
        ensureBackdrop();
        backdrop.style.display = 'block';
        // forzar reflow antes de la transicion
        backdrop.offsetHeight;
        backdrop.classList.add('dsm-visible');
    }
    function hideBackdrop() {
        if (!backdrop) return;
        backdrop.classList.remove('dsm-visible');
        setTimeout(function () {
            if (backdrop && !backdrop.classList.contains('dsm-visible')) {
                backdrop.style.display = 'none';
            }
        }, 560);
    }

    function openMenu() {
        if (isOpen || isAnimating) return;
        isAnimating = true;
        isOpen = true;

        document.body.style.overflow = 'hidden';

        // Limpiar cualquier estilo inline residual de animaciones viejas
        // (top, transition) que pudieran interferir con el CSS nuevo
        overlay.style.top = '';
        overlay.style.transition = '';

        // Quitar slideDown: el CSS detecta :not(.slideDown) y anima
        // con translateX(0) tanto en desktop como en mobile
        overlay.classList.remove('slideDown');

        // Backdrop (mobile + desktop)
        showBackdrop();

        // Cambiar icono hamburguesa a X
        newMenuBtn.classList.remove('unclick');
        newMenuBtn.classList.add('clicked');

        setTimeout(function() { isAnimating = false; }, 550);
    }

    function closeMenu() {
        if (!isOpen || isAnimating) return;
        isAnimating = true;

        // Ocultar backdrop (animado via CSS opacity)
        hideBackdrop();

        // Cambiar icono X a hamburguesa
        newMenuBtn.classList.remove('clicked');
        newMenuBtn.classList.add('unclick');

        // Mismo approach en desktop y mobile: el CSS controla la animacion
        // con translateX(-100%) cuando slideDown esta presente
        overlay.classList.add('slideDown');

        setTimeout(function () {
            document.body.style.overflow = '';
            isOpen = false;
            isAnimating = false;
        }, 450);
    }

    // Attach handlers to cloned elements (no old listeners)
    newMenuBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        openMenu();
    });

    if (newCloseBtn) {
        newCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMenu();
        });
    }

    document.querySelectorAll('#mo-menu a').forEach(function(link) {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) closeMenu();
    });

    // Kill any jQuery handlers that designesia.js might add later
    if (window.jQuery) {
        setTimeout(function() {
            jQuery('#menu-btn').off();
            jQuery('#mo-button-close').off();
        }, 500);
        setTimeout(function() {
            jQuery('#menu-btn').off();
            jQuery('#mo-button-close').off();
        }, 1000);
    }
});
