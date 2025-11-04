/**
 * Custom Mobile Menu para Casa Xuunan
 * Hace que el botón menu-btn abra el overlay en lugar del menú desktop
 * @version 1.0
 */

jQuery(document).ready(function($) {

    // En mobile, hacer que #menu-btn abra el menu overlay
    if ($(window).width() < 993) {

        // Remover TODOS los eventos del menu-btn (incluyendo los del designesia.js)
        $('#menu-btn').off('click');
        $('#menu-btn').off();

        // Prevenir que el designesia.js agregue eventos
        $('#menu-btn').unbind();

        // Agregar nuevo evento para abrir overlay con transición suave
        $('#menu-btn.menu-btn-mobile-overlay').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation(); // Detener cualquier otro evento

            // Abrir el overlay con animación suave
            $('html, body').addClass('no-scroll');

            // Mostrar overlay y animar desde arriba
            $('#menu-overlay').css({
                'display': 'block',
                'top': '-100%',
                'opacity': 0
            }).animate({
                'top': '0',
                'opacity': 1
            }, 400, 'swing');

            // Animar los items del menú con delay
            $('#mo-menu li').each(function(index) {
                $(this).css({
                    'opacity': 0,
                    'transform': 'translateY(-20px)'
                }).delay(100 * index).animate({
                    'opacity': 1
                }, 300).css({
                    'transform': 'translateY(0)'
                });
            });

            // Asegurar que no se agreguen clases extrañas al menu-btn
            $('#menu-btn').removeClass('clicked unclick');

            console.log('Menu overlay abierto');
        });

        // Ocultar el mainmenu en mobile (por si acaso)
        $('#mainmenu').hide();
    }

    // Mejorar el botón de cerrar
    $('#mo-button-close').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Animar items del menú primero (fade out)
        $('#mo-menu li').each(function(index) {
            $(this).delay(50 * index).animate({
                'opacity': 0
            }, 200);
        });

        // Animar cierre del overlay después
        $('#menu-overlay').delay(200).animate({
            'top': '-100%',
            'opacity': 0
        }, 400, 'swing', function() {
            $(this).css('display', 'none');
        });

        $('html, body').delay(600).removeClass('no-scroll');

        // Limpiar cualquier clase del menu-btn
        $('#menu-btn').removeClass('clicked unclick');

        console.log('Menu overlay cerrado');
    });

    // Cerrar al hacer click en un link
    $('#mo-menu a').on('click', function() {
        // Animar items del menú primero (fade out)
        $('#mo-menu li').each(function(index) {
            $(this).delay(50 * index).animate({
                'opacity': 0
            }, 200);
        });

        // Animar cierre del overlay después
        $('#menu-overlay').delay(200).animate({
            'top': '-100%',
            'opacity': 0
        }, 400, 'swing', function() {
            $(this).css('display', 'none');
        });

        $('html, body').delay(600).removeClass('no-scroll');

        // Limpiar cualquier clase del menu-btn
        $('#menu-btn').removeClass('clicked unclick');
    });

    // Re-verificar en resize
    $(window).on('resize', function() {
        if ($(window).width() < 993) {
            $('#menu-btn').off('click');

            $('#menu-btn.menu-btn-mobile-overlay').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $('html, body').addClass('no-scroll');

                $('#menu-overlay').css({
                    'display': 'block',
                    'top': '-100%',
                    'opacity': 0
                }).animate({
                    'top': '0',
                    'opacity': 1
                }, 400, 'swing');

                $('#mo-menu li').each(function(index) {
                    $(this).css({
                        'opacity': 0,
                        'transform': 'translateY(-20px)'
                    }).delay(100 * index).animate({
                        'opacity': 1
                    }, 300).css({
                        'transform': 'translateY(0)'
                    });
                });
            });

            $('#mainmenu').hide();
        } else {
            // En desktop, restaurar comportamiento normal
            $('#mainmenu').show();
        }
    });

});
