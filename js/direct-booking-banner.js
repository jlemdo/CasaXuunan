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
    var BOOKING_MULTIPLIER = 1.0387; // Booking adds ~3.87% more fees vs direct
    var ROTATION_MS = 5000;
    var STORAGE_KEY = 'cx_dbb_closed';

    // ===== TRANSLATIONS =====
    var t = {
        es: {
            msg1: '🏆 Mejor precio garantizado · Cancelación gratis',
            msg2: '🥤 Jugo natural de bienvenida incluido',
            msg3: '✓ Reserva directo y evita comisiones extra',
            inline: '¿Por qué reservar aquí y no en Booking? 👀',
            modalTitle: 'Casa Xu\'unan Directo vs Otros Portales',
            modalSubtitle: 'Compara y reserva con tranquilidad',
            colBenefit: 'Beneficio',
            colDirect: 'Reserva Aquí',
            colOta: 'Booking / OTAs',
            rowPrice: 'Precio total',
            rowCancel: 'Cancelación',
            rowBreakfast: 'Desayuno casero',
            rowWelcome: 'Jugo de bienvenida',
            rowSupport: 'Atención directa',
            rowCommission: 'Comisión intermediarios',
            valCancelDirect: '✓ Gratuita',
            valCancelOta: '✗ No reembolsable',
            valYes: '✓ Incluido',
            valNo: '✗ No disponible',
            valDirect: '✓ Sí, con Doña Susi',
            valOta: 'Solo vía portal',
            valNoCommission: '✓ 0%',
            valOtaCommission: '15-18% extra',
            footerNote: 'Precio estimado en Booking calculado con promedio de tarifas + comisión.',
            ctaExplore: 'Ver habitaciones',
            ctaClose: 'Cerrar',
            savesPrefix: 'Ahorras',
            mxn: 'MXN'
        },
        en: {
            msg1: '🏆 Best price guaranteed · Free cancellation',
            msg2: '🥤 Fresh welcome juice included',
            msg3: '✓ Book direct and skip extra fees',
            inline: 'Why book here instead of Booking? 👀',
            modalTitle: 'Casa Xu\'unan Direct vs Other Portals',
            modalSubtitle: 'Compare and book with peace of mind',
            colBenefit: 'Benefit',
            colDirect: 'Book Here',
            colOta: 'Booking / OTAs',
            rowPrice: 'Total price',
            rowCancel: 'Cancellation',
            rowBreakfast: 'Homemade breakfast',
            rowWelcome: 'Welcome juice',
            rowSupport: 'Direct support',
            rowCommission: 'Middleman fees',
            valCancelDirect: '✓ Free',
            valCancelOta: '✗ Non-refundable',
            valYes: '✓ Included',
            valNo: '✗ Not available',
            valDirect: '✓ Yes, with Doña Susi',
            valOta: 'Only via portal',
            valNoCommission: '✓ 0%',
            valOtaCommission: '15-18% extra',
            footerNote: 'Booking estimated price calculated from average rates + commission.',
            ctaExplore: 'View rooms',
            ctaClose: 'Close',
            savesPrefix: 'Saves',
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
                    '<a class="dbb-link" data-dbb-open="1">' + S.inline + '</a>' +
                '</div>' +
                '<button class="dbb-close" type="button" aria-label="Close banner">&times;</button>' +
            '</div>';

        // Insertado como primer hijo del header (dentro de el)
        header.insertBefore(banner, header.firstChild);

        // Animate in
        requestAnimationFrame(function () {
            banner.classList.add('dbb-visible');
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
        if (page === 'room.php') {
            var r = document.querySelector('.booking-column');
            if (r) targets.push({ el: r, pos: 'prepend' });
        }

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
        var priceDirect = detectDirectPrice();
        var priceRow;
        if (priceDirect) {
            var priceOta = priceDirect * BOOKING_MULTIPLIER;
            var savings = priceOta - priceDirect;
            priceRow =
                '<div class="dbb-compare-row dbb-compare-price">' +
                    '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowPrice + '</span>' +
                    '<span class="dbb-compare-cell dbb-compare-cell-direct">' + formatMoney(priceDirect) + ' ' + S.mxn + '</span>' +
                    '<span class="dbb-compare-cell dbb-compare-cell-ota">~' + formatMoney(priceOta) + ' ' + S.mxn + '</span>' +
                '</div>';
        } else {
            priceRow =
                '<div class="dbb-compare-row dbb-compare-price">' +
                    '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowPrice + '</span>' +
                    '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valNoCommission + '</span>' +
                    '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valOtaCommission + '</span>' +
                '</div>';
        }

        return '' +
            '<div class="dbb-modal" role="dialog" aria-modal="true" aria-labelledby="dbb-modal-title">' +
                '<button class="dbb-modal-close" type="button" aria-label="' + S.ctaClose + '">&times;</button>' +
                '<div class="dbb-modal-header">' +
                    '<h3 class="dbb-modal-title" id="dbb-modal-title">' + S.modalTitle + '</h3>' +
                    '<p class="dbb-modal-subtitle">' + S.modalSubtitle + '</p>' +
                '</div>' +
                '<div class="dbb-modal-body">' +
                    '<div class="dbb-compare">' +
                        '<div class="dbb-compare-row dbb-compare-header">' +
                            '<span class="dbb-compare-cell">' + S.colBenefit + '</span>' +
                            '<span class="dbb-compare-cell">' + S.colDirect + '</span>' +
                            '<span class="dbb-compare-cell">' + S.colOta + '</span>' +
                        '</div>' +
                        priceRow +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowCancel + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valCancelDirect + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valCancelOta + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowBreakfast + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valYes + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valYes + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowWelcome + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valYes + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valNo + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowSupport + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valDirect + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valOta + '</span>' +
                        '</div>' +
                        '<div class="dbb-compare-row">' +
                            '<span class="dbb-compare-cell dbb-compare-cell-label">' + S.rowCommission + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-direct">' + S.valNoCommission + '</span>' +
                            '<span class="dbb-compare-cell dbb-compare-cell-ota">' + S.valOtaCommission + '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="dbb-modal-footer">' +
                    '<a href="rooms.php" class="dbb-modal-cta">' + S.ctaExplore + '</a>' +
                    '<p class="dbb-modal-footer-note">' + S.footerNote + '</p>' +
                '</div>' +
            '</div>';
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
