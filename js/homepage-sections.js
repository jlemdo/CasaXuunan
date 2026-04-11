/**
 * Homepage Conversion Sections - Casa Xu'unan
 * Scroll effects, animated counters, and interactions
 */
(function() {
    'use strict';

    // --- Fade & snap: when user scrolls down from hero, smooth-snap to first section ---
    var heroElements = [
        '.float-text',
        '#slidecaption',
        '.reviews-scroll-btn-wrapper',
        '.home-search-section',
        '#controls-wrapper',
        '#progress-back',
        '#prevslide',
        '#nextslide',
        '.hp-scroll-indicator',
        'header'
    ];

    var heroFaded = false;
    var isSnapping = false;
    var snapTimeout = null;
    var ctaScrolling = false; // flag: user clicked a CTA to go back to hero

    function fadeHero(out) {
        heroElements.forEach(function(sel) {
            var el = document.querySelector(sel);
            if (el) {
                if (out) {
                    el.style.transition = 'opacity 0.5s ease';
                    el.style.opacity = '0';
                    setTimeout(function() {
                        if (heroFaded) {
                            el.style.display = 'none';
                        }
                    }, 500);
                } else {
                    el.style.display = '';
                    // Small delay so display takes effect before fade in
                    setTimeout(function() {
                        el.style.transition = 'opacity 0.5s ease';
                        el.style.opacity = '';
                    }, 20);
                }
            }
        });
    }

    function snapToHero() {
        if (isSnapping) return;
        isSnapping = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        fadeHero(false);
        heroFaded = false;
        clearTimeout(snapTimeout);
        snapTimeout = setTimeout(function() { isSnapping = false; }, 1200);
    }

    function snapToSections() {
        if (isSnapping) return;
        isSnapping = true;
        var target = document.getElementById('hp-lujo');
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
        clearTimeout(snapTimeout);
        snapTimeout = setTimeout(function() { isSnapping = false; }, 1200);
    }

    // CTA scroll: go to hero and show everything (no re-snap down)
    function ctaGoToHero() {
        ctaScrolling = true;
        heroFaded = false;
        isSnapping = true;
        fadeHero(false);
        window.scrollTo({ top: 0, behavior: 'smooth' });
        clearTimeout(snapTimeout);
        snapTimeout = setTimeout(function() {
            isSnapping = false;
            ctaScrolling = false;
        }, 1500);
    }

    function handleHeroScroll() {
        // Don't interfere when CTA is scrolling user back to hero
        if (ctaScrolling) return;

        var scrollY = window.pageYOffset || document.documentElement.scrollTop;
        var vh = window.innerHeight;
        var downThreshold = vh * 0.08;
        var upSnapZone = vh * 0.5;

        // Scrolling DOWN past hero threshold
        if (scrollY > downThreshold && !heroFaded) {
            heroFaded = true;
            fadeHero(true);
            snapToSections();
        }
        // Scrolling UP into snap zone — snap back to hero top
        else if (scrollY > 0 && scrollY < upSnapZone && heroFaded && !isSnapping) {
            snapToHero();
        }
        // Already at top
        else if (scrollY <= 0 && heroFaded) {
            heroFaded = false;
            fadeHero(false);
        }
    }

    window.addEventListener('scroll', handleHeroScroll, { passive: true });

    // --- Smooth scroll for scroll indicator ---
    document.addEventListener('click', function(e) {
        var indicator = e.target.closest('.hp-scroll-indicator');
        if (indicator) {
            e.preventDefault();
            snapToSections();
            fadeHero(true);
            heroFaded = true;
        }
    });

    // --- ALL CTA buttons inside homepage sections scroll to hero search bar ---
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.hp-cta-btn, .hp-cta-glow, .hp-cta-btn-outline');
        // Skip the "Ver Todas las Reseñas" button (has its own handler)
        if (btn && btn.id === 'hp-see-all-reviews') return;
        // Only intercept buttons inside the homepage sections
        if (btn && btn.closest('.hp-sections-wrapper')) {
            e.preventDefault();
            ctaGoToHero();
        }
    });

    // --- Animated counter on scroll into view ---
    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target)) return;

        var duration = 2000;
        var startTime = null;
        var startVal = 0;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = Math.floor(startVal + (target - startVal) * eased);
            el.textContent = current + '+';
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target + '+';
            }
        }

        requestAnimationFrame(step);
    }

    var counterEl = document.querySelector('.hp-counter-number[data-count]');
    if (counterEl && 'IntersectionObserver' in window) {
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counterObserver.observe(counterEl);
    }

    // --- "Ver Todas" button triggers existing reviews overlay ---
    document.addEventListener('click', function(e) {
        var seeAllBtn = e.target.closest('#hp-see-all-reviews');
        if (seeAllBtn) {
            e.preventDefault();
            var reviewsBtn = document.getElementById('open-reviews-overlay');
            if (reviewsBtn) {
                reviewsBtn.click();
            }
        }
    });

})();
