<?php
/**
 * Sistema de Traduccion - Casa Xuunan
 * Manejo de idiomas ES / EN / FR para SEO
 *
 * Idiomas soportados:
 *   - es: Espanol (mercado domestico Mexico)
 *   - en: English (USA, UK, Canada)
 *   - fr: Francais (Francia, Belgica, Suiza, Quebec)
 */

// Iniciar sesion si no esta iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Idiomas soportados (cambiar aqui si se agregan mas)
const CX_SUPPORTED_LANGS = ['es', 'en', 'fr'];

// Funcion para obtener el idioma actual
function getCurrentLanguage() {
    // 1. Si hay ?lang= en la URL, el usuario eligio idioma explicitamente
    //    Guardar en cookie (dura 30 dias) para recordar su eleccion
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        if (in_array($lang, CX_SUPPORTED_LANGS, true)) {
            setcookie('cx_lang', $lang, time() + 86400 * 30, '/', '', true, true);
            $_SESSION['lang'] = $lang;
            return $lang;
        }
    }

    // 2. Si el usuario eligio idioma manualmente antes (cookie), respetar esa eleccion
    if (isset($_COOKIE['cx_lang'])) {
        $lang = $_COOKIE['cx_lang'];
        if (in_array($lang, CX_SUPPORTED_LANGS, true)) {
            $_SESSION['lang'] = $lang;
            return $lang;
        }
    }

    // 3. Auto-detectar idioma del navegador (modo agresivo)
    //    Lee Accept-Language y matchea cualquier variante regional:
    //    - fr-FR, fr-CA, fr-BE, fr-CH, fr -> fr
    //    - en-US, en-GB, en-CA, en-AU, en -> en
    //    - es-MX, es-ES, es-AR, es -> es
    $accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $primary_lang = strtolower(substr($accept, 0, 2));

    // Frances: cubre Francia, Belgica, Suiza, Quebec, Luxemburgo
    if ($primary_lang === 'fr') {
        $_SESSION['lang'] = 'fr';
        return 'fr';
    }

    // Ingles: cubre USA, UK, Canada (anglo), Australia, Irlanda
    if ($primary_lang === 'en') {
        $_SESSION['lang'] = 'en';
        return 'en';
    }

    // 4. Para cualquier otro idioma (o sin header), default espanol
    //    Casa Xu'unan es un B&B en Mexico - espanol es el idioma natural
    $_SESSION['lang'] = 'es';
    return 'es';
}

// Funcion para obtener traduccion
function t($key) {
    global $translations;
    $lang = getCurrentLanguage();

    if (isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }

    // Fallback: si no hay traduccion en idioma actual, intentar ingles
    // (mejor mostrar ingles que la key cruda al usuario)
    if ($lang !== 'en' && isset($translations['en'][$key])) {
        return $translations['en'][$key];
    }

    // Fallback final: espanol (idioma base del sitio)
    if ($lang !== 'es' && isset($translations['es'][$key])) {
        return $translations['es'][$key];
    }

    // Si no encuentra nada, devolver la key
    return $key;
}

// Funcion para cambiar idioma (ciclo: es -> en -> fr -> es)
// Mantenemos retrocompatibilidad: si alguna parte vieja del codigo
// llama switchLanguage() esperando ES<->EN, ahora cicla 3 idiomas.
function switchLanguage() {
    $current = getCurrentLanguage();
    if ($current === 'es') return 'en';
    if ($current === 'en') return 'fr';
    return 'es'; // fr -> es
}

// Helper: obtener lista de idiomas alternativos al actual
// Para usar en el navbar dropdown (ej: si estoy en ES, mostrar EN y FR)
function getAlternateLanguages() {
    $current = getCurrentLanguage();
    return array_values(array_filter(CX_SUPPORTED_LANGS, function($l) use ($current) {
        return $l !== $current;
    }));
}

// Helper: nombre nativo del idioma (para mostrar en selector)
function getLanguageNativeName($lang) {
    $names = [
        'es' => 'Espanol',
        'en' => 'English',
        'fr' => 'Francais',
    ];
    return $names[$lang] ?? strtoupper($lang);
}

// Helper: codigo ISO 639-1 mayusculas (para mostrar bandera/abreviacion)
function getLanguageCode($lang) {
    return strtoupper($lang);
}

// Establecer el idioma actual
$current_lang = getCurrentLanguage();

// Cargar traducciones (orden: es/en primero, luego fr lo extiende)
include_once __DIR__ . '/translations.php';
include_once __DIR__ . '/translations-fr.php';
?>
