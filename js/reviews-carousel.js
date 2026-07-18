/**
 * Reviews Carousel - Casa Xu'unan
 *
 * Carrusel de reseñas con:
 * - Auto-scroll continuo y suave (avanza solo)
 * - Pausa al hacer hover (mouse encima)
 * - Arrastrable con mouse (drag) y con dedo (touch nativo)
 * - Loop infinito: al llegar al final, vuelve al inicio sin salto
 * - Sin flechas
 *
 * Aplica sobre el contenedor .hp-reviews-carousel que ya existe en el home.
 */
(function () {
    'use strict';

    function initCarousel() {
        var carousel = document.querySelector('.hp-reviews-carousel');
        if (!carousel) return;

        // Config
        var SPEED = 0.5;          // px por frame (~30px/seg a 60fps) - lento y elegante
        var isPaused = false;
        var isDragging = false;
        var startX = 0;
        var scrollStartX = 0;
        var rafId = null;

        // ===== AUTO-SCROLL =====
        function autoScrollStep() {
            if (!isPaused && !isDragging) {
                carousel.scrollLeft += SPEED;

                // Loop infinito: si llegamos cerca del final, volver al inicio.
                // scrollWidth - clientWidth = maximo scroll posible.
                var maxScroll = carousel.scrollWidth - carousel.clientWidth;
                if (carousel.scrollLeft >= maxScroll - 1) {
                    carousel.scrollLeft = 0;
                }
            }
            rafId = requestAnimationFrame(autoScrollStep);
        }

        // ===== PAUSA EN HOVER =====
        carousel.addEventListener('mouseenter', function () {
            isPaused = true;
        });
        carousel.addEventListener('mouseleave', function () {
            isPaused = false;
        });

        // ===== DRAG CON MOUSE =====
        carousel.addEventListener('mousedown', function (e) {
            isDragging = true;
            carousel.classList.add('hp-carousel-grabbing');
            startX = e.pageX - carousel.offsetLeft;
            scrollStartX = carousel.scrollLeft;
            e.preventDefault(); // evita seleccion de texto/imagen al arrastrar
        });

        document.addEventListener('mousemove', function (e) {
            if (!isDragging) return;
            var x = e.pageX - carousel.offsetLeft;
            var walk = (x - startX); // distancia arrastrada
            carousel.scrollLeft = scrollStartX - walk;
        });

        document.addEventListener('mouseup', function () {
            if (isDragging) {
                isDragging = false;
                carousel.classList.remove('hp-carousel-grabbing');
            }
        });

        // ===== TOUCH (dedo) =====
        // El scroll táctil nativo ya funciona (overflow-x: auto).
        // Solo pausamos el auto-scroll mientras el dedo toca, y lo
        // reanudamos al soltar.
        carousel.addEventListener('touchstart', function () {
            isPaused = true;
        }, { passive: true });

        carousel.addEventListener('touchend', function () {
            // Pequeño delay para que el momentum del scroll táctil termine
            setTimeout(function () { isPaused = false; }, 800);
        }, { passive: true });

        // ===== PAUSA cuando el carrusel NO esta visible =====
        // Ahorra CPU/bateria si el usuario no lo esta viendo.
        if ('IntersectionObserver' in window) {
            var visObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    // Si esta fuera de pantalla, pausar (pero no pisar el hover)
                    if (!entry.isIntersecting) {
                        isPaused = true;
                    } else if (!isDragging) {
                        isPaused = false;
                    }
                });
            }, { threshold: 0.1 });
            visObserver.observe(carousel);
        }

        // Arrancar el auto-scroll
        rafId = requestAnimationFrame(autoScrollStep);
    }

    // Init cuando el DOM este listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }
})();
