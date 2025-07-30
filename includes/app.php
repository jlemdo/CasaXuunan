<?php

// Rutas internas del proyecto
define('TEMPLATES_URL', __DIR__ . '/templates');
define('SECTIONS_URL', __DIR__ . '/sections');
define('SCRIPTS_URL', __DIR__ . '/scripts');
define('FUNCIONES_URL', __DIR__ . '/funciones.php');

// Detectar protocolo (http o https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

// Obtener dominio actual (localhost o dominio real)
$host = $_SERVER['HTTP_HOST'];

// Obtener ruta base del proyecto (por si está en subcarpeta)
$base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

// Construir la URL base dinámica
define('BASE_URL', $protocol . '://' . $host . $base_path . '/');

