/**
 * Reviews Section - Scroll Suave Minimalista
 * Casa Xuunan
 */

jQuery(document).ready(function($) {

    // Scroll suave al hacer click en el botón
    $('.reviews-scroll-btn').on('click', function(e) {
        e.preventDefault();

        var target = $(this.attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800, 'swing');
        }
    });

});
