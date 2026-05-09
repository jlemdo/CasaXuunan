<?php
/**
 * API Endpoint para obtener traducciones
 * Devuelve las traducciones en formato JSON para uso en JavaScript
 *
 * Soporta 3 idiomas: es / en / fr
 * - translations.php: contiene 'es' y 'en'
 * - translations-fr.php: extiende con 'fr'
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Obtener el idioma del parametro GET (por defecto: espanol, idioma base del sitio)
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'es';

// Validar que el idioma sea valido (3 idiomas soportados)
if (!in_array($lang, ['es', 'en', 'fr'])) {
    $lang = 'es';
}

// Incluir archivos de traducciones (orden importa: translations primero, luego fr lo extiende)
require_once __DIR__ . '/../includes/translations.php';
require_once __DIR__ . '/../includes/translations-fr.php';

// Verificar que existan las traducciones para el idioma solicitado
if (!isset($translations[$lang])) {
    // Fallback: si por alguna razon no existe el idioma solicitado, devolver espanol
    if (isset($translations['es'])) {
        echo json_encode($translations['es'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
    http_response_code(500);
    echo json_encode(['error' => 'Translations not found for language: ' . $lang]);
    exit;
}

// Devolver las traducciones en formato JSON
echo json_encode($translations[$lang], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
