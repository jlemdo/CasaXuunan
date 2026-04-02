<?php
/**
 * Sistema de Traducción - Casa Xuunan
 * Manejo de idiomas ES/EN para SEO
 */

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Función para obtener el idioma actual
function getCurrentLanguage() {
    // 1. Si hay ?lang= en la URL, el usuario eligió idioma explícitamente
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        if ($lang === 'en' || $lang === 'es') {
            $_SESSION['lang'] = $lang;
            $_SESSION['lang_explicit'] = true;
            return $lang;
        }
    }

    // 2. Si el usuario eligió idioma manualmente antes, respetar esa elección
    if (!empty($_SESSION['lang_explicit']) && isset($_SESSION['lang'])) {
        return $_SESSION['lang'];
    }

    // 3. Auto-detectar idioma del navegador (siempre en visitas sin elección explícita)
    $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
    if ($browser_lang === 'es') {
        $_SESSION['lang'] = 'es';
        return 'es';
    }

    // 4. Por defecto inglés
    $_SESSION['lang'] = 'en';
    return 'en';
}

// Función para obtener traducción
function t($key) {
    global $translations;
    $lang = getCurrentLanguage();

    if (isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }

    // Si no encuentra la traducción, devolver la key
    return $key;
}

// Función para cambiar idioma
function switchLanguage() {
    $current = getCurrentLanguage();
    return $current === 'es' ? 'en' : 'es';
}

// Establecer el idioma actual
$current_lang = getCurrentLanguage();

// Cargar traducciones
include_once __DIR__ . '/translations.php';
?>
