<?php
/**
 * API endpoint para obtener traducciones en JavaScript
 * Casa Xuunan
 */

// No mostrar la salida HTML del sistema de templates
define('JSON_OUTPUT', true);

require_once 'includes/funciones.php';

// Establecer header JSON
header('Content-Type: application/json');

// Obtener idioma actual
$lang = getCurrentLanguage();

// Preparar traducciones para el slider
$sliderTranslations = [
    'lang' => $lang,
    'slider_1_title' => t('slider_1_title'),
    'slider_1_button' => t('slider_1_button'),
    'slider_2_title' => t('slider_2_title'),
    'slider_2_button' => t('slider_2_button'),
    'slider_3_title' => t('slider_3_title'),
    'slider_3_button' => t('slider_3_button'),
];

// Enviar JSON
echo json_encode($sliderTranslations, JSON_UNESCAPED_UNICODE);
?>
