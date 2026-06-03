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

    // ========== HERO ELEMENTS - FADE PROGRESIVO CON SCROLL ==========
    // Estilo Booking/Airbnb 2026: los elementos del hero (search bar, textos,
    // reviews btn, social icons, slider controls) NO se ocultan ON/OFF, sino
    // que su opacity baja PROGRESIVAMENTE con el scroll.
    //
    // Curva de fade (en % scrolleado del primer viewport):
    //   0% scroll  -> opacity 1.0 (totalmente visible)
    //   15% scroll -> opacity 1.0 (sin cambio aun)
    //   45% scroll -> opacity 0.0 (totalmente invisible)
    //   >45%       -> opacity 0.0 + visibility:hidden (no captura clicks)
    //
    // Esto permite que al llegar a la primera seccion ya este completamente
    // oculto, sin "pop" brusco. Usa requestAnimationFrame para 60fps fluido.

    var heroSelectors = [
        '.float-text',                    // social icons flotantes laterales
        '#slidecaption',                  // textos del slider (Relajate/Confort/Paz)
        '.reviews-scroll-btn-wrapper',    // boton 'Ver Comentarios 4.8'
        '.home-search-section',           // SEARCH BAR
        '#controls-wrapper',              // controles desktop del slider
        '#progress-back',                 // barra progreso slider
        '#prevslide',                     // flecha anterior slider
        '#nextslide'                      // flecha siguiente slider
    ];

    var heroEls = [];
    var lastOpacity = -1;        // cache para evitar repaint innecesario
    var rafScheduled = false;

    // Puntos clave del fade (% del primer viewport)
    var FADE_START = 0.15;  // antes de 15% scroll, full visible
    var FADE_END = 0.45;    // despues de 45% scroll, full invisible

    function initHeroEls() {
        heroSelectors.forEach(function(sel) {
            var el = document.querySelector(sel);
            if (el) heroEls.push(el);
        });
        // Setear transicion CSS solo para visibility (la opacity la manejamos JS)
        heroEls.forEach(function(el) {
            el.style.willChange = 'opacity';
        });
    }

    function updateHeroOpacity() {
        rafScheduled = false;

        var y = window.pageYOffset || 0;
        var vh = window.innerHeight;
        var progress = y / vh;  // 0 = top, 1 = scrolleado 1 viewport

        // Calcular opacity con curva lineal entre FADE_START y FADE_END
        var opacity;
        if (progress <= FADE_START) {
            opacity = 1;
        } else if (progress >= FADE_END) {
            opacity = 0;
        } else {
            var range = FADE_END - FADE_START;
            opacity = 1 - ((progress - FADE_START) / range);
        }

        // Redondear a 2 decimales para evitar repaints innecesarios
        opacity = Math.round(opacity * 100) / 100;

        if (opacity === lastOpacity) return;
        lastOpacity = opacity;

        // Aplicar a todos los elementos del hero
        heroEls.forEach(function(el) {
            el.style.opacity = opacity;
            // Cuando ya es invisible, quitarlo del flujo de interaccion
            if (opacity === 0) {
                el.style.visibility = 'hidden';
                el.style.pointerEvents = 'none';
            } else {
                el.style.visibility = 'visible';
                el.style.pointerEvents = '';
            }
        });
    }

    function onScrollHero() {
        if (rafScheduled) return;
        rafScheduled = true;
        requestAnimationFrame(updateHeroOpacity);
    }

    function initHeroFade() {
        initHeroEls();
        if (heroEls.length === 0) return;

        // Set inicial
        updateHeroOpacity();

        // Listen scroll (passive para no bloquear scroll mobile)
        window.addEventListener('scroll', onScrollHero, { passive: true });

        // Tambien actualizar al resize (cambia vh)
        window.addEventListener('resize', onScrollHero, { passive: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroFade);
    } else {
        initHeroFade();
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
