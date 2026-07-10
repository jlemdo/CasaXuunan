<!-- ============================================================
     AUTO-CORRECCION DE FECHAS (cero mantenimiento)
     ============================================================
     Los anuncios de Google Ads llevan a search.php con fechas fijas
     (ej: checkin=2026-07-25). Problema: cuando esa fecha pasa, el link
     queda "muerto" y el buscador muestra fechas invalidas.

     Solucion: este script corre ANTES de que el widget Hospitable lea
     la URL. Verifica si checkin ya paso (o no existe) y, de ser asi,
     reemplaza las fechas por hoy+2 noches, 2 adultos por defecto.

     Resultado: el link del anuncio NUNCA queda muerto. Funciona igual
     en julio, agosto o diciembre sin tocar nada.

     IMPORTANTE: usa history.replaceState para actualizar la URL sin
     recargar la pagina, asi el widget lee las fechas corregidas.
============================================================ -->
<script>
(function() {
    var params = new URLSearchParams(window.location.search);
    var checkin = params.get('checkin');

    // Fecha de hoy en zona horaria local (medianoche para comparar solo dias)
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    var needsFix = false;

    if (!checkin) {
        // No hay fecha de check-in -> generar por defecto
        needsFix = true;
    } else {
        // Parsear la fecha del check-in (formato YYYY-MM-DD)
        var parts = checkin.split('-');
        if (parts.length === 3) {
            var checkinDate = new Date(
                parseInt(parts[0], 10),
                parseInt(parts[1], 10) - 1,
                parseInt(parts[2], 10)
            );
            checkinDate.setHours(0, 0, 0, 0);
            // Si el check-in es HOY o ya paso -> corregir
            if (checkinDate <= today) {
                needsFix = true;
            }
        } else {
            // Formato invalido -> corregir
            needsFix = true;
        }
    }

    if (needsFix) {
        // Generar fechas nuevas: check-in en 2 dias, check-out en 4 dias
        // (2 dias adelante da margen para reserva; 2 noches de estancia)
        var newCheckin = new Date(today);
        newCheckin.setDate(today.getDate() + 2);
        var newCheckout = new Date(today);
        newCheckout.setDate(today.getDate() + 4);

        function fmt(d) {
            var y = d.getFullYear();
            var m = String(d.getMonth() + 1).padStart(2, '0');
            var day = String(d.getDate()).padStart(2, '0');
            return y + '-' + m + '-' + day;
        }

        // Preservar adults/children si vienen, sino defaults
        var adults = params.get('adults') || '2';

        params.set('checkin', fmt(newCheckin));
        params.set('checkout', fmt(newCheckout));
        params.set('adults', adults);

        // Actualizar la URL SIN recargar (el widget leera estas fechas)
        var newUrl = window.location.pathname + '?' + params.toString() +
                     window.location.hash;
        window.history.replaceState(null, '', newUrl);
    }
})();
</script>

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
                            <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(tx([
                               'es' => '¡Hola! Necesito ayuda para encontrar la habitación ideal en Casa Xu\'unan',
                               'en' => 'Hi! I need help finding the perfect room at Casa Xu\'unan',
                               'fr' => 'Bonjour ! J\'ai besoin d\'aide pour trouver la chambre idéale à Casa Xu\'unan',
                           ])); ?>"
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

<!-- Auto-scroll conditional:
     - Link limpio (sin fechas): baja a beneficios directos
     - Link con fechas (checkin/checkout) o hash forzado: baja a trust bar (como siempre)
-->
<script>
window.addEventListener('load', function() {
    var scrollContainer = document.querySelector('#content-absolute');
    if (!scrollContainer) return;

    var params = new URLSearchParams(window.location.search);
    var hasSearchParams = params.has('checkin') || params.has('checkout') || params.has('adults');
    var hash = window.location.hash;

    setTimeout(function() {
        var target = null;

        if (!hasSearchParams) {
            // Link limpio → el elemento "Reserva segura y directa" queda debajo del header
            target = document.querySelector('.de-content-overlay.search-results-overlay');
        } else {
            // Link con fechas → el widget de busqueda queda debajo del header
            target = document.querySelector('.search-widget-fullwidth');
        }

        if (target) {
            // Restar la altura del header para que el target quede JUSTO debajo
            var headerEl = document.querySelector('header');
            var headerH  = headerEl ? headerEl.offsetHeight : 0;
            var top = target.offsetTop - headerH - 10;
            if (top < 0) top = 0;
            scrollContainer.scrollTo({ top: top, behavior: 'smooth' });
        }
    }, 400);
});
</script>

<!-- Fix widget search bar layout to match site container -->
<script>
(function() {
    var el = document.querySelector('.search-widget-fullwidth hospitable-direct-mps');
    if (!el) return;

    // Texto segun idioma actual
    var lang = (window.PHP_LANG || document.documentElement.lang || 'es').toLowerCase();
    var priceHelperText = (lang === 'en') ? 'total + tax' : 'total + imp.';

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
            '.search-bar{border:none!important;background:transparent!important;box-shadow:none!important}',
            '.price-helper{font-size:0!important}.price-helper::after{content:"' + priceHelperText + '";font-size:12px!important;color:#888!important}'
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

<!-- ============================================================
     TRACKING DE CONVERSIONES — Configuracion limpia
     ============================================================
     Hospitable Direct envia eventos automaticamente a nuestro GA4
     (configurado con G-YT5HKBEXMW en panel Marketing de Hospitable).

     Eventos automaticos enviados por Hospitable desde booking.hospitable.com:
       - view_item        (al ver detalle de habitacion)
       - begin_checkout   (al iniciar formulario de reserva)
       - add_payment_info (al ingresar datos de tarjeta)
       - purchase         (cuando el pago se completa) <- conversion REAL

     La conversion "Reserva Confirmada" en Google Ads se alimenta de:
       1. Evento purchase de GA4 (cross-domain con booking.hospitable.com)
       2. Webhook server-side (webhook_receiver.php) con Enhanced Conversions

     IMPORTANTE: NO disparamos eventos de conversion desde aqui porque:
       - Click en "Buscar" o en una propiedad NO es una reserva pagada
       - Disparar aqui generaba FALSOS POSITIVOS (reportaba reservas que no existian)
       - Contaminaba el aprendizaje de Smart Bidding y costo-por-conversion real

     Si en el futuro queremos medir "intencion de reserva" (no conversion),
     usar un evento de GA4 personalizado distinto a "conversion" de Google Ads.
============================================================ -->

