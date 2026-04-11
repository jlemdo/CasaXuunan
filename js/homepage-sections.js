/**
 * Homepage Conversion Sections - Casa Xu'unan
 * Professional scroll snap, hero fade, counter, CTA routing
 */
(function() {
    'use strict';

    // ---- STATE ----
    var inSections = false;   // true = user is in sections area
    var isAnimating = false;  // lock during scroll animations
    var LOCK_MS = 900;        // animation lock duration

    // ---- ELEMENTS ----
    var heroEls = [
        '.float-text', '#slidecaption', '.reviews-scroll-btn-wrapper',
        '.home-search-section', '#controls-wrapper', '#progress-back',
        '#prevslide', '#nextslide', 'header'
    ];

    var scrollBtn = null; // the floating scroll button

    // ---- HERO SHOW/HIDE ----
    function setHeroVisible(show) {
        heroEls.forEach(function(sel) {
            var el = document.querySelector(sel);
            if (!el) return;
            if (show) {
                el.style.display = '';
                requestAnimationFrame(function() {
                    el.style.transition = 'opacity 0.5s ease';
                    el.style.opacity = '';
                });
            } else {
                el.style.transition = 'opacity 0.4s ease';
                el.style.opacity = '0';
                setTimeout(function() {
                    if (inSections) el.style.display = 'none';
                }, 450);
            }
        });
    }

    // ---- SCROLL BUTTON (arrow down when in hero, arrow up when in sections) ----
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
        setTimeout(function() { isAnimating = false; }, LOCK_MS);
    }

    // ---- SCROLL DETECTION ----
    var lastScrollY = 0;
    var scrollTick = false;

    // ---- SEARCH WIDGET INTERACTION LOCK ----
    // When user interacts with the home search widget, pause snap for 2s
    // This prevents the snap from firing before the widget's transform applies
    var searchLocked = false;
    var searchLockTimer = null;

    function lockForSearch() {
        searchLocked = true;
        clearTimeout(searchLockTimer);
        // Keep scroll at 0 while interacting with search widget in hero
        if (!inSections) {
            window.scrollTo(0, 0);
        }
        searchLockTimer = setTimeout(function() { searchLocked = false; }, 2000);
    }

    // Detect clicks on the search widget area
    var searchSection = document.querySelector('.home-search-section');
    if (searchSection) {
        searchSection.addEventListener('click', function() {
            lockForSearch();
            // Prevent browser auto-scroll on focus within fixed elements
            if (!inSections) {
                requestAnimationFrame(function() { window.scrollTo(0, 0); });
            }
        }, true);
        searchSection.addEventListener('touchstart', lockForSearch, true);
    }

    function isSearchExpanded() {
        var s = document.querySelector('.home-search-section');
        if (!s) return false;
        var t = s.style.transform;
        return t && t.indexOf('translateY') > -1 && t !== 'translateY(0px)' && t !== 'translateY(0)';
    }

    function onScroll() {
        if (scrollTick) return;
        scrollTick = true;
        requestAnimationFrame(function() {
            scrollTick = false;
            if (isAnimating || searchLocked || isSearchExpanded()) return;

            var scrollY = window.pageYOffset || document.documentElement.scrollTop;
            var vh = window.innerHeight;

            // In hero zone, user scrolls down → snap to sections
            if (!inSections && scrollY > vh * 0.08) {
                goToSections();
            }
            // In sections, user scrolls up near hero → snap back
            else if (inSections && scrollY < vh * 0.5 && scrollY < lastScrollY) {
                goToHero();
            }
            // Edge: somehow at top but state says inSections
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

    // ---- SLIDE HOOK SYNC: show matching hook text for active slide ----
    var hookContainer = document.getElementById('hp-slide-hook-fixed');
    if (hookContainer) {
        var lang = window.PHP_LANG || 'es';
        var allHooks = hookContainer.querySelectorAll('span');
        var lastSlide = -1;

        function updateHook() {
            // Supersized uses .activeslide class on the active li
            var slides = document.querySelectorAll('#supersized li');
            var activeIdx = 0;
            for (var i = 0; i < slides.length; i++) {
                if (slides[i].classList.contains('activeslide')) {
                    activeIdx = i;
                    break;
                }
            }
            if (activeIdx === lastSlide) return;
            lastSlide = activeIdx;

            allHooks.forEach(function(s) { s.classList.remove('active'); });
            var target = hookContainer.querySelector('span[data-lang="'+lang+'"][data-slide="'+activeIdx+'"]');
            if (target) target.classList.add('active');
        }

        // Poll for slide changes (Supersized doesn't emit events)
        setInterval(updateHook, 500);
        updateHook();

        // Add to heroEls so it hides on scroll
        heroEls.push('#hp-slide-hook-fixed');
    }

    // ---- INIT: set scroll button ref ----
    scrollBtn = document.getElementById('hp-scroll-btn');
    updateScrollBtn();

})();
