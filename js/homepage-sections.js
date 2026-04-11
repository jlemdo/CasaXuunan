/**
 * Homepage Conversion Sections - Casa Xu'unan
 * Professional scroll snap, hero fade, counter, CTA routing
 */
(function() {
    'use strict';

    // ---- STATE ----
    var inSections = false;
    var isAnimating = false;
    var LOCK_MS = 900;

    // ---- ELEMENTS ----
    var heroEls = [
        '.float-text', '#slidecaption', '.reviews-scroll-btn-wrapper',
        '.home-search-section', '#controls-wrapper', '#progress-back',
        '#prevslide', '#nextslide', 'header'
    ];

    // Cache DOM references once
    var heroDomEls = [];
    function cacheHeroEls() {
        if (heroDomEls.length > 0) return;
        heroEls.forEach(function(sel) {
            var el = document.querySelector(sel);
            if (el) heroDomEls.push(el);
        });
    }

    var scrollBtn = null;

    function dbgHero() {}

    // ---- HERO SHOW/HIDE ----
    function setHeroVisible(show) {
        cacheHeroEls();
        heroDomEls.forEach(function(el) {
            if (show) {
                el.style.display = '';
                el.style.visibility = 'visible';
                el.style.opacity = '1';
                el.style.pointerEvents = '';
                el.style.transition = '';
            } else {
                el.style.transition = 'opacity 0.3s ease';
                el.style.opacity = '0';
                el.style.pointerEvents = 'none';
            }
        });

        if (!show) {
            setTimeout(function() {
                if (inSections) {
                    heroDomEls.forEach(function(el) {
                        el.style.display = 'none';
                        el.style.visibility = 'hidden';
                    });
                }
            }, 350);
        }

        dbgHero(show ? 'SHOW' : 'HIDE');
    }

    // ---- SCROLL BUTTON ----
    function updateScrollBtn() {
        if (!scrollBtn) return;
        var icon = scrollBtn.querySelector('i');
        if (!icon) return;
        if (inSections) {
            icon.className = 'fa fa-angle-up';
            scrollBtn.classList.remove('hp-scroll-btn-bounce');
        } else {
            icon.className = 'fa fa-angle-down';
            scrollBtn.classList.add('hp-scroll-btn-bounce');
        }
    }

    // ---- NAVIGATE ----
    function goToSections() {
        if (isAnimating || inSections) return;
        isAnimating = true;
        inSections = true;
        setHeroVisible(false);
        updateScrollBtn();
        var target = document.getElementById('hp-lujo');
        if (target) target.scrollIntoView({ behavior: 'smooth' });
        setTimeout(function() { isAnimating = false; }, LOCK_MS);
    }

    function goToHero() {
        if (isAnimating || !inSections) return;
        isAnimating = true;
        inSections = false;
        setHeroVisible(true);
        updateScrollBtn();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        setTimeout(function() {
            isAnimating = false;
            dbgHero('HERO-READY');
        }, LOCK_MS);
    }

    // ---- SEARCH WIDGET INTERACTION LOCK ----
    var searchLocked = false;
    var searchLockTimer = null;

    function lockForSearch() {
        searchLocked = true;
        clearTimeout(searchLockTimer);
        if (!inSections) {
            window.scrollTo(0, 0);
        }
        searchLockTimer = setTimeout(function() { searchLocked = false; }, 2000);
    }

    var searchSection = document.querySelector('.home-search-section');
    var searchWrapper = document.querySelector('.home-search-wrapper');
    if (searchSection) {
        searchSection.addEventListener('click', function() {
            lockForSearch();
            if (!inSections) {
                requestAnimationFrame(function() { window.scrollTo(0, 0); });
            }
        }, true);
        searchSection.addEventListener('touchstart', lockForSearch, true);
    }
    // Block touch-scroll on search wrapper when in hero (prevents page scroll)
    if (searchWrapper) {
        searchWrapper.addEventListener('touchmove', function(e) {
            if (!inSections) {
                e.preventDefault();
                window.scrollTo(0, 0);
            }
        }, { passive: false });
    }

    function isSearchExpanded() {
        var s = document.querySelector('.home-search-section');
        if (!s) return false;
        var t = s.style.transform;
        return t && t.indexOf('translateY') > -1 && t !== 'translateY(0px)' && t !== 'translateY(0)';
    }

    // ---- SCROLL DETECTION ----
    var lastScrollY = 0;
    var scrollTick = false;

    function onScroll() {
        if (scrollTick) return;
        scrollTick = true;
        requestAnimationFrame(function() {
            scrollTick = false;
            if (isAnimating || searchLocked || isSearchExpanded()) return;

            var scrollY = window.pageYOffset || document.documentElement.scrollTop;
            var vh = window.innerHeight;

            if (!inSections && scrollY > vh * 0.08) {
                goToSections();
            }
            else if (inSections && scrollY < vh * 0.5 && scrollY < lastScrollY) {
                goToHero();
            }
            else if (inSections && scrollY === 0) {
                inSections = false;
                setHeroVisible(true);
                updateScrollBtn();
            }

            lastScrollY = scrollY;
        });
    }

    window.addEventListener('scroll', onScroll, { passive: true });

    // ---- SCROLL BUTTON CLICK ----
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('#hp-scroll-btn');
        if (!btn) return;
        e.preventDefault();
        if (inSections) {
            goToHero();
        } else {
            goToSections();
        }
    });

    // ---- HEADER "BOOK NOW" BUTTON → search.php ----
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.btn-main.btn-mobile-reservas, .btn-main.btn-reservas');
        if (btn && btn.closest('header')) {
            e.preventDefault();
            window.location.href = '/search.php';
        }
    });

    // ---- CTA BUTTONS inside sections → scroll to hero search bar ----
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.hp-scroll-to-hero');
        if (btn) {
            e.preventDefault();
            goToHero();
        }
    });

    // ---- "Ver Todas" button triggers existing reviews overlay ----
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('#hp-see-all-reviews');
        if (btn) {
            e.preventDefault();
            var reviewsBtn = document.getElementById('open-reviews-overlay');
            if (reviewsBtn) reviewsBtn.click();
        }
    });

    // ---- ANIMATED COUNTER ----
    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target)) return;
        var duration = 2000;
        var startTime = null;
        function step(ts) {
            if (!startTime) startTime = ts;
            var p = Math.min((ts - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.floor(target * eased) + '+';
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target + '+';
        }
        requestAnimationFrame(step);
    }

    var counterEl = document.querySelector('.hp-counter-number[data-count]');
    if (counterEl && 'IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        obs.observe(counterEl);
    }

    // ---- SLIDE HOOK SYNC ----
    var hookContainer = document.getElementById('hp-slide-hook-fixed');
    if (hookContainer) {
        var lang = window.PHP_LANG || 'es';
        var allHooks = hookContainer.querySelectorAll('span');
        var lastSlide = -1;
        function updateHook() {
            var slides = document.querySelectorAll('#supersized li');
            var activeIdx = 0;
            for (var i = 0; i < slides.length; i++) {
                if (slides[i].classList.contains('activeslide')) { activeIdx = i; break; }
            }
            if (activeIdx === lastSlide) return;
            lastSlide = activeIdx;
            allHooks.forEach(function(s) { s.classList.remove('active'); });
            var target = hookContainer.querySelector('span[data-lang="'+lang+'"][data-slide="'+activeIdx+'"]');
            if (target) target.classList.add('active');
        }
        setInterval(updateHook, 500);
        updateHook();
        heroEls.push('#hp-slide-hook-fixed');
    }

    // ---- INIT ----
    scrollBtn = document.getElementById('hp-scroll-btn');
    updateScrollBtn();

})();
