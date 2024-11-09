<?php
// includes/funciones.php

require_once 'app.php';

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

    // Incluir el header con variaciones basadas en $customHeaderFooter
    incluirHeader($customHeaderFooter);

    // Ruta completa al template
    $templatePath = TEMPLATES_URL . "/$nombre.php";
    if (file_exists($templatePath)) {
        include_once $templatePath;
    } else {
        echo "<!-- Template $nombre.php no encontrado -->";
    }

    // Incluir el footer con variaciones basadas en $customHeaderFooter
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
?>
