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
    var widgetActive = false;    // true cuando widget Hospitable esta abierto

    // Puntos clave del fade (% del primer viewport)
    var FADE_START = 0.15;  // antes de 15% scroll, full visible
    var FADE_END = 0.45;    // despues de 45% scroll, full invisible

    // ========== DETECTAR cuando widget Hospitable esta activo ==========
    // Cuando el usuario abre el calendario/huespedes, expandSearch() agrega
    // un transform al .home-search-section y un overlay oscuro al body.
    // En este estado, NO queremos que el fade reduzca opacity del hero,
    // porque el usuario esta interactuando con la barra de busqueda.
    //
    // Usamos MutationObserver para detectar el cambio de transform de
    // .home-search-section (que solo sucede cuando expandSearch corre).
    function initWidgetActiveDetector() {
        var section = document.querySelector('.home-search-section');
        if (!section || !('MutationObserver' in window)) return;

        var observer = new MutationObserver(function() {
            // Si el section tiene transform: translateY(-N px) = widget activo
            var transform = section.style.transform || '';
            var newState = transform.indexOf('translateY(-') > -1 &&
                           transform.indexOf('-0px') === -1;

            if (newState !== widgetActive) {
                widgetActive = newState;
                // Forzar update del fade (resetear cache para que se reaplique)
                lastOpacity = -1;
                if (rafScheduled) return;
                rafScheduled = true;
                requestAnimationFrame(updateHeroOpacity);
            }
        });

        observer.observe(section, {
            attributes: true,
            attributeFilter: ['style']
        });
    }

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

    // Umbral de interactividad: cuando opacity baja de este valor,
    // se desactivan TODOS los clicks aunque visualmente aun se vea algo.
    // Razon: 0.15 = elemento ya casi invisible al ojo (15% opacity)
    // pero el bug era que con opacity 0.01 los clicks seguian llegando.
    var INTERACTIVE_THRESHOLD = 0.15;

    function updateHeroOpacity() {
        rafScheduled = false;

        var opacity;

        // FIX BUG: cuando el widget Hospitable esta activo (calendario o
        // huespedes abiertos), expandSearch() sube el search bar con un
        // transform. El navegador tambien hace focus-scroll auto al input.
        // En ese momento NO debemos reducir opacity del search bar - el
        // usuario esta interactuando con el. Forzamos opacity 1.
        if (widgetActive) {
            opacity = 1;
        } else {
            var y = window.pageYOffset || 0;
            var vh = window.innerHeight;
            var progress = y / vh;  // 0 = top, 1 = scrolleado 1 viewport

            // Calcular opacity con curva lineal entre FADE_START y FADE_END
            if (progress <= FADE_START) {
                opacity = 1;
            } else if (progress >= FADE_END) {
                opacity = 0;
            } else {
                var range = FADE_END - FADE_START;
                opacity = 1 - ((progress - FADE_START) / range);
            }
        }

        // Redondear a 2 decimales para evitar repaints innecesarios
        opacity = Math.round(opacity * 100) / 100;

        if (opacity === lastOpacity) return;
        lastOpacity = opacity;

        // Determinar si los elementos deben ser interactivos.
        // FIX: antes solo desactivabamos clicks con opacity === 0 (exacto).
        // Ahora desactivamos cuando opacity < umbral (15%) para evitar la
        // "zona fantasma" donde el elemento es visualmente invisible pero
        // aun captura clicks. Tambien fuerza pointer-events: none en el
        // Shadow DOM del widget Hospitable.
        var interactive = opacity > INTERACTIVE_THRESHOLD;

        heroEls.forEach(function(el) {
            el.style.opacity = opacity;

            if (interactive) {
                el.style.visibility = 'visible';
                el.style.pointerEvents = '';
                el.removeAttribute('data-hero-hidden');
            } else {
                // Cuando NO interactivo: usar 'hidden' + pointer-events none
                // + atributo data-hero-hidden para que CSS pueda forzar
                // pointer-events:none con !important en TODOS los hijos
                // (cubre Shadow DOM y children con z-index alto que pudieran
                // capturar clicks "fantasma").
                el.style.visibility = 'hidden';
                el.style.pointerEvents = 'none';
                el.setAttribute('data-hero-hidden', '');
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

        // Detectar cuando widget Hospitable esta activo para pausar fade
        initWidgetActiveDetector();
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
