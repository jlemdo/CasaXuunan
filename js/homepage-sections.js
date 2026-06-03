/**
 * Homepage Sections - Casa Xu'unan
 * Scroll natural libre + Hero visibility con IntersectionObserver
 *
 * REFACTOR (jun 2026): Eliminado modelo de 2 estados (hero/sections) viejo:
 *   - Trigger automatico 6% viewport (saltos no deseados)
 *   - Lock 1200ms bloqueaba scroll mobile
 *   - Contador acumulado disparaba goToHero accidental
 *   - Estado y=0 causaba flashes visuales
 *
 * NUEVA ARQUITECTURA:
 *   1) Scroll: libre, natural como Booking/Airbnb/Hilton (sin JS de scroll)
 *   2) Hero visibility: IntersectionObserver detecta cuando .hp-hero-spacer
 *      (100dvh inicial) sale del viewport -> oculta search bar, slidecaption,
 *      reviews btn, social float. Al volver, los muestra otra vez.
 *      Sin scroll-listeners pesados, sin locks, sin contadores acumulados.
 *
 * Mantiene:
 *   - Counter animado al entrar en viewport
 *   - Boton "Ver todas reviews" abre overlay
 *   - Header "Book Now" -> search.php con fechas
 *   - Boton scroll fijo bottom-right (icono cambia con scroll position)
 */
(function() {
    'use strict';

    // ========== HERO ELEMENTS VISIBILITY ==========
    // Lista de selectores de elementos del hero que deben ocultarse
    // cuando el usuario hace scroll fuera del hero (entra a las secciones).
    // Razon: estos elementos son position:fixed/absolute y se quedarian
    // flotando sobre las secciones de abajo, tapando contenido.
    var heroSelectors = [
        '.float-text',                    // social icons flotantes laterales
        '#slidecaption',                  // textos del slider (Relajate/Confort/Paz)
        '.reviews-scroll-btn-wrapper',    // boton 'Ver Comentarios 4.8'
        '.home-search-section',           // SEARCH BAR (el del bug que reportaste)
        '#controls-wrapper',              // controles desktop del slider
        '#progress-back',                 // barra progreso slider
        '#prevslide',                     // flecha anterior slider
        '#nextslide'                      // flecha siguiente slider
    ];

    // Cache de elementos para no re-buscar en cada cambio
    var heroEls = [];

    function initHeroEls() {
        heroSelectors.forEach(function(sel) {
            var el = document.querySelector(sel);
            if (el) heroEls.push(el);
        });
    }

    function hideHeroEls() {
        heroEls.forEach(function(el) {
            el.style.transition = 'opacity 0.3s ease, visibility 0s linear 0.3s';
            el.style.opacity = '0';
            el.style.visibility = 'hidden';
            el.style.pointerEvents = 'none';
        });
    }

    function showHeroEls() {
        heroEls.forEach(function(el) {
            el.style.transition = 'opacity 0.3s ease, visibility 0s';
            el.style.opacity = '1';
            el.style.visibility = 'visible';
            el.style.pointerEvents = '';
        });
    }

    // Observer: vigila el hp-hero-spacer (que ocupa 100dvh inicial).
    // Cuando este sale del viewport = el usuario salio del hero.
    // Mucho mas eficiente y confiable que scroll listeners.
    function initHeroObserver() {
        var spacer = document.querySelector('.hp-hero-spacer');
        if (!spacer || !('IntersectionObserver' in window)) return;

        initHeroEls();

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                // intersectionRatio nos dice cuanto del spacer esta visible
                // > 0.05 = al menos 5% del hero visible -> mostrar hero
                // <= 0.05 = el hero practicamente desaparecio -> ocultarlo
                if (entry.intersectionRatio > 0.05) {
                    showHeroEls();
                } else {
                    hideHeroEls();
                }
            });
        }, {
            // threshold multiple para detectar el momento exacto de cruce
            threshold: [0, 0.05, 0.1]
        });

        observer.observe(spacer);
    }

    // Init cuando DOM listo (los elementos del hero deben existir)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroObserver);
    } else {
        initHeroObserver();
    }

    // ========== SCROLL BUTTON (fijo bottom-right) ==========
    var scrollBtn = document.getElementById('hp-scroll-btn');

    function updateScrollBtn() {
        if (!scrollBtn) return;
        var icon = scrollBtn.querySelector('i');
        if (!icon) return;

        var y = window.pageYOffset || 0;
        var vh = window.innerHeight;

        // Si esta en el primer viewport (cerca del hero) -> apunta hacia abajo
        // Si esta debajo del hero -> apunta hacia arriba
        if (y < vh * 0.5) {
            icon.className = 'fa fa-angle-down';
            scrollBtn.classList.add('hp-scroll-btn-bounce');
        } else {
            icon.className = 'fa fa-angle-up';
            scrollBtn.classList.remove('hp-scroll-btn-bounce');
        }
    }

    // Update icon on scroll (passive para performance)
    var scrollTimer = null;
    window.addEventListener('scroll', function() {
        if (scrollTimer) return;
        scrollTimer = requestAnimationFrame(function() {
            updateScrollBtn();
            scrollTimer = null;
        });
    }, { passive: true });

    // ========== SCROLL BUTTON CLICK ==========
    if (scrollBtn) {
        scrollBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var y = window.pageYOffset || 0;
            var vh = window.innerHeight;

            if (y < vh * 0.5) {
                // Estoy arriba -> bajar a primera seccion
                var firstSection = document.getElementById('hp-lujo');
                if (firstSection) {
                    firstSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else {
                // Estoy abajo -> subir al top (hero)
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    // ========== HELPER: URL de search con fechas pre-llenadas ==========
    // Genera URL con checkin=hoy, checkout=hoy+2, adults=2
    // El widget Hospitable lee estos params y pre-llena el formulario.
    function getSearchUrl() {
        var today = new Date();
        var checkout = new Date();
        checkout.setDate(today.getDate() + 2);

        function fmt(d) {
            var y = d.getFullYear();
            var m = String(d.getMonth() + 1).padStart(2, '0');
            var day = String(d.getDate()).padStart(2, '0');
            return y + '-' + m + '-' + day;
        }

        return '/search.php?checkin=' + fmt(today) +
               '&checkout=' + fmt(checkout) +
               '&adults=2';
    }

    // ========== HEADER BOOK NOW -> search.php con fechas ==========
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-main.btn-mobile-reservas, .btn-main.btn-reservas');
        if (btn && btn.closest('header')) {
            e.preventDefault();
            window.location.href = getSearchUrl();
        }
    });

    // ========== CTA "Volver al hero" buttons -> search.php con fechas ==========
    // Los botones con clase hp-scroll-to-hero antes scrolleaban arriba.
    // Ahora redirigen directamente al buscador pre-llenado (menos friccion = mas conversion).
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.hp-scroll-to-hero');
        if (btn) {
            e.preventDefault();
            window.location.href = getSearchUrl();
        }
    });

    // ========== VER TODAS REVIEWS -> abre overlay ==========
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('#hp-see-all-reviews');
        if (btn) {
            e.preventDefault();
            var reviewsBtn = document.getElementById('open-reviews-overlay');
            if (reviewsBtn) reviewsBtn.click();
        }
    });

    // ========== ANIMATED COUNTER (al entrar al viewport) ==========
    var counterEl = document.querySelector('.hp-counter-number[data-count]');
    if (counterEl && 'IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var target = parseInt(entry.target.getAttribute('data-count'), 10);
                    if (isNaN(target)) return;
                    var start = null;
                    (function step(ts) {
                        if (!start) start = ts;
                        var p = Math.min((ts - start) / 2000, 1);
                        var v = Math.floor(target * (1 - Math.pow(1 - p, 3)));
                        entry.target.textContent = v + '+';
                        if (p < 1) requestAnimationFrame(step);
                        else entry.target.textContent = target + '+';
                    })(performance.now());
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        obs.observe(counterEl);
    }

    // ========== INIT ==========
    updateScrollBtn();

})();
