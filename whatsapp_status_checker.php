<?php
// Verificador de estado WhatsApp Business API
require_once 'whatsapp_config_secure.php';

echo "🔍 <strong>DIAGNÓSTICO WHATSAPP BUSINESS API</strong><br><br>";

// 1. Verificar configuración actual
echo "📋 <strong>Configuración actual:</strong><br>";
echo "✅ Access Token: " . substr($whatsapp_config['access_token'], 0, 30) . "...<br>";
echo "✅ Phone Number ID: " . $whatsapp_config['phone_number_id'] . "<br>";
echo "✅ Número destino: " . $notification_contacts['manager']['phone'] . "<br><br>";

// 2. Probar conectividad básica con la API
echo "🌐 <strong>Probando conectividad API...</strong><br>";

$api_url = $whatsapp_config['api_url'] . $whatsapp_config['phone_number_id'];
$headers = [
    'Authorization: Bearer ' . $whatsapp_config['access_token'],
    'Content-Type: application/json'
];

// Hacer petición GET para verificar phone number
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $api_url,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 10
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    echo "✅ API conectada correctamente<br>";
    $phone_info = json_decode($response, true);
    if (isset($phone_info['verified_name'])) {
        echo "✅ Nombre verificado: " . $phone_info['verified_name'] . "<br>";
    }
    if (isset($phone_info['code_verification_status'])) {
        echo "📱 Estado verificación: " . $phone_info['code_verification_status'] . "<br>";
    }
} else {
    echo "❌ Error API (HTTP $http_code): $response<br>";
}

echo "<br>";

// 3. Verificar últimos mensajes del log
echo "📊 <strong>Últimos intentos de envío:</strong><br>";
$log_file = __DIR__ . '/whatsapp_send.log';
if (file_exists($log_file)) {
    $log_lines = file($log_file, FILE_IGNORE_NEW_LINES);
    $recent_lines = array_slice($log_lines, -5); // Últimas 5 líneas
    
    foreach ($recent_lines as $line) {
        $log_data = json_decode(substr($line, strpos($line, '{')), true);
        if ($log_data) {
            $status = $log_data['success'] ? '✅' : '❌';
            $http = $log_data['http_code'];
            echo "$status HTTP $http - Teléfono: {$log_data['phone']}<br>";
            
            if (isset($log_data['response'])) {
                $response_data = json_decode($log_data['response'], true);
                if (isset($response_data['messages'][0]['id'])) {
                    echo "   📧 Message ID: {$response_data['messages'][0]['id']}<br>";
                }
                if (isset($response_data['error'])) {
                    echo "   ⚠️ Error: {$response_data['error']['message']}<br>";
                }
            }
        }
    }
} else {
    echo "❌ No se encontró archivo de log<br>";
}

echo "<br>";

// 4. Posibles causas
echo "🔧 <strong>Posibles causas si no recibes mensajes:</strong><br>";
echo "1. 📱 <strong>Número no registrado en WhatsApp Business:</strong><br>";
echo "   - El número debe estar activo en WhatsApp<br>";
echo "   - Debe ser un número real, no virtual<br><br>";

echo "2. 🚫 <strong>Restricciones de la aplicación:</strong><br>";
echo "   - Tu app puede estar en modo 'desarrollo' con números limitados<br>";
echo "   - Necesitas verificación de negocio para envío masivo<br><br>";

echo "3. ⏱️ <strong>Retrasos de entrega:</strong><br>";
echo "   - Los mensajes pueden tardar hasta 30 segundos<br>";
echo "   - Revisa la carpeta de mensajes filtrados en WhatsApp<br><br>";

echo "4. 🔒 <strong>Configuración de privacidad:</strong><br>";
echo "   - WhatsApp puede bloquear mensajes de números desconocidos<br>";
echo "   - Revisa configuración de privacidad en WhatsApp<br><br>";

// 5. Siguiente prueba recomendada
echo "🧪 <strong>Prueba recomendada:</strong><br>";
echo "1. Verifica que tu número <code>" . $notification_contacts['manager']['phone'] . "</code> esté activo en WhatsApp<br>";
echo "2. Ve a Meta Business Manager → WhatsApp → Phone Numbers<br>";
echo "3. Verifica el estado de tu aplicación WhatsApp Business<br>";
echo "4. Prueba enviando desde un número diferente si tienes otro disponible<br>";

?>