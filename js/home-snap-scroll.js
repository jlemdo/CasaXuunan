/**
 * Home Snap Scroll — hero <-> 2da seccion
 * Casa Xu'unan
 *
 * Comportamiento:
 * - Usuario en hero + hace scroll hacia abajo -> salta smooth al inicio
 *   de la 2da seccion (#hp-lujo).
 * - Usuario cerca del top de la 2da seccion + hace scroll hacia arriba
 *   -> salta smooth al hero (top 0).
 *
 * Solo activo en:
 * - Home (index.php)
 * - Desktop (min-width 768px)
 * - Respeta prefers-reduced-motion
 *
 * Anti-abuso:
 * - Debounce 700ms: una vez ejecutado el salto, ignora scrolls hasta
 *   terminar la animacion + 200ms extra.
 * - Se desactiva despues de la 2da seccion (el usuario ya paso el umbral
 *   y puede navegar el resto de la pagina normal).
 * - Ignora scrolls pequenos (deltaY < 5) para no activarse con trackpads
 *   ultra-sensibles.
 */

(function () {
    'use strict';

    // Home solamente
    var page = (location.pathname.split('/').pop() || 'index.php').toLowerCase();
    if (page !== '' && page !== '/' && page !== 'index.php') return;

    // Desktop solamente
    var mq = window.matchMedia('(min-width: 768px)');
    if (!mq.matches) return;

    // Accesibilidad: respetar prefers-reduced-motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    function init() {
        var hero = document.querySelector('.hp-hero-spacer');
        var section2 = document.getElementById('hp-lujo');
        if (!hero || !section2) return;

        var isAnimating = false;
        var lastAction = 0;
        var COOLDOWN_MS = 900; // tiempo antes de permitir otro salto
        var MIN_DELTA = 5;     // ignora scrolls ultra-pequenos

        // Detectar si el usuario esta interactuando con el widget Hospitable
        // (click en check-in, calendario, guests). Si es asi, NO activar snap.
        function isInteractingWithWidget(target) {
            if (!target) return false;
            // Elemento es o esta dentro del widget Hospitable
            if (target.closest && target.closest('hospitable-direct-mps')) return true;
            if (target.closest && target.closest('.home-search-section')) return true;
            if (target.closest && target.closest('.home-search-wrapper')) return true;
            if (target.closest && target.closest('.search-widget-container')) return true;
            // Hospitable usa shadow DOM; si el target es el custom element, esta interactuando
            if (target.tagName && target.tagName.toLowerCase() === 'hospitable-direct-mps') return true;
            return false;
        }

        // Timestamp de ultima interaccion con widget — ignoramos scroll 1s despues
        var lastWidgetInteraction = 0;
        document.addEventListener('click', function (e) {
            if (isInteractingWithWidget(e.target)) {
                lastWidgetInteraction = Date.now();
            }
        }, true);
        document.addEventListener('focusin', function (e) {
            if (isInteractingWithWidget(e.target)) {
                lastWidgetInteraction = Date.now();
            }
        }, true);

        function smoothScrollTo(targetY) {
            isAnimating = true;
            lastAction = Date.now();
            window.scrollTo({
                top: targetY,
                behavior: 'smooth'
            });
            setTimeout(function () {
                isAnimating = false;
            }, COOLDOWN_MS);
        }

        function getHeroHeight() {
            return hero.offsetHeight; // 100vh
        }

        function getSection2Top() {
            var rect = section2.getBoundingClientRect();
            return window.pageYOffset + rect.top;
        }

        window.addEventListener('wheel', function (e) {
            // No actuar durante animacion o cooldown
            if (isAnimating) return;
            if (Date.now() - lastAction < COOLDOWN_MS) return;
            if (Math.abs(e.deltaY) < MIN_DELTA) return;

            // No actuar si el usuario esta interactuando con el widget
            if (Date.now() - lastWidgetInteraction < 1500) return;
            if (isInteractingWithWidget(e.target)) return;

            // No actuar si el widget esta expandido (calendario/guests abierto)
            // El index.php agrega style transform al .home-search-section cuando expande
            var searchSection = document.querySelector('.home-search-section');
            if (searchSection && searchSection.style.transform &&
                searchSection.style.transform.indexOf('translateY(-') !== -1 &&
                searchSection.style.transform !== 'translateY(0)' &&
                searchSection.style.transform !== 'translateY(0px)') {
                return;
            }

            var scrollY = window.pageYOffset;
            var heroH = getHeroHeight();
            var sec2Top = getSection2Top();

            // Usuario en hero (scroll < 80% del hero) + scroll hacia abajo
            if (e.deltaY > 0 && scrollY < heroH * 0.8) {
                e.preventDefault();
                smoothScrollTo(sec2Top);
                return;
            }

            // Usuario en 2da seccion (cerca del inicio, < 30% scroll del hero)
            // + scroll hacia arriba → vuelve al hero
            if (e.deltaY < 0) {
                var distanceFromSec2 = scrollY - sec2Top;
                // Si estamos entre el inicio de sec2 y +200px del mismo, y scroll up → hero
                if (distanceFromSec2 >= -50 && distanceFromSec2 < 200) {
                    e.preventDefault();
                    smoothScrollTo(0);
                    return;
                }
            }

            // Resto del sitio: scroll normal (no interferimos)
        }, { passive: false });

        // Touch devices: handle touchmove similar (aunque en desktop min-width 768 casi no hay)
        var touchStartY = 0;
        window.addEventListener('touchstart', function (e) {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        window.addEventListener('touchend', function (e) {
            if (isAnimating) return;
            if (Date.now() - lastAction < COOLDOWN_MS) return;

            // No actuar si hay interaccion reciente con el widget
            if (Date.now() - lastWidgetInteraction < 1500) return;
            if (isInteractingWithWidget(e.target)) return;

            var touchEndY = e.changedTouches[0].clientY;
            var deltaY = touchStartY - touchEndY;
            if (Math.abs(deltaY) < 30) return; // swipe muy corto, ignorar

            var scrollY = window.pageYOffset;
            var heroH = getHeroHeight();
            var sec2Top = getSection2Top();

            if (deltaY > 0 && scrollY < heroH * 0.8) {
                smoothScrollTo(sec2Top);
            } else if (deltaY < 0) {
                var distanceFromSec2 = scrollY - sec2Top;
                if (distanceFromSec2 >= -50 && distanceFromSec2 < 200) {
                    smoothScrollTo(0);
                }
            }
        }, { passive: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
