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
    //    Guardar en cookie (dura 30 días) para recordar su elección
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        if ($lang === 'en' || $lang === 'es') {
            setcookie('cx_lang', $lang, time() + 86400 * 30, '/', '', true, true);
            $_SESSION['lang'] = $lang;
            return $lang;
        }
    }

    // 2. Si el usuario eligió idioma manualmente antes (cookie), respetar esa elección
    if (isset($_COOKIE['cx_lang'])) {
        $lang = $_COOKIE['cx_lang'];
        if ($lang === 'en' || $lang === 'es') {
            $_SESSION['lang'] = $lang;
            return $lang;
        }
    }

    // 3. Auto-detectar idioma del navegador
    //    Buscar 'es' en cualquier posición del Accept-Language (ej: "en-US,en;q=0.9,es;q=0.8")
    $accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $primary_lang = substr($accept, 0, 2);

    // Si el idioma principal del navegador es inglés, mostrar inglés
    if ($primary_lang === 'en') {
        $_SESSION['lang'] = 'en';
        return 'en';
    }

    // 4. Para cualquier otro idioma (o sin header), default español
    //    Casa Xu'unan es un B&B en México — español es el idioma natural
    $_SESSION['lang'] = 'es';
    return 'es';
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
