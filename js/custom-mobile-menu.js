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

    function openMenu() {
        if (isOpen || isAnimating) return;
        isAnimating = true;
        isOpen = true;

        document.body.style.overflow = 'hidden';
        overlay.classList.remove('slideDown');
        overlay.style.transition = 'none';
        overlay.style.top = '-100%';
        overlay.offsetHeight;
        overlay.style.transition = 'top 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
        overlay.style.top = '0';

        // Cambiar icono hamburguesa a X (clases que usa el CSS existente)
        newMenuBtn.classList.remove('unclick');
        newMenuBtn.classList.add('clicked');

        setTimeout(function() { isAnimating = false; }, 450);
    }

    function closeMenu() {
        if (!isOpen || isAnimating) return;
        isAnimating = true;

        overlay.style.transition = 'top 0.35s cubic-bezier(0.5, 0, 0.75, 0)';
        overlay.style.top = '-100%';

        // Cambiar icono X a hamburguesa
        newMenuBtn.classList.remove('clicked');
        newMenuBtn.classList.add('unclick');

        setTimeout(function() {
            overlay.classList.add('slideDown');
            overlay.style.transition = 'none';
            overlay.style.top = '';
            document.body.style.overflow = '';
            isOpen = false;
            isAnimating = false;
        }, 380);
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
