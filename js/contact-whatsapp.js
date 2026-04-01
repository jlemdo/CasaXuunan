/**
 * Contact Form - WhatsApp Integration
 * Casa Xuunan
 */

jQuery(document).ready(function($) {

    // Ocultar todas las alertas al inicio
    $('.error').hide();
    $('#success_message').hide();
    $('#error_message').hide();

    $('#contact_form').submit(function(e) {
        e.preventDefault();

        // Ocultar alertas previas
        $('.error').hide();
        $('#success_message').hide();
        $('#error_message').hide();

        // Obtener valores del formulario
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var phone = $('#phone').val().trim();
        var message = $('#message').val().trim();

        // Validaciones
        var hasError = false;

        // Validar nombre
        if (name === '') {
            $('#name_error').fadeIn();
            hasError = true;
        }

        // Validar que tenga al menos email O teléfono
        if (email === '' && phone === '') {
            $('#contact_error').fadeIn();
            hasError = true;
        }

        // Validar email si fue proporcionado
        if (email !== '' && !isValidEmail(email)) {
            $('#email_error').fadeIn();
            hasError = true;
        }

        // Validar mensaje
        if (message === '') {
            $('#message_error').fadeIn();
            hasError = true;
        }

        // Si hay errores, mostrar alerta general y detener
        if (hasError) {
            $('#error_message').fadeIn();
            return false;
        }

        // Construir mensaje para WhatsApp
        var whatsappMessage = '¡Hola! Soy *' + name + '*\n\n';

        if (email !== '') {
            whatsappMessage += '📧 *Email:* ' + email + '\n';
        }

        if (phone !== '') {
            whatsappMessage += '📱 *Teléfono:* ' + phone + '\n';
        }

        whatsappMessage += '\n💬 *Mensaje:*\n' + message;

        // Codificar el mensaje para URL
        var encodedMessage = encodeURIComponent(whatsappMessage);

        // Número de WhatsApp (formato internacional sin +, espacios ni guiones)
        var whatsappNumber = '5219852580599';

        // Construir URL de WhatsApp
        var whatsappURL = 'https://api.whatsapp.com/send?phone=' + whatsappNumber + '&text=' + encodedMessage;

        // Google Ads Conversion Tracking - Reserva enviada
        if (typeof gtag === 'function') {
            gtag('event', 'conversion', {
                'send_to': 'AW-18041631980/BOOKING_LABEL',
                'value': 1400,
                'currency': 'MXN'
            });
        }

        // Mostrar mensaje de éxito
        $('#success_message').fadeIn();

        // Abrir WhatsApp en nueva ventana
        window.open(whatsappURL, '_blank');

        // Opcional: Limpiar el formulario después de 2 segundos
        setTimeout(function() {
            $('#contact_form')[0].reset();
            $('#success_message').fadeOut();
        }, 3000);

        return false;
    });

    // Función para validar email
    function isValidEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    // Limpiar errores cuando el usuario empieza a escribir
    $('#name').on('input', function() {
        $('#name_error').fadeOut();
        $('#error_message').fadeOut();
    });

    $('#email').on('input', function() {
        $('#email_error').fadeOut();
        $('#contact_error').fadeOut();
        $('#error_message').fadeOut();
    });

    $('#phone').on('input', function() {
        $('#phone_error').fadeOut();
        $('#contact_error').fadeOut();
        $('#error_message').fadeOut();
    });

    $('#message').on('input', function() {
        $('#message_error').fadeOut();
        $('#error_message').fadeOut();
    });

});
