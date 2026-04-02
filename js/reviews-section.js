/**
 * Reviews Overlay - Bottom Sheet
 * Casa Xuunan
 */

jQuery(document).ready(function($) {

    var $overlay = $('#reviews-overlay');
    var $openBtn = $('#open-reviews-overlay');
    var $closeBtn = $('#reviews-close-button');

    // Abrir overlay
    var elfsightInitialized = false;
    $openBtn.on('click', function(e) {
        e.preventDefault();
        $overlay.addClass('active');
        $('body').css('overflow', 'hidden');

        // Trigger Elfsight widget initialization on first open
        if (!elfsightInitialized) {
            elfsightInitialized = true;
            // Remove lazy attribute so Elfsight processes the widget
            var widgetEl = document.querySelector('.elfsight-app-d417e2fd-4c4c-4718-af81-b5995cd6c060');
            if (widgetEl) {
                widgetEl.removeAttribute('data-elfsight-app-lazy');
            }
            // Tell Elfsight platform to re-scan for widgets
            if (window.elfsight && window.elfsight.reinit) {
                window.elfsight.reinit();
            } else if (window.eapps && window.eapps.Platform) {
                window.eapps.Platform.publish();
            }
            // Dispatch resize to help widget calculate dimensions
            setTimeout(function() {
                window.dispatchEvent(new Event('resize'));
            }, 300);
        }
    });

    // Cerrar overlay con botón X
    $closeBtn.on('click', function(e) {
        e.preventDefault();
        $overlay.removeClass('active');
        $('body').css('overflow', ''); // Restaurar scroll
    });

    // Cerrar overlay al hacer click en el backdrop (área oscura)
    $overlay.on('click', function(e) {
        if (e.target === this) {
            $overlay.removeClass('active');
            $('body').css('overflow', '');
        }
    });

    // Cerrar con tecla ESC
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $overlay.hasClass('active')) {
            $overlay.removeClass('active');
            $('body').css('overflow', '');
        }
    });

    // Ocultar visualmente el enlace "Free Google Reviews widget"
    function hideElfsightLink() {
        $('.reviews-overlay-body a[href^="https://elfsight.com/google-reviews-widget/"]').each(function() {
            var $this = $(this);
            // Verificar que tenga el z-index específico y el texto "Free Google Reviews widget"
            if ($this.attr('style') && $this.attr('style').indexOf('z-index:999999999') !== -1) {
                if ($this.text().indexOf('Free Google Reviews widget') !== -1) {
                    $this.css({
                        'opacity': '0',
                        'width': '1px',
                        'height': '1px',
                        'overflow': 'hidden',
                        'position': 'absolute',
                        'pointer-events': 'none',
                        'font-size': '1px'
                    });
                }
            }
        });
    }

    // Ejecutar inmediatamente
    hideElfsightLink();

    // Observar cambios en el DOM para cambiar z-index si se carga después
    if (window.MutationObserver) {
        var observer = new MutationObserver(function(mutations) {
            hideElfsightLink();
        });

        var targetNode = document.querySelector('.reviews-overlay-body');
        if (targetNode) {
            observer.observe(targetNode, {
                childList: true,
                subtree: true
            });
        }
    }

    // También revisar periódicamente por si acaso
    setInterval(hideElfsightLink, 1000);

});
