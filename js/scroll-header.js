/**
 * Scroll Header Overlay
 * Casa Xu'unan
 *
 * Adds .header-scrolled class to <header> when the user scrolls > 30px,
 * on any page except index.php (home).
 * Handles both window scroll AND internal #content-absolute scroll
 * (used by search.php, room.php).
 */

(function () {
    'use strict';

    // Home: solo aplica overlay en desktop (min-width 768px)
    var page = (location.pathname.split('/').pop() || 'index.php').toLowerCase();
    var isHome = (page === '' || page === '/' || page === 'index.php' || page === 'index-full-page.php');
    var isMobile = window.matchMedia('(max-width: 767px)').matches;
    if (isHome && isMobile) {
        return; // Home mobile: NO aplicar overlay
    }

    var THRESHOLD = 30;
    var header = null;
    var ticking = false;

    function applyState(scrollY) {
        if (!header) return;
        if (scrollY > THRESHOLD) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    }

    function onScroll(scrollY) {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                applyState(scrollY);
                ticking = false;
            });
            ticking = true;
        }
    }

    function init() {
        header = document.querySelector('header');
        if (!header) return;

        // Listen window scroll
        window.addEventListener('scroll', function () {
            onScroll(window.pageYOffset || document.documentElement.scrollTop || 0);
        }, { passive: true });

        // Listen internal scroll container (search.php, room.php)
        var internal = document.querySelector('#content-absolute');
        if (internal) {
            internal.addEventListener('scroll', function () {
                onScroll(internal.scrollTop || 0);
            }, { passive: true });
        }

        // Initial state on load
        var initialY = (internal && internal.scrollTop) || window.pageYOffset || 0;
        applyState(initialY);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
