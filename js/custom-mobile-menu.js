/**
 * Mobile Menu - Casa Xu'unan
 * Works WITH the slideDown class system
 */
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    if (window.innerWidth >= 993) return;

    var overlay = document.getElementById('menu-overlay');
    var menuBtn = document.getElementById('menu-btn');
    var mainMenu = document.getElementById('mainmenu');

    if (!overlay || !menuBtn) return;
    if (mainMenu) mainMenu.style.display = 'none';

    // ===== DEBUG: log de clases del header en cada interaccion =====
    function logHeader(label) {
        var h = document.querySelector('header');
        if (!h) return;
        console.log('[DEBUG ' + label + '] header.className =', h.className);
        console.log('[DEBUG ' + label + '] header computed background =',
            window.getComputedStyle(h).backgroundColor);
        console.log('[DEBUG ' + label + '] overlay.className =', overlay.className);
        console.log('[DEBUG ' + label + '] body.style.overflow =', document.body.style.overflow);
        console.log('---');
    }
    logHeader('INICIAL');

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

        logHeader('ANTES DE ABRIR');

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

        setTimeout(function() {
            isAnimating = false;
            logHeader('DESPUES DE ABRIR');
        }, 450);
    }

    function closeMenu() {
        if (!isOpen || isAnimating) return;
        isAnimating = true;

        logHeader('ANTES DE CERRAR');

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
            logHeader('DESPUES DE CERRAR');
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
