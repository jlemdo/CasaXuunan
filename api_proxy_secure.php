<?php
/**
 * API Proxy Seguro para Hospitable API v2
 * Intermediario seguro entre frontend y Hospitable API
 * @version 2.0
 */

// Configuración de entorno
$environment = getenv('APP_ENV') ?: 'production';

// Logging de errores (solo en desarrollo)
if ($environment === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/api_errors.log');

/**
 * Carga variables de entorno desde archivo .env
 * @param string $filePath Ruta al archivo .env
 * @return bool True si se carga exitosamente
 */
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        error_log("ERROR: Archivo .env no encontrado en: {$filePath}");
        return false;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);

        // Ignorar comentarios y líneas vacías
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }

        // Validar formato
        if (strpos($line, '=') === false) {
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

    return true;
}

// Cargar configuración
if (!loadEnv(__DIR__ . '/.env')) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de configuración del servidor']);
    exit;
}

// Cargar sistema de caché
require_once __DIR__ . '/config/cache.php';
$cache = new SimpleCache(__DIR__ . '/cache', 300); // 5 minutos de TTL

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

// Log del endpoint para debugging
error_log("API Proxy - Endpoint solicitado: " . $endpoint);
error_log("API Proxy - URL completa: https://public.api.hospitable.com/v2/" . $endpoint);

// Verificar si tenemos respuesta en caché
$cacheKey = 'hospitable_' . md5($endpoint);
$cachedResponse = $cache->get($cacheKey);

if ($cachedResponse !== null) {
    // Responder desde caché
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('X-Cache: HIT');
    http_response_code(200);
    echo $cachedResponse;
    exit;
}

// Inicializar cURL
$ch = curl_init();

// Configurar la solicitud cURL
$url = 'https://public.api.hospitable.com/v2/' . $endpoint;
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
        'Accept: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 3
]);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Manejo de errores cURL
if ($response === false) {
    $error_msg = curl_error($ch);
    $error_details = [
        'curl_error' => $error_msg,
        'curl_errno' => curl_errno($ch),
        'endpoint' => $endpoint,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    error_log('CURL Error: ' . json_encode($error_details));
    http_response_code(500);
    echo json_encode(['error' => 'Error en la solicitud cURL: ' . $error_msg, 'details' => $error_details]);
    curl_close($ch);
    exit;
}

// Obtener el código de estado HTTP de la respuesta
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Log para códigos de error
if ($http_code >= 400) {
    $error_details = [
        'http_code' => $http_code,
        'endpoint' => $endpoint,
        'response' => substr($response, 0, 500),
        'timestamp' => date('Y-m-d H:i:s')
    ];
    error_log('HTTP Error: ' . json_encode($error_details));
}

// Cerrar cURL
curl_close($ch);

// Guardar en caché si fue exitoso
if ($http_code === 200 && !empty($response)) {
    $cache->set($cacheKey, $response);
}

// Establecer las cabeceras CORS y tipo de contenido
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('X-Cache: MISS');

// Enviar el código de estado HTTP de la respuesta original
http_response_code($http_code);

// Enviar la respuesta
echo $response;
?>