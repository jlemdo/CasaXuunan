<?php
/**
 * API Endpoint para obtener traducciones
 * Devuelve las traducciones en formato JSON para uso en JavaScript
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Obtener el idioma del parámetro GET (por defecto: inglés)
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Validar que el idioma sea válido
if (!in_array($lang, ['es', 'en'])) {
    $lang = 'en';
}

// Incluir archivo de traducciones
require_once __DIR__ . '/../includes/translations.php';

// Verificar que existan las traducciones para el idioma solicitado
if (!isset($translations[$lang])) {
    http_response_code(500);
    echo json_encode(['error' => 'Translations not found for language: ' . $lang]);
    exit;
}

// Devolver las traducciones en formato JSON
echo json_encode($translations[$lang], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
