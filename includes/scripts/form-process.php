<?php
// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload de Composer (asegúrate de haber ejecutado `composer require phpmailer/phpmailer`)
require 'vendor/autoload.php';

// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Reemplaza con tu servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'user@example.com'; // Reemplaza con tu correo
    $mail->Password = 'secret'; // Reemplaza con tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // o PHPMailer::ENCRYPTION_SMTPS para SSL
    $mail->Port = 587; // Puerto del servidor SMTP (usualmente 587 para TLS)

    // Remitente y destinatario
    $mail->setFrom('from@example.com', 'Nombre Remitente');
    $mail->addAddress('to@example.com', 'Nombre Destinatario'); // Añadir destinatario

    // Opcional: añadir CC o BCC
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Asunto del correo';

    // Plantilla HTML para el cuerpo del mensaje
    $body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Template</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            table { max-width: 600px; margin: 20px auto; border-collapse: collapse; background-color: #ffffff; }
            h1, p { color: #333333; }
            .header { background-color: #007BFF; padding: 20px; color: #ffffff; text-align: center; }
            .footer { background-color: #333333; padding: 20px; color: #ffffff; text-align: center; }
            .content { padding: 20px; }
            .btn { display: inline-block; padding: 10px 20px; background-color: #007BFF; color: #ffffff; text-decoration: none; border-radius: 5px; }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td class="header">
                    <h1>Bienvenido a Nuestro Servicio</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <p>Estimado(a) [Nombre],</p>
                    <p>Gracias por unirse a nuestro servicio. Estamos emocionados de tenerlo(a) con nosotros.</p>
                    <p>Si tiene alguna pregunta, no dude en contactarnos.</p>
                    <p>Saludos,<br>El equipo de [Tu Empresa]</p>
                    <p style="text-align: center;">
                        <a href="#" class="btn">Visítanos</a>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <p>&copy; ' . date("Y") . ' Tu Empresa. Todos los derechos reservados.</p>
                </td>
            </tr>
        </table>
    </body>
    </html>
    ';

    $mail->Body = $body;
    $mail->AltBody = 'Este es el cuerpo alternativo en texto plano para clientes de correo que no soportan HTML.';

    // Enviar el correo
    $mail->send();
    echo 'El mensaje se envió correctamente';
} catch (Exception $e) {
    echo "El mensaje no se pudo enviar. Mailer Error: {$mail->ErrorInfo}";
}
?>
