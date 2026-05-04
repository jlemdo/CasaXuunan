/**
 * Direct Booking Banner + Comparison Modal
 * Casa Xu'unan
 *
 * - Sticky top banner with rotating messages (closable via X)
 * - sessionStorage: if user closes, doesn't show again in same session
 * - Inline link "¿Por qué reservar aquí?" → opens modal
 * - Modal with Booking vs Direct comparison table
 * - Dynamic savings calculation: precioDirecto * 1.0387 ≈ precio Booking
 */

(function () {
    'use strict';

    // ===== CONFIG =====
    var LANG = (window.PHP_LANG === 'en') ? 'en' : 'es';
    var ROTATION_MS = 5000;
    var STORAGE_KEY = 'cx_dbb_closed';
    var PROMO_CODE = 'DIRECTO10';
    var DISCOUNT_PCT = 10;

    // ===== TRANSLATIONS =====
    var t = {
        es: {
            msg1: '🎁 Código DIRECTO10 · Ahorra hasta $283 MXN por noche',
            msg2: '🍳 Desayuno casero yucateco INCLUIDO en todas las habitaciones',
            msg3: '✓ Reserva directo · Hasta 13% menos que Booking',
            msg4: '💬 WhatsApp directo · Sin intermediarios',
            inline: '¿Por qué reservar aquí y no en Booking? 👀',
            modalTitle: 'Reserva directo en Casa Xu\'unan',
            modalSubtitle: 'Ahorra hasta 13% vs Booking · Trato directo',
            promoTitle: 'CÓDIGO EXCLUSIVO RESERVA DIRECTA',
            promoCode: 'DIRECTO10',
            promoCopy: 'Copiar',
            promoCopied: '✓ Copiado',
            promoSubtitle: 'Aplica al reservar y obtén 10% de descuento',
            colBenefit: 'Beneficio',
            colDirect: 'Reserva Aquí',
            colOta: 'Booking / OTAs',
            rowPrice: 'Precio',
            rowBreakfast: 'Desayuno casero yucateco',
            rowTaxes: 'Impuestos / fees',
            rowSavings: 'Ahorro total cliente',
            rowWhatsapp: 'WhatsApp directo',
            rowCommissions: 'Comisiones intermediarias',
            valDiscount: '-10% con DIRECTO10',
            valStandard: 'Tarifa estándar',
            valYes: '✓ Incluido',
            valTaxesDirect: '16% IVA estándar',
            valTaxesBooking: '20.5% (incluye fees)',
            valSavings: 'Hasta $283 MXN/noche',
            valWhatsapp: '✓ Antes y después',
            valOtaChat: '✗ Solo chat portal',
            valNoCommission: '✓ 0%',
            valBookingCommission: '15-18%',
            footerNote: '* Código DIRECTO10 aplicable solo en este sitio web · Ahorro calculado vs tarifa pública verificada en Booking · Mismo desayuno casero · Cancelación gratis · Mismas habitaciones',
            ctaBook: 'Reservar ahora',
            ctaWhatsapp: 'Pregunta por WhatsApp',
            whatsappMsg: '¡Hola! Me interesa reservar en Casa Xu\'unan con el código DIRECTO10. ¿Pueden ayudarme?',
            ctaClose: 'Cerrar',
            mxn: 'MXN'
        },
        en: {
            msg1: '🎁 Code DIRECTO10 · Save up to $283 MXN per night',
            msg2: '🍳 Yucatecan homemade breakfast INCLUDED in all rooms',
            msg3: '✓ Book direct · Up to 13% less than Booking',
            msg4: '💬 Direct WhatsApp · No middlemen',
            inline: 'Why book here instead of Booking? 👀',
            modalTitle: 'Book Direct at Casa Xu\'unan',
            modalSubtitle: 'Save up to 13% vs Booking · Direct service',
            promoTitle: 'EXCLUSIVE DIRECT BOOKING CODE',
            promoCode: 'DIRECTO10',
            promoCopy: 'Copy',
            promoCopied: '✓ Copied',
            promoSubtitle: 'Apply at checkout and get 10% off',
            colBenefit: 'Benefit',
            colDirect: 'Book Here',
            colOta: 'Booking / OTAs',
            rowPrice: 'Price',
            rowBreakfast: 'Yucatecan homemade breakfast',
            rowTaxes: 'Taxes / fees',
            rowSavings: 'Total customer savings',
            rowWhatsapp: 'Direct WhatsApp',
            rowCommissions: 'Middleman commissions',
            valDiscount: '-10% with DIRECTO10',
            valStandard: 'Standard rate',
            valYes: '✓ Included',
            valTaxesDirect: '16% standard VAT',
            valTaxesBooking: '20.5% (includes fees)',
            valSavings: 'Up to $283 MXN/night',
            valWhatsapp: '✓ Before & after',
            valOtaChat: '✗ Portal chat only',
            valNoCommission: '✓ 0%',
            valBookingCommission: '15-18%',
            footerNote: '* DIRECTO10 code applicable only on this website · Savings calculated vs Booking public rate · Same homemade breakfast · Free cancellation · Same rooms',
            ctaBook: 'Book now',
            ctaWhatsapp: 'Ask via WhatsApp',
            whatsappMsg: 'Hi! I\'d like to book Casa Xu\'unan with code DIRECTO10. Can you help?',
            ctaClose: 'Close',
            mxn: 'MXN'
        }
    };
    var S = t[LANG];

    // ===== BANNER (integrated into header) =====
    function createBanner() {
        if (sessionStorage.getItem(STORAGE_KEY) === '1') return;

        var header = document.querySelector('header');
        if (!header) return;

        var banner = document.createElement('div');
        banner.className = 'dbb-sticky';
        banner.id = 'dbb-sticky';
        banner.setAttribute('role', 'banner');
        banner.setAttribute('aria-label', 'Direct booking benefits');

        banner.innerHTML =
            '<div class="dbb-sticky-inner">' +
                '<div class="dbb-msg-wrap">' +
                    '<span class="dbb-msg dbb-active">' + S.msg1 + '</span>' +
                    '<span class="dbb-msg">' + S.msg2 + '</span>' +
                    '<span class="dbb-msg">' + S.msg3 + '</span>' +
                    '<span class="dbb-msg">' + S.msg4 + '</span>' +
                    '<a class="dbb-link" data-dbb-open="1">' + S.inline + '</a>' +
                '</div>' +
                '<button class="dbb-close" type="button" aria-label="Close banner">&times;</button>' +
            '</div>';

        // Insertado como primer hijo del header (dentro de el)
        header.insertBefore(banner, header.firstChild);

        // Animate in
        requestAnimationFrame(function () {
            banner.classList.add('dbb-visible');
            // Marcar body para que el CSS del hero ajuste altura (fallback :has)
            document.body.classList.add('cx-banner-active');
        });

        // Rotate messages
        var msgs = banner.querySelectorAll('.dbb-msg');
        var idx = 0;
        setInterval(function () {
            msgs[idx].classList.remove('dbb-active');
            idx = (idx + 1) % msgs.length;
            msgs[idx].classList.add('dbb-active');
        }, ROTATION_MS);

        // Close handler
        banner.querySelector('.dbb-close').addEventListener('click', function () {
            banner.classList.remove('dbb-visible');
            document.body.classList.remove('cx-banner-active');
            sessionStorage.setItem(STORAGE_KEY, '1');
            setTimeout(function () {
                if (banner.parentNode) banner.parentNode.removeChild(banner);
            }, 400);
        });

        // Open modal from banner link
        banner.querySelector('[data-dbb-open]').addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
    }

    // ===== INLINE LINKS (auto-inject on known pages) =====
    function injectInlineLinks() {
        var page = (location.pathname.split('/').pop() || 'index.php').toLowerCase();
        var targets = [];

        // Home: after hero search form
        if (page === 'index.php' || page === '' || page === '/') {
            var home = document.querySelector('.search-widget-container, #section-hero, .hero-section');
            if (home) targets.push({ el: home, pos: 'after' });
        }
        // Search page: above room results
        if (page === 'search.php') {
            var s = document.querySelector('#section-main .container');
            if (s) targets.push({ el: s, pos: 'prepend' });
        }
        // Room page: near price
        // Comentado: el link inline se muestra via banner superior, no hace
        // falta replicarlo aqui dentro de la columna de booking.
        // if (page === 'room.php') {
        //     var r = document.querySelector('.booking-column');
        //     if (r) targets.push({ el: r, pos: 'prepend' });
        // }

        targets.forEach(function (t) {
            if (t.el.querySelector('.dbb-inline-link')) return; // avoid dupes
            var wrap = document.createElement('div');
            wrap.className = 'dbb-inline-link-wrap';
            wrap.innerHTML = '<a class="dbb-inline-link" data-dbb-open="1">' + S.inline + '</a>';
            if (t.pos === 'prepend') t.el.insertBefore(wrap, t.el.firstChild);
            else t.el.parentNode.insertBefore(wrap, t.el.nextSibling);
        });
    }

    // ===== PRICE DETECTION =====
    function detectDirectPrice() {
        // room.php: #room-price-amount has "$1,210"
        var priceEl = document.getElementById('room-price-amount');
        if (priceEl && priceEl.textContent) {
            var num = parseFloat(priceEl.textContent.replace(/[^0-9.]/g, ''));
            if (!isNaN(num) && num > 0) return num;
        }
        // search.php / rooms.php: any .d-price-amount
        var alt = document.querySelector('.d-price-amount');
        if (alt && alt.textContent) {
            var n = parseFloat(alt.textContent.replace(/[^0-9.]/g, ''));
            if (!isNaN(n) && n > 0) return n;
        }
        return null;
    }

    function formatMoney(n) {
        var locale = (LANG === 'es') ? 'es-MX' : 'en-US';
        return '$' + Math.round(n).toLocaleString(locale);
    }

    // ===== MODAL =====
    function buildModalHtml() {
        // Link WhatsApp con mensaje + evento Google Ads
        var waHref = 'https://api.whatsapp.com/send?phone=5219852580599&text=' + encodeURIComponent(S.whatsappMsg);
        var waOnclick = "if(typeof gtag==='function'){gtag('event','conversion',{'send_to':'AW-18041631980/6AUyCN_D3pMcEOzp9ZpD','value':1400,'currency':'MXN'});}";

        // Bloque del codigo promocional copiable
        var promoBlock = '' +
            '<div class="dbb-promo-block">' +
                '<div class="dbb-promo-icon">🎁</div>' +
                '<div class="dbb-promo-title">' + S.promoTitle + '</div>' +
                '<div class="dbb-promo-code-wrap">' +
                    '<span class="dbb-promo-code" id="dbb-promo-code">' + S.promoCode + '</span>' +
                    '<button class="dbb-promo-copy-btn" type="button" id="dbb-promo-copy" aria-label="' + S.promoCopy + '">' +
                        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                            '<rect x="9" y="9" width="13" height="13" rx="2"/>' +
                            '<path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>' +
                        '</svg>' +
                        '<span class="dbb-promo-copy-text">' + S.promoCopy + '</span>' +
                    '</button>' +
                '</div>' +
                '<div class="dbb-promo-subtitle">' + S.promoSubtitle + '</div>' +
            '</div>';

        return '' +
            '<div class="dbb-modal" role="dialog" aria-modal="true" aria-labelledby="dbb-modal-title">' +
                '<button class="dbb-modal-close" type="button" aria-label="' + S.ctaClose + '">&times;</button>' +
                '<div class="dbb-modal-header">' +
                    '<h3 class="dbb-modal-title" id="dbb-modal-title">' + S.modalTitle + '</h3>' +
                    '<p class="dbb-modal-subtitle">' + S.modalSubtitle + '</p>' +
                '</div>' +
                '<div class="dbb-modal-body">' +
                    promoBlock +
                    '<div class="dbb-compare">' +
                        '<div class="dbb-compare-row dbb-compare-header">' +
                            '<span class="dbb-compare-cell">' + S.colBenefit + '</span>' +
                            '<span class="dbb-compare-cell">' + S.colDirect + '</span>' +
                            '<span class="dbb-compare-cell">' + S.colOta + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row dbb-compare-price">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowPrice + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valDiscount + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valStandard + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowBreakfast + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valYes + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valYes + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowTaxes + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valTaxesDirect + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valTaxesBooking + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row dbb-compare-savings">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowSavings + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valSavings + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">—</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowWhatsapp + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valWhatsapp + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valOtaChat + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowCommissions + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valNoCommission + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valBookingCommission + '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="dbb-modal-footer">' +
                    '<div class="dbb-modal-ctas">' +
                        '<a href="search.php?promo=' + PROMO_CODE + '" class="dbb-modal-cta dbb-cta-primary">📅 ' + S.ctaBook + '</a>' +
                        '<a href="' + waHref + '" target="_blank" rel="noopener noreferrer" class="dbb-modal-cta dbb-cta-whatsapp" onclick="' + waOnclick + '"><i class="fa fa-whatsapp"></i> ' + S.ctaWhatsapp + '</a>' +
                    '</div>' +
                    '<p class="dbb-modal-footer-note">' + S.footerNote + '</p>' +
                '</div>' +
            '</div>';
    }

    // Copy button handler
    function attachPromoCopyHandler() {
        var btn = document.getElementById('dbb-promo-copy');
        var codeEl = document.getElementById('dbb-promo-code');
        if (!btn || !codeEl) return;
        var textSpan = btn.querySelector('.dbb-promo-copy-text');
        var originalText = textSpan ? textSpan.textContent : '';
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var code = codeEl.textContent.trim();
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(code).then(function () {
                    showCopiedFeedback(btn, textSpan, originalText);
                }).catch(function () {
                    fallbackCopy(code);
                    showCopiedFeedback(btn, textSpan, originalText);
                });
            } else {
                fallbackCopy(code);
                showCopiedFeedback(btn, textSpan, originalText);
            }
        });
    }
    function fallbackCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(ta);
    }
    function showCopiedFeedback(btn, textSpan, originalText) {
        if (!textSpan) return;
        btn.classList.add('dbb-promo-copied');
        textSpan.textContent = S.promoCopied;
        setTimeout(function () {
            btn.classList.remove('dbb-promo-copied');
            textSpan.textContent = originalText;
        }, 2000);
    }

    function openModal() {
        var overlay = document.getElementById('dbb-modal-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'dbb-modal-overlay';
            overlay.className = 'dbb-modal-overlay';
            document.body.appendChild(overlay);

            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal();
            });
        }
        overlay.innerHTML = buildModalHtml();
        overlay.classList.add('dbb-modal-open');
        document.body.style.overflow = 'hidden';

        overlay.querySelector('.dbb-modal-close').addEventListener('click', closeModal);

        // Copy promo code handler
        attachPromoCopyHandler();

        // ESC to close
        document.addEventListener('keydown', escClose);
    }
    function closeModal() {
        var overlay = document.getElementById('dbb-modal-overlay');
        if (overlay) overlay.classList.remove('dbb-modal-open');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', escClose);
    }
    function escClose(e) {
        if (e.key === 'Escape') closeModal();
    }

    // Global event delegation for any [data-dbb-open] link
    document.addEventListener('click', function (e) {
        var t = e.target.closest('[data-dbb-open]');
        if (t) {
            e.preventDefault();
            openModal();
        }
    });

    // ===== INIT =====
    function init() {
        createBanner();
        injectInlineLinks();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
