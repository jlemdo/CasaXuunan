<?php
// api_proxy.php


// Habilitar la visualización de errores (solo para desarrollo)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Modo de entorno: 'development' o 'production'
$environment = 'development'; // Cambia a 'production' cuando estés listo para la versión final
 
// Configura tu clave de API de Hospitable
$apiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YTYyNGRmMC0xMmYxLTQ0OGUtYjg4NC00MzY3ODBhNWQzY2QiLCJqdGkiOiI0OWUzNWNiNTcwNjI0YzVmYjM4NjE2ZjlmMTUwZjBhMmJkZWRjMmRkNzVmY2YwZjNlZWE2MjU1NjFkYmY3ZDZmODg2OTkzYzRmNTIwODJlMSIsImlhdCI6MTcyOTgxOTAyNS44NjczMjYsIm5iZiI6MTcyOTgxOTAyNS44NjczMywiZXhwIjoxNzYxMzU1MDI1Ljg2Mzk4Nywic3ViIjoiMTk4NzgyIiwic2NvcGVzIjpbInBhdDpyZWFkIiwicGF0OndyaXRlIl19.QgzOChJgoYQcnqleoLXmHIgyTgctHfKYGVLMZf2RmoGhNLhcuyHxGd0SXL5s3a4MkK_8LBJHnrxOz2WgPghMfRm--glRGPfTsmon805-Z7mard-tY-Lm8UjIqYQrUCbvG-9AyYvqqnFbD_b5a5URlXv1Ve2nRDOqUSrRPex8ydl4KfNHPfi6mBZgVk0fcHYHsm12hGdYABnTn2ZPMTta3Dam8iCLZfyEpQoZBdMVgi5FrhfAu2GzRb0EuXv__g8k11mCgmqUXlNto0sDoYvAP5UnlyBeWyg-rnwYP6Ha39g2-KDenS-jH8H8Y296GWy3hpdqM869Tg4tE2jvXYDJ6mK8uON5E8TggqHhim1Z-FHM5eJAnhCAqpS0xnBB5WzYQ8Fi_9KaqxaJYU8PXgg-d26Gpr7Ffrrsw2g7ABtb_CAlIb8rks7-BxZeWpbWivvs6gUfie0HI_bEOWXbUcXBdya3WgRTT1GuS0hzVNu_BD9lcBA9cfSw9fTiU5XbA4lEm5Je8XbkkmdcDo9giilKU2hM9p9vdMxQvihV_m37RLYRO_oUnnUrlmWLPWXj92hfWxa3t3HlY7-XDNgkqP_H4oMmx_3X5EA4YpM8MOQfVyRwWn5DCeOATVZArt8zdL4JZou9Tu4mwZiBA2mnMsX8LaSE0JNxt1sk_hDy443YTv8'; // Reemplaza con tu clave de API real


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

// Configuración basada en el entorno
if ($environment === 'development') {
    // Modo Desarrollo: Desactivar verificación SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
} else {
    // Modo Producción: Usar archivo cacert.pem para verificación SSL
    curl_setopt($ch, CURLOPT_CAINFO, 'ruta/a/cacert.pem'); // Ajusta la ruta al archivo cacert.pem
}

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