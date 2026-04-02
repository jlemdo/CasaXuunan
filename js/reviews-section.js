/**
 * Reviews Overlay - Bottom Sheet
 * Casa Xuunan
 *
 * Elfsight script is loaded dynamically on first overlay open,
 * after the overlay is visible (translateY(0)), so Elfsight's
 * IntersectionObserver can detect the widget.
 */

jQuery(document).ready(function($) {

    var $overlay = $('#reviews-overlay');
    var $openBtn = $('#open-reviews-overlay');
    var $closeBtn = $('#reviews-close-button');

    // Abrir overlay
    var elfsightLoaded = false;
    $openBtn.on('click', function(e) {
        e.preventDefault();
        $overlay.addClass('active');
        $('body').css('overflow', 'hidden');

        // Load Elfsight script on first open, after overlay transition completes
        if (!elfsightLoaded) {
            elfsightLoaded = true;
            setTimeout(function() {
                var script = document.createElement('script');
                script.src = 'https://static.elfsight.com/platform/platform.js';
                script.setAttribute('data-use-service-core', '');
                document.head.appendChild(script);
            }, 500);
        }
    });

    // Cerrar overlay con botón X
    $closeBtn.on('click', function(e) {
        e.preventDefault();
        $overlay.removeClass('active');
        $('body').css('overflow', '');
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

    hideElfsightLink();

    if (window.MutationObserver) {
        var observer = new MutationObserver(function() {
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

    setInterval(hideElfsightLink, 1000);

});
