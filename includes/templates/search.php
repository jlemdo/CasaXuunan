<div id="background" data-bgimage="url(images/background/20.jpg) 100% 100% fixed"></div>
<div id="content-absolute">

    <!-- subheader -->
    <section id="subheader" class="no-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4><?php echo t('search_subtitle'); ?></h4>
                    <h1><?php echo t('search_title'); ?></h1>
                    <p class="search-hero-hook"><?php echo t('search_hook'); ?></p>
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
                            <div class="trust-item">
                                <i class="fa fa-wifi"></i>
                                <span><?php echo t('search_trust_wifi'); ?></span>
                            </div>
                            <div class="trust-item">
                                <i class="fa fa-home"></i>
                                <span><?php echo t('search_trust_rooms'); ?></span>
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

        <!-- Micro-trust bar -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="search-micro-trust">
                        <span><i class="fa fa-check"></i> <?php echo t('search_micro_cancel'); ?></span>
                        <span><i class="fa fa-check"></i> <?php echo t('search_micro_secure'); ?></span>
                        <span><i class="fa fa-check"></i> <?php echo t('search_micro_hidden'); ?></span>
                    </div>
                </div>
            </div>
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

<!-- Auto-scroll to trust bar (just above results) on page load -->
<script>
window.addEventListener('load', function() {
    var trust = document.querySelector('.search-trust-bar');
    var scrollContainer = document.querySelector('#content-absolute');
    if (trust && scrollContainer) {
        setTimeout(function() {
            var trustTop = trust.offsetTop - 10;
            scrollContainer.scrollTo({ top: trustTop, behavior: 'smooth' });
        }, 400);
    }
});
</script>

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
        s.textContent = [
            '.search-bar-container{width:100%!important;position:relative!important;left:0!important;margin-left:0!important;padding:20px!important;margin-bottom:20px!important;display:flex!important;justify-content:center!important;background:rgba(10,10,10,0.50)!important;backdrop-filter:blur(20px)!important;-webkit-backdrop-filter:blur(20px)!important;border:1px solid rgba(255,255,255,0.1)!important;border-radius:16px!important;overflow:visible!important}',
            '.search-bar,.search-bar *:not(input){overflow:visible!important}',
            '.date-picker-container{position:relative!important;z-index:9999!important;overflow:visible!important}',
            '.guests-expanded{position:relative!important;z-index:9999!important;overflow:visible!important}',
            '.properties,.properties-container,.results-container,.left{min-height:auto!important;height:auto!important}',
            '.search-bar *{box-sizing:border-box!important}',
            'input.check-in,input.check-in:focus{background:#fff!important;border:1px solid rgba(255,255,255,0.15)!important;border-radius:12px!important;color:#312b24!important;outline:none!important;box-shadow:none!important}',
            '.guest-picker,.guest-picker *{border-color:rgba(255,255,255,0.15)!important}',
            '.guest-picker-summary{background:#fff!important;border:1px solid rgba(255,255,255,0.15)!important;border-radius:12px!important;color:#312b24!important}',
            'button.search-btn{background:#ea8f71!important;height:auto!important}',
            'button.search-btn:hover{background:#d9775c!important}',
            'svg{fill:#ea8f71!important}',
            '.search-bar{border:none!important;background:transparent!important;box-shadow:none!important}'
        ].join('');
        el.shadowRoot.appendChild(s);
        clearInterval(interval);
    }, 300);
})();
</script>

<!-- Hide unavailable properties with toggle button (desktop + mobile) -->
<script>
(function() {
    var el = document.querySelector('.search-widget-fullwidth hospitable-direct-mps');
    if (!el) return;

    var lang = new URLSearchParams(window.location.search).get('lang') ||
               document.documentElement.lang || 'es';
    var txtShow = lang === 'en' ? 'Show unavailable rooms' : 'Mostrar no disponibles';
    var txtHide = lang === 'en' ? 'Hide unavailable rooms' : 'Ocultar no disponibles';
    var txtNone = lang === 'en' ? 'No rooms available for these dates — try different dates or ' : 'No hay habitaciones para estas fechas — prueba otras fechas o ';
    var txtWa = lang === 'en' ? 'message us' : 'escríbenos';

    var btn = null, btnWrap = null, noResultsMsg = null;
    var showing = false, styleReady = false;

    function ensureStyle(sr) {
        if (styleReady) return;
        if (sr.querySelector('#cx-toggle-style')) { styleReady = true; return; }
        var s = document.createElement('style');
        s.id = 'cx-toggle-style';
        s.textContent = [
            '.property.cx-off{display:none!important}',
            '.property{transition:opacity .3s ease}',
            '.properties,.properties-container,section.results-container,.left{min-height:auto!important;height:auto!important}',
            'h2{display:none!important}'
        ].join('');
        sr.appendChild(s);
        styleReady = true;
    }

    function getCards() {
        var sr = el.shadowRoot;
        if (!sr) return { avail: [], unavail: [], all: [] };
        // Cards can be div.property or a.property
        var all = Array.from(sr.querySelectorAll('.property'));
        var avail = [], unavail = [];
        all.forEach(function(c) {
            if (c.querySelector('.unavailable-fade')) unavail.push(c);
            else avail.push(c);
        });
        return { avail: avail, unavail: unavail, all: all };
    }

    function createBtn() {
        if (btn) return;
        btnWrap = document.createElement('div');
        btnWrap.style.cssText = 'text-align:center;margin:0 auto 20px;max-width:600px;padding:0 16px;';

        btn = document.createElement('button');
        btn.style.cssText = 'display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.2);border-radius:30px;color:rgba(255,255,255,0.7);font-family:Montserrat,sans-serif;font-size:12px;font-weight:500;letter-spacing:.3px;cursor:pointer;transition:all .3s ease;-webkit-tap-highlight-color:transparent';

        btn.addEventListener('click', function() {
            showing = !showing;
            var cards = getCards();
            cards.unavail.forEach(function(c) {
                if (showing) {
                    c.classList.remove('cx-off');
                    c.style.opacity = '0';
                    requestAnimationFrame(function() {
                        requestAnimationFrame(function() { c.style.opacity = '1'; });
                    });
                } else {
                    c.style.opacity = '0';
                    setTimeout(function() { c.classList.add('cx-off'); c.style.opacity = ''; }, 300);
                }
            });
            updateBtn(cards);

            if (showing && cards.unavail.length > 0) {
                setTimeout(function() {
                    cards.unavail[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 350);
            }
        });

        btnWrap.appendChild(btn);
        var wc = document.querySelector('.search-widget-fullwidth');
        wc.parentNode.insertBefore(btnWrap, wc.nextSibling);
    }

    function createNoResults() {
        if (noResultsMsg) return;
        noResultsMsg = document.createElement('div');
        noResultsMsg.style.cssText = 'text-align:center;padding:30px 20px;margin:0 auto 20px;max-width:600px;background:rgba(226,186,212,0.08);border:1px solid rgba(226,186,212,0.15);border-radius:12px;color:rgba(255,255,255,0.7);font-family:Heebo,sans-serif;font-size:14px;line-height:1.6;display:none';
        var wc = document.querySelector('.search-widget-fullwidth');
        wc.parentNode.insertBefore(noResultsMsg, wc.nextSibling);
    }

    function updateBtn(cards) {
        if (!btn) return;
        var n = cards.unavail.length;
        btn.textContent = (showing ? txtHide : txtShow) + ' (' + n + ')';
        btn.style.background = showing ? 'rgba(123,175,137,0.15)' : 'rgba(255,255,255,0.08)';
        btn.style.borderColor = showing ? 'rgba(123,175,137,0.3)' : 'rgba(255,255,255,0.2)';
    }

    function process() {
        var sr = el.shadowRoot;
        if (!sr) return;

        var cards = getCards();
        if (cards.all.length === 0) return;

        ensureStyle(sr);
        createBtn();
        createNoResults();

        showing = false;
        cards.unavail.forEach(function(c) { c.classList.add('cx-off'); });
        cards.avail.forEach(function(c) { c.classList.remove('cx-off'); });

        if (cards.unavail.length > 0) {
            btnWrap.style.display = '';
            updateBtn(cards);
        } else {
            btnWrap.style.display = 'none';
        }

        if (cards.avail.length === 0 && cards.unavail.length > 0) {
            noResultsMsg.innerHTML = txtNone + '<a href="https://api.whatsapp.com/send?phone=5219852580599" target="_blank" style="color:#25D366;text-decoration:underline">' + txtWa + '</a>';
            noResultsMsg.style.display = 'block';
        } else {
            noResultsMsg.style.display = 'none';
        }
    }

    var attempts = 0;
    var poll = setInterval(function() {
        if (!el.shadowRoot) { if (++attempts > 150) clearInterval(poll); return; }
        var props = el.shadowRoot.querySelectorAll('.property');
        if (props.length === 0) { if (++attempts > 150) clearInterval(poll); return; }
        clearInterval(poll);

        process();

        var obs = new MutationObserver(function() {
            clearTimeout(obs._t);
            obs._t = setTimeout(process, 600);
        });
        obs.observe(el.shadowRoot, { childList: true, subtree: true });
    }, 300);
})();
</script>
