<?php
// includes/funciones.php

require_once 'app.php';
require_once __DIR__ . '/language.php';

/**
 * Incluye un template basado en condiciones específicas
 *
 * @param string $nombre Nombre del template a incluir
 * @param bool $customHeaderFooter Si se debe utilizar un header o footer personalizados
 */
function incluirTemplate(string $nombre, bool $customHeaderFooter = false)
{
    // Incluir la sección del header (puede contener meta tags o scripts necesarios)
    incluirSection('header');

    // SPECIAL CASE: el HOME (index.php) llama con $customHeaderFooter = false
    // porque su footer es footer-index.php (las 7 secciones del redisenio).
    // PERO el navbar viejo (navbar-index.php con home-header-simple + hamburguesa)
    // queremos reemplazarlo por el navbar.php estandar (menu horizontal completo).
    //
    // Estrategia: para index.php usamos navbar.php (true) PERO footer-index.php (false).
    // Esto se detecta por el nombre del template.
    $useStandardNavbar = $customHeaderFooter || $nombre === 'index';

    // Incluir el header (navbar): standard navbar.php para todas las paginas
    // (incluyendo home), salvo casos especiales que aun necesiten navbar-index.
    incluirHeader($useStandardNavbar);

    // Ruta completa al template
    $templatePath = TEMPLATES_URL . "/$nombre.php";
    if (file_exists($templatePath)) {
        include_once $templatePath;
    } else {
        echo "<!-- Template $nombre.php no encontrado -->";
    }

    // Incluir el footer: SOLO usar footer.php standard si $customHeaderFooter true.
    // El home mantiene footer-index.php (con las 7 secciones del redisenio).
    incluirFooter($customHeaderFooter);

    // Incluir la sección de scripts JS al final, justo antes de cerrar el body
    incluirSection('js');
}

/**
 * Incluye el header basado en la condición especificada
 *
 * @param bool $customHeaderFooter Si se debe utilizar un header personalizado
 */
function incluirHeader(bool $customHeaderFooter = false)
{
    $headerFile = $customHeaderFooter ? "navbar.php" : "navbar-index.php";
    $headerPath = TEMPLATES_URL . "/$headerFile";

    if (file_exists($headerPath)) {
        include_once $headerPath;
    } else {
        echo "<!-- Header $headerFile no encontrado -->";
    }
}

/**
 * Incluye el footer basado en la condición especificada
 *
 * @param bool $customHeaderFooter Si se debe utilizar un footer personalizado
 */
function incluirFooter(bool $customHeaderFooter = false)
{
    $footerFile = $customHeaderFooter ? "footer.php" : "footer-index.php";
    $footerPath = TEMPLATES_URL . "/$footerFile";

    if (file_exists($footerPath)) {
        include_once $footerPath;
    } else {
        echo "<!-- Footer $footerFile no encontrado -->";
    }
}

/**
 * Incluye una sección específica
 *
 * @param string $nombre Nombre de la sección a incluir
 */
function incluirSection(string $nombre)
{
    $sectionPath = SECTIONS_URL . "/$nombre.php";
    if (file_exists($sectionPath)) {
        include_once $sectionPath;
    } else {
        echo "<!-- Sección $nombre.php no encontrada -->";
    }
}

/**
 * Genera URL a search.php con fechas pre-llenadas (CRO).
 *
 * Default: check-in hoy, check-out en +N noches, 2 adultos.
 * El widget Hospitable lee estos params automaticamente y pre-llena el formulario.
 *
 * @param int $nights Numero de noches default (default 2)
 * @param int $adults Numero de adultos default (default 2)
 * @param int $children Numero de ninos default (default 0)
 * @return string URL completa lista para usar en href
 *
 * Uso en templates:
 *     <a href="<?php echo searchUrl(); ?>">Reservar</a>
 *     <a href="<?php echo searchUrl(3); ?>">Reservar 3 noches</a>
 *     <a href="<?php echo searchUrl(2, 4, 1); ?>">Familia (4 adultos + 1 nino)</a>
 *
 * NOTA: La fecha se calcula con la zona horaria de Mexico (America/Mexico_City)
 * para que coincida con la del huesped que esta viendo el sitio.
 */
function searchUrl(int $nights = 2, int $adults = 2, int $children = 0): string
{
    // Calcular fechas en zona horaria de Mexico (Valladolid, Yucatan)
    $tz = new DateTimeZone('America/Mexico_City');
    $checkin = new DateTime('today', $tz);
    $checkout = (clone $checkin)->modify("+{$nights} days");

    // Construir query string con params estandar Hospitable
    $params = [
        'checkin'  => $checkin->format('Y-m-d'),
        'checkout' => $checkout->format('Y-m-d'),
        'adults'   => $adults,
    ];

    if ($children > 0) {
        $params['children'] = $children;
    }

    return 'search.php?' . http_build_query($params);
}
?>
