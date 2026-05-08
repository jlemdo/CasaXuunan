/**
 * Homepage Sections - Casa Xu'unan
 * Clean rewrite: scroll snap, hero visibility, counter, CTAs
 * Compatible: Chrome, Safari, Firefox, mobile + desktop
 */
(function() {
    'use strict';

    // ========== STATE ==========
    var state = 'hero'; // 'hero' or 'sections'
    var locked = false;

    function lock(ms) {
        locked = true;
        setTimeout(function() { locked = false; }, ms || 1000);
    }

    // ========== HERO ELEMENTS ==========
    // Gather all hero fixed/absolute elements that must hide when in sections
    var heroSelectors = [
        'header',
        '.float-text',
        '#slidecaption',
        '.reviews-scroll-btn-wrapper',
        '.home-search-section',
        '#controls-wrapper',
        '#progress-back',
        '#prevslide',
        '#nextslide'
    ];

    // Store original display values so we can restore them
    var heroOriginals = [];
    var heroReady = false;

    function initHeroEls() {
        if (heroReady) return;
        heroSelectors.forEach(function(sel) {
            var el = document.querySelector(sel);
            if (el) {
                heroOriginals.push({
                    el: el,
                    display: getComputedStyle(el).display,
                    visibility: getComputedStyle(el).visibility
                });
            }
        });
        heroReady = true;
    }

    function hideHero() {
        initHeroEls();
        heroOriginals.forEach(function(item) {
            item.el.style.transition = 'opacity 0.4s ease';
            item.el.style.opacity = '0';
        });
        // After fade, fully remove from layout
        setTimeout(function() {
            if (state !== 'sections') return;
            heroOriginals.forEach(function(item) {
                item.el.style.display = 'none';
                item.el.style.pointerEvents = 'none';
            });
        }, 400);
    }

    function showHero() {
        initHeroEls();
        // First restore display and visibility
        heroOriginals.forEach(function(item) {
            item.el.style.display = item.display;
            item.el.style.visibility = 'visible';
            item.el.style.pointerEvents = '';
            item.el.style.opacity = '0';
        });
        // Then fade in on next frame
        requestAnimationFrame(function() {
            heroOriginals.forEach(function(item) {
                item.el.style.transition = 'opacity 0.4s ease';
                item.el.style.opacity = '1';
            });
            // Clean up inline styles after animation
            setTimeout(function() {
                if (state !== 'hero') return;
                heroOriginals.forEach(function(item) {
                    item.el.style.transition = '';
                    item.el.style.opacity = '';
                });
            }, 450);
        });
    }

    // ========== SCROLL BUTTON ==========
    var scrollBtn = document.getElementById('hp-scroll-btn');

    function updateScrollBtn() {
        if (!scrollBtn) return;
        var icon = scrollBtn.querySelector('i');
        if (!icon) return;
        if (state === 'sections') {
            icon.className = 'fa fa-angle-up';
            scrollBtn.classList.remove('hp-scroll-btn-bounce');
        } else {
            icon.className = 'fa fa-angle-down';
            scrollBtn.classList.add('hp-scroll-btn-bounce');
        }
    }

    // ========== NAVIGATION ==========
    function goToSections() {
        if (locked || state === 'sections') return;
        state = 'sections';
        lock(1200);
        hideHero();
        updateScrollBtn();
        var target = document.getElementById('hp-lujo');
        if (target) target.scrollIntoView({ behavior: 'smooth' });
    }

    function goToHero() {
        if (locked || state === 'hero') return;
        state = 'hero';
        lock(1200);
        showHero();
        updateScrollBtn();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ========== HOSPITABLE WIDGET SHIELD ==========
    // Cuando el usuario interactua con el widget (click en Check-in, 2 adults,
    // calendar, etc), el navegador hace focus-scroll automatico al input dentro
    // del Shadow DOM. Este micro-scroll dispara goToSections() falsamente y
    // baja la pagina hasta "EL LUJO DE LO AUTENTICO".
    //
    // Solucion: detectar cuando el widget esta activo y BLOQUEAR el auto-scroll
    // detection durante esa interaccion. El usuario sigue pudiendo scrollear
    // manualmente, pero el widget no dispara cambios de seccion accidentales.
    function isHospitableWidgetActive() {
        var widget = document.querySelector('.home-search-wrapper hospitable-direct-mps');
        if (!widget) return false;

        // 1. Si el wrapper tiene background oscuro = expandido (calendario o huespedes abierto)
        var wrapper = document.querySelector('.home-search-wrapper');
        if (wrapper && wrapper.style.background && wrapper.style.background.indexOf('rgba') > -1) {
            return true;
        }

        // 2. Si hay un input/elemento del widget tiene focus actualmente
        if (document.activeElement === widget) return true;
        if (widget.shadowRoot && widget.shadowRoot.activeElement) return true;

        // 3. Si hay un dropdown abierto dentro del shadowRoot (calendario/guests)
        if (widget.shadowRoot) {
            var dpc = widget.shadowRoot.querySelector('.date-picker-container');
            if (dpc && dpc.offsetHeight > 0) return true;
            var guests = widget.shadowRoot.querySelector('.guests-expanded');
            if (guests && guests.offsetHeight > 0) return true;
        }

        return false;
    }

    // Lock extendido cuando se hace click DENTRO del widget (cubre el delay
    // de focus-scroll del navegador que tarda hasta ~300ms en dispararse)
    var searchWrapperEl = document.querySelector('.home-search-wrapper');
    if (searchWrapperEl) {
        searchWrapperEl.addEventListener('click', function() {
            if (state === 'hero') {
                lock(800); // bloquea detection ~800ms (cubre focus-scroll nativo)
            }
        }, true);

        // Mismo para mousedown (algunos browsers disparan focus en mousedown)
        searchWrapperEl.addEventListener('mousedown', function() {
            if (state === 'hero') {
                lock(800);
            }
        }, true);
    }

    // ========== SCROLL DETECTION ==========
    // Simple approach: detect scroll direction + position
    var lastY = 0;
    var scrollCount = 0; // counts consecutive same-direction scrolls

    window.addEventListener('scroll', function() {
        if (locked) return;

        // ESCUDO: si el widget de Hospitable esta activo, ignorar scroll
        // detection (evita que focus-scroll del navegador dispare goToSections)
        if (isHospitableWidgetActive()) return;

        var y = window.pageYOffset || 0;
        var vh = window.innerHeight;

        if (state === 'hero' && y > vh * 0.06) {
            // User scrolled down past 6% of viewport — go to sections
            goToSections();
        } else if (state === 'sections' && y < vh * 0.4 && y < lastY) {
            // User is scrolling UP and is in the top 40% — go to hero
            scrollCount++;
            if (scrollCount >= 2) { // require 2 consecutive up-scrolls to avoid accidental triggers
                goToHero();
                scrollCount = 0;
            }
        } else if (y >= lastY) {
            scrollCount = 0; // reset if scrolling down
        }

        // Edge case: somehow at 0 but state is sections
        if (y === 0 && state === 'sections' && !locked) {
            state = 'hero';
            showHero();
            updateScrollBtn();
        }

        lastY = y;
    }, { passive: true });

    // ========== SEARCH WIDGET TOUCH PROTECTION ==========
    // Prevent touch-scroll when user interacts with the search widget in hero
    var searchWrapper = document.querySelector('.home-search-wrapper');
    if (searchWrapper) {
        searchWrapper.addEventListener('touchmove', function(e) {
            if (state === 'hero') {
                e.preventDefault();
                window.scrollTo(0, 0);
            }
        }, { passive: false });

        searchWrapper.addEventListener('touchstart', function() {
            if (state === 'hero') {
                lock(2000);
                window.scrollTo(0, 0);
            }
        }, { passive: true });
    }

    // ========== SCROLL BUTTON CLICK ==========
    if (scrollBtn) {
        scrollBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (state === 'sections') goToHero();
            else goToSections();
        });
    }

    // ========== HEADER BOOK NOW → search.php ==========
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-main.btn-mobile-reservas, .btn-main.btn-reservas');
        if (btn && btn.closest('header')) {
            e.preventDefault();
            window.location.href = '/search.php';
        }
    });

    // ========== CTA BUTTONS → scroll to hero ==========
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.hp-scroll-to-hero');
        if (btn) {
            e.preventDefault();
            goToHero();
        }
    });

    // ========== VER TODAS REVIEWS → open overlay ==========
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('#hp-see-all-reviews');
        if (btn) {
            e.preventDefault();
            var reviewsBtn = document.getElementById('open-reviews-overlay');
            if (reviewsBtn) reviewsBtn.click();
        }
    });

    // ========== ANIMATED COUNTER ==========
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
