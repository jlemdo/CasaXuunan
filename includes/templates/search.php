<div id="background" data-bgimage="url(images/background/20.jpg) 100% 100% fixed"></div>
<div id="content-absolute">

    <!-- subheader -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4><?php echo t('search_subtitle'); ?></h4>
                    <h1><?php echo t('search_title'); ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Results -->
    <section id="section-main" class="no-bg no-top" aria-label="search-results">

        <!-- Trust Badge (contained) -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="de-content-overlay search-results-overlay">
                        <div class="search-trust-bar">
                            <div class="trust-item">
                                <i class="fa fa-shield"></i>
                                <span><?php echo t('search_trust_secure'); ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fa fa-cutlery"></i>
                                <span><?php echo t('search_trust_breakfast'); ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fa fa-star"></i>
                                <span><?php echo t('search_trust_rating'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hospitable Search Widget (full-width, no container restriction) -->
        <div class="search-widget-fullwidth">
            <hospitable-direct-mps identifier="acfc5534-2d3d-4f1e-88a0-74360d86804f" type="custom"></hospitable-direct-mps>
        </div>

        <!-- WhatsApp Help CTA (contained) -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="de-content-overlay search-results-overlay" style="margin-top: 0;">
                        <div class="search-help-cta">
                            <div class="search-help-icon">
                                <i class="fa fa-whatsapp"></i>
                            </div>
                            <div class="search-help-text">
                                <strong><?php echo t('search_help_title'); ?></strong>
                                <p><?php echo t('search_help_desc'); ?></p>
                            </div>
                            <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(getCurrentLanguage() === 'es' ? '¡Hola! Necesito ayuda para encontrar la habitación ideal en Casa Xu\'unan' : 'Hi! I need help finding the perfect room at Casa Xu\'unan'); ?>"
                               class="search-help-btn"
                               target="_blank"
                               rel="noopener noreferrer"
                               onclick="if(typeof gtag==='function'){gtag('event','conversion',{'send_to':'AW-18041631980/6AUyCN_D3pMcEOzp9ZpD','value':1400,'currency':'MXN'});}">
                                <?php echo t('search_help_btn'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>

<!-- Fix widget search bar layout to match site container -->
<script>
(function() {
    var el = document.querySelector('.search-widget-fullwidth hospitable-direct-mps');
    if (!el) return;
    var attempts = 0;
    var interval = setInterval(function() {
        if (!el.shadowRoot) { if (++attempts > 100) clearInterval(interval); return; }
        if (el.shadowRoot.querySelector('#cx-searchbar-fix')) { clearInterval(interval); return; }
        var s = document.createElement('style');
        s.id = 'cx-searchbar-fix';
        s.textContent = '.search-bar-container { width: 100%; position: relative; padding: 24px; margin-bottom: 24px; display: flex; justify-content: center; }';
        el.shadowRoot.appendChild(s);
        clearInterval(interval);
    }, 300);
})();
</script>

<!-- Mobile: hide unavailable properties, show toggle button -->
<script>
(function() {
    if (window.innerWidth > 992) return;

    var el = document.querySelector('.search-widget-fullwidth hospitable-direct-mps');
    if (!el) return;

    var lang = new URLSearchParams(window.location.search).get('lang') ||
               document.documentElement.lang || 'es';
    var btnShowText = lang === 'en' ? 'Show unavailable rooms' : 'Mostrar habitaciones no disponibles';
    var btnHideText = lang === 'en' ? 'Hide unavailable rooms' : 'Ocultar habitaciones no disponibles';

    var btn, btnWrapper, showing = false;
    var styleInjected = false;

    function injectStyle(sr) {
        if (styleInjected) return;
        if (sr.querySelector('#cx-unavailable-toggle')) { styleInjected = true; return; }
        var s = document.createElement('style');
        s.id = 'cx-unavailable-toggle';
        s.textContent = [
            'a.property.cx-hidden { display: none !important; }',
            'a.property { transition: opacity 0.3s ease; }',
            '.properties { display: flex; flex-direction: column; }'
        ].join('\n');
        sr.appendChild(s);
        styleInjected = true;
    }

    function hideUnavailable() {
        var sr = el.shadowRoot;
        if (!sr) return;

        var properties = sr.querySelectorAll('a.property');
        if (properties.length === 0) return;

        injectStyle(sr);

        var unavailableCards = [];
        var availableCount = 0;
        properties.forEach(function(card) {
            if (card.querySelector('.unavailable-fade')) {
                unavailableCards.push(card);
                if (!showing) card.classList.add('cx-hidden');
            } else {
                card.classList.remove('cx-hidden');
                availableCount++;
            }
        });

        // Create or update button
        if (unavailableCards.length === 0) {
            if (btnWrapper) btnWrapper.style.display = 'none';
            return;
        }

        if (!btn) {
            btnWrapper = document.createElement('div');
            btnWrapper.style.cssText = 'text-align:center;margin:0 auto 20px;max-width:600px;padding:0 16px;';

            btn = document.createElement('button');
            btn.style.cssText = [
                'display:inline-flex;align-items:center;gap:8px',
                'padding:12px 28px',
                'background:rgba(255,255,255,0.08)',
                'border:1px solid rgba(255,255,255,0.2)',
                'border-radius:30px',
                'color:rgba(255,255,255,0.7)',
                'font-family:Montserrat,sans-serif',
                'font-size:13px',
                'font-weight:500',
                'letter-spacing:0.3px',
                'cursor:pointer',
                'transition:all 0.3s ease',
                '-webkit-tap-highlight-color:transparent'
            ].join(';');

            btn.addEventListener('click', function() {
                showing = !showing;
                var sr = el.shadowRoot;
                var cards = sr.querySelectorAll('a.property');
                cards.forEach(function(card) {
                    if (!card.querySelector('.unavailable-fade')) return;
                    if (showing) {
                        card.classList.remove('cx-hidden');
                        card.style.opacity = '0';
                        requestAnimationFrame(function() {
                            requestAnimationFrame(function() { card.style.opacity = '1'; });
                        });
                    } else {
                        card.style.opacity = '0';
                        setTimeout(function() {
                            card.classList.add('cx-hidden');
                            card.style.opacity = '';
                        }, 300);
                    }
                });
                updateBtnText(cards);
            });

            btnWrapper.appendChild(btn);
            var widgetContainer = document.querySelector('.search-widget-fullwidth');
            widgetContainer.parentNode.insertBefore(btnWrapper, widgetContainer.nextSibling);
        }

        btnWrapper.style.display = '';
        updateBtnText(properties);
    }

    function updateBtnText(properties) {
        if (!btn) return;
        var count = 0;
        properties.forEach(function(c) { if (c.querySelector('.unavailable-fade')) count++; });
        btn.textContent = (showing ? btnHideText : btnShowText) + ' (' + count + ')';
        btn.style.background = showing ? 'rgba(123,175,137,0.15)' : 'rgba(255,255,255,0.08)';
        btn.style.borderColor = showing ? 'rgba(123,175,137,0.3)' : 'rgba(255,255,255,0.2)';
    }

    // Wait for shadow DOM, then observe for changes (new searches)
    var attempts = 0;
    var interval = setInterval(function() {
        if (!el.shadowRoot) { if (++attempts > 100) clearInterval(interval); return; }

        var properties = el.shadowRoot.querySelectorAll('a.property');
        if (properties.length === 0) { if (++attempts > 100) clearInterval(interval); return; }

        clearInterval(interval);

        // Initial hide
        showing = false;
        hideUnavailable();

        // Watch for re-renders (new searches within the page)
        var observer = new MutationObserver(function() {
            // Debounce — wait for widget to finish rendering
            clearTimeout(observer._timer);
            observer._timer = setTimeout(function() {
                showing = false;
                hideUnavailable();
            }, 500);
        });

        observer.observe(el.shadowRoot, {
            childList: true,
            subtree: true
        });
    }, 300);
})();
</script>
