/**
 * Welcome Popup - Casa Xu'unan
 *
 * Pop-up profesional estilo Klaviyo (Shopify) para captura de atencion
 * con el codigo promocional CASA10.
 *
 * Caracteristicas:
 * - Solo aparece en HOME (index.php / index-full-page.php)
 * - Una sola vez por sesion (sessionStorage)
 * - Delay de 3 segundos al cargar (no agresivo)
 * - Cerrable con X, click fuera o tecla Escape
 * - Boton de copiar codigo con feedback visual
 * - Soporta 3 idiomas (ES / EN / FR)
 * - Mobile + desktop responsive
 * - NO pide email (solicitud del cliente)
 * - Bloquea scroll del body cuando esta abierto
 *
 * CTA: lleva a search.php (buscador con widget Hospitable)
 * - Reduce el funnel de 7 pasos a 5 pasos (menos friccion)
 * - Coincide con UX de Booking/Airbnb/Hilton (familiar)
 * - Textos: "Buscar Disponibilidad" / "Check Availability" /
 *           "Vérifier Disponibilité"
 */

(function () {
    'use strict';

    // ===== CONFIG =====
    var STORAGE_KEY = 'cx_welcome_popup_shown';
    var DELAY_MS = 3000; // 3 segundos antes de aparecer
    var IMAGE_URL = 'images/gallery/gallery-item-3.jpg'; // misma que OG image, jardin tropical

    // ===== DETECCION DE IDIOMA =====
    // Soporta 3 idiomas (es / en / fr) - default es
    var LANG = 'es';
    if (window.PHP_LANG === 'en') LANG = 'en';
    else if (window.PHP_LANG === 'fr') LANG = 'fr';

    // ===== TRADUCCIONES =====
    // CTA: "Buscar Disponibilidad" es lo que hacen Booking/Airbnb/Hilton
    // - Implica accion inmediata
    // - Sugiere fechas (urgencia)
    // - Familiar para el usuario hotelero
    // - Lleva al buscador directamente (menos friccion)
    var t = {
        es: {
            badge: '🎁 Bienvenida exclusiva',
            title: 'Ahorra <strong>10%</strong> reservando aquí',
            subtitle: 'Por ser la primera vez que nos visitas, te regalamos un descuento exclusivo. Reservación directa, sin intermediarios.',
            codeLabel: 'Tu código promocional',
            copyBtn: 'Copiar',
            copiedBtn: '✓ Copiado',
            cta: 'Buscar Disponibilidad',
            trust: '✓ Sin compromiso · ✓ Cancelación gratis · ✓ <span>Mejor precio garantizado</span>',
            close: 'Cerrar'
        },
        en: {
            badge: '🎁 Welcome offer',
            title: 'Save <strong>10%</strong> booking here',
            subtitle: 'As a first-time visitor, here\'s your exclusive discount. Book directly, no middlemen.',
            codeLabel: 'Your promo code',
            copyBtn: 'Copy',
            copiedBtn: '✓ Copied',
            cta: 'Check Availability',
            trust: '✓ No commitment · ✓ Free cancellation · ✓ <span>Best price guaranteed</span>',
            close: 'Close'
        },
        fr: {
            badge: '🎁 Offre de bienvenue',
            title: 'Économisez <strong>10%</strong> en réservant ici',
            subtitle: 'Pour votre première visite, voici votre remise exclusive. Réservation directe, sans intermédiaires.',
            codeLabel: 'Votre code promo',
            copyBtn: 'Copier',
            copiedBtn: '✓ Copié',
            cta: 'Vérifier Disponibilité',
            trust: '✓ Sans engagement · ✓ Annulation gratuite · ✓ <span>Meilleur prix garanti</span>',
            close: 'Fermer'
        }
    };

    var S = t[LANG] || t.es;

    // ===== HELPERS =====

    // Solo mostrar en home (no en otras paginas)
    function isHome() {
        var page = (location.pathname.split('/').pop() || 'index.php').toLowerCase();
        return (
            page === '' ||
            page === '/' ||
            page === 'index.php' ||
            page === 'index-full-page.php'
        );
    }

    // Verificar si ya se mostro en esta sesion
    function wasShown() {
        try {
            return sessionStorage.getItem(STORAGE_KEY) === '1';
        } catch (e) {
            return false;
        }
    }

    function markAsShown() {
        try {
            sessionStorage.setItem(STORAGE_KEY, '1');
        } catch (e) {
            // Silently fail si sessionStorage no esta disponible
        }
    }

    // URL de reserva: llevar al BUSCADOR con fechas PRE-LLENADAS
    // (search.php tiene el widget integrado de Hospitable)
    // Default: hoy + 2 noches, 2 adultos. El widget Hospitable lee estos params
    // automaticamente y pre-llena el formulario - cero friccion en la pagina destino.
    // Reduce funnel 7 pasos -> 5 pasos (familiar como Booking/Airbnb).
    function getRoomsUrl() {
        var today = new Date();
        var checkout = new Date();
        checkout.setDate(today.getDate() + 2);

        function fmt(d) {
            var y = d.getFullYear();
            var m = String(d.getMonth() + 1).padStart(2, '0');
            var day = String(d.getDate()).padStart(2, '0');
            return y + '-' + m + '-' + day;
        }

        return 'search.php?checkin=' + fmt(today) +
               '&checkout=' + fmt(checkout) +
               '&adults=2';
    }

    // ===== CONSTRUCCION DEL POPUP =====
    function buildPopup() {
        var overlay = document.createElement('div');
        overlay.className = 'cx-popup-overlay';
        overlay.id = 'cx-welcome-popup';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.setAttribute('aria-labelledby', 'cx-popup-title');

        overlay.innerHTML =
            '<div class="cx-popup">' +
                '<button type="button" class="cx-popup-close" aria-label="' + S.close + '">×</button>' +
                '<div class="cx-popup-image" style="background-image: url(\'' + IMAGE_URL + '\');" role="img" aria-label="Casa Xu\'unan"></div>' +
                '<div class="cx-popup-content">' +
                    '<span class="cx-popup-badge">' + S.badge + '</span>' +
                    '<h2 class="cx-popup-title" id="cx-popup-title">' + S.title + '</h2>' +
                    '<p class="cx-popup-subtitle">' + S.subtitle + '</p>' +
                    '<div class="cx-popup-code-block">' +
                        '<span class="cx-popup-code-label">' + S.codeLabel + '</span>' +
                        '<div class="cx-popup-code-row">' +
                            '<span class="cx-popup-code" id="cx-popup-code-text">CASA10</span>' +
                            '<button type="button" class="cx-popup-copy-btn" aria-label="' + S.copyBtn + '">' + S.copyBtn + '</button>' +
                        '</div>' +
                    '</div>' +
                    '<a href="' + getRoomsUrl() + '" class="cx-popup-cta">' + S.cta + ' →</a>' +
                    '<p class="cx-popup-trust">' + S.trust + '</p>' +
                '</div>' +
            '</div>';

        document.body.appendChild(overlay);
        return overlay;
    }

    // ===== LOGICA DE INTERACCION =====
    function openPopup(overlay) {
        // Pequeño delay para que CSS transition funcione bien
        requestAnimationFrame(function () {
            overlay.classList.add('cx-popup-open');
            document.body.classList.add('cx-popup-no-scroll');
        });

        // Marcar como mostrado al ABRIR (no al cerrar)
        // asi si el usuario refresca, no vuelve a verlo
        markAsShown();
    }

    function closePopup(overlay) {
        overlay.classList.remove('cx-popup-open');
        document.body.classList.remove('cx-popup-no-scroll');

        // Remover del DOM despues de la animacion
        setTimeout(function () {
            if (overlay && overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 500);
    }

    function attachEvents(overlay) {
        var closeBtn = overlay.querySelector('.cx-popup-close');
        var copyBtn = overlay.querySelector('.cx-popup-copy-btn');
        var codeText = overlay.querySelector('#cx-popup-code-text');

        // Cerrar con X
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                closePopup(overlay);
            });
        }

        // Cerrar haciendo click fuera (overlay)
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                closePopup(overlay);
            }
        });

        // Cerrar con tecla Escape
        var escHandler = function (e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                closePopup(overlay);
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);

        // Copiar codigo con feedback visual
        if (copyBtn && codeText) {
            copyBtn.addEventListener('click', function () {
                var code = codeText.textContent.trim();

                // Intentar API moderna primero
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(code).then(
                        function () { showCopied(copyBtn); },
                        function () { fallbackCopy(code, copyBtn); }
                    );
                } else {
                    fallbackCopy(code, copyBtn);
                }
            });
        }
    }

    // Fallback para navegadores viejos
    function fallbackCopy(text, btn) {
        var textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        textarea.style.pointerEvents = 'none';
        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();
        try {
            document.execCommand('copy');
            showCopied(btn);
        } catch (e) {
            // Silently fail
        }
        document.body.removeChild(textarea);
    }

    function showCopied(btn) {
        var originalText = btn.textContent;
        btn.textContent = S.copiedBtn;
        btn.classList.add('cx-popup-copied');
        setTimeout(function () {
            btn.textContent = originalText;
            btn.classList.remove('cx-popup-copied');
        }, 2000);
    }

    // ===== INIT =====
    function init() {
        // Solo en home
        if (!isHome()) return;

        // Solo una vez por sesion
        if (wasShown()) return;

        // Esperar al DOM cargado
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', schedulePopup);
        } else {
            schedulePopup();
        }
    }

    function schedulePopup() {
        // Delay de 3 segundos antes de mostrar
        setTimeout(function () {
            var overlay = buildPopup();
            attachEvents(overlay);
            openPopup(overlay);
        }, DELAY_MS);
    }

    // Arrancar
    init();
})();
