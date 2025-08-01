<?php
// test_whatsapp.php - Prueba inicial del sistema WhatsApp

require_once 'whatsapp_config_secure.php';
require_once 'whatsapp_sender.php';

echo "🧪 <strong>PRUEBA DEL SISTEMA WHATSAPP</strong><br><br>";

// Verificar configuración
echo "📋 <strong>Verificando configuración...</strong><br>";
echo "✅ Token configurado: " . substr($whatsapp_config['access_token'], 0, 20) . "...<br>";
echo "✅ Phone ID: " . $whatsapp_config['phone_number_id'] . "<br>";
echo "✅ Número de prueba: " . $notification_contacts['manager']['phone'] . "<br><br>";

// Crear base de datos
echo "🗄️ <strong>Inicializando base de datos...</strong><br>";
$db = initDatabase();
if ($db) {
    echo "✅ Base de datos SQLite creada/conectada<br><br>";
} else {
    echo "❌ Error creando base de datos<br><br>";
}

// Enviar mensaje de prueba
echo "📱 <strong>Enviando mensaje de prueba...</strong><br>";
$test_phone = $notification_contacts['manager']['phone'];
$result = testWhatsAppConnection($test_phone);

if ($result['success']) {
    echo "✅ <strong>¡ÉXITO!</strong> Mensaje enviado correctamente<br>";
    echo "📱 Enviado a: " . $result['phone'] . "<br>";
    echo "💬 Revisa tu WhatsApp en unos segundos<br><br>";
} else {
    echo "❌ <strong>ERROR:</strong> " . $result['message'] . "<br>";
    echo "📱 Número: " . $result['phone'] . "<br><br>";
    
    // Mostrar detalles del error para debug
    echo "<strong>🔍 Debug Info:</strong><br>";
    echo "- Verifica que tu token no haya expirado<br>";
    echo "- Confirma que el Phone Number ID sea correcto<br>";
    echo "- Revisa que el número esté en formato internacional<br><br>";
}

// Mostrar información de configuración
echo "🔗 <strong>Información para Hospitable:</strong><br>";
echo "Webhook URL: <code>https://" . $_SERVER['HTTP_HOST'] . "/webhook_receiver.php</code><br>";
echo "Verify Token: <code>" . $whatsapp_config['webhook_verify_token'] . "</code><br><br>";

// Simular evento de nueva reserva
echo "🎭 <strong>Simulando nueva reserva...</strong><br>";
$fake_reservation = [
    'id' => 'TEST_' . time(),
    'guest_name' => 'Juan Pérez (PRUEBA)',
    'property_name' => 'Casa Xu\'unan: PB "A"',
    'check_in' => date('Y-m-d', strtotime('+3 days')),
    'check_out' => date('Y-m-d', strtotime('+7 days')),
    'guests' => 2,
    'total' => 1250.00,
    'currency' => 'MXN',
    'channel' => 'Prueba Sistema'
];

require_once 'message_templates.php';
$test_message = generateNewReservationMessage($fake_reservation);

echo "📝 <strong>Mensaje que se enviaría:</strong><br>";
echo "<div style='background: #f0f0f0; padding: 10px; border-left: 3px solid #25D366; font-family: monospace; white-space: pre-line;'>";
echo htmlspecialchars($test_message);
echo "</div><br>";

// Probar envío del mensaje de reserva
echo "📤 <strong>Enviando mensaje de reserva de prueba...</strong><br>";
$reservation_result = sendWhatsAppMessage($test_phone, $test_message, 'test_reservation', $fake_reservation['id']);

if ($reservation_result['success']) {
    echo "✅ <strong>¡PERFECTO!</strong> Mensaje de reserva enviado<br>";
    echo "🎉 El sistema está funcionando correctamente<br><br>";
} else {
    echo "❌ Error enviando mensaje de reserva: " . $reservation_result['message'] . "<br><br>";
}

echo "<hr>";
echo "🏁 <strong>Prueba completada</strong><br>";
echo "Si recibiste los mensajes en WhatsApp, el sistema está listo para usar.<br>";
echo "Siguiente paso: Configurar webhook en Hospitable.";
?>