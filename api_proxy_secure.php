<?php
// api_proxy_secure.php - VERSIÓN SEGURA
// ESTA es la versión que subes al servidor

// Cargar variables de entorno
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        die('Error: Archivo .env no encontrado');
    }
    
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Cargar configuración
loadEnv(__DIR__ . '/.env');

// Modo de entorno: automáticamente production en servidor
$environment = 'production';

// Obtener API key desde variables de entorno
$apiKey = $_ENV['HOSPITABLE_API_KEY'] ?? '';

if (empty($apiKey)) {
    http_response_code(500);
    echo json_encode(['error' => 'API Key de Hospitable no configurada']);
    exit;
}

// Verificar si cURL está habilitado
if (!function_exists('curl_init')) {
    http_response_code(500);
    echo json_encode(['error' => 'cURL no está habilitado en el servidor PHP']);
    exit;
}

// Obtener el endpoint de la solicitud
if (!isset($_GET['endpoint'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No se proporcionó el endpoint']);
    exit;
}

$endpoint = $_GET['endpoint'];

// Inicializar cURL
$ch = curl_init();

// Configurar la solicitud cURL
curl_setopt($ch, CURLOPT_URL, 'https://public.api.hospitable.com/v2/' . $endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Configuración para producción (SSL habilitado)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Manejo de errores cURL
if ($response === false) {
    $error_msg = curl_error($ch);
    http_response_code(500);
    echo json_encode(['error' => 'Error en la solicitud cURL: ' . $error_msg]);
    curl_close($ch);
    exit;
}

// Obtener el código de estado HTTP de la respuesta
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Cerrar cURL
curl_close($ch);

// Establecer las cabeceras CORS y tipo de contenido
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Enviar el código de estado HTTP de la respuesta original
http_response_code($http_code);

// Enviar la respuesta
echo $response;
?>