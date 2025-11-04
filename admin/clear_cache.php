<?php
/**
 * Script para limpiar caché de la API
 * Accesible solo por administradores
 */

// Seguridad básica - cambiar contraseña
$adminPassword = 'xuunan2024'; // CAMBIAR ESTO en producción

if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    http_response_code(403);
    die('Acceso denegado');
}

require_once __DIR__ . '/../config/cache.php';
require_once __DIR__ . '/../config/rate_limiter.php';

$cache = new SimpleCache(__DIR__ . '/../cache');
$rateLimiter = new RateLimiter(__DIR__ . '/../cache/rate_limit');

$action = $_GET['action'] ?? 'all';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Caché - Casa Xuunan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .success {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info {
            background: #2196F3;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .button:hover {
            background: #45a049;
        }
        .stats {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧹 Administrador de Caché</h1>

        <?php
        if ($action === 'clear_all') {
            $deleted = $cache->clear();
            echo "<div class='success'>✅ Se eliminaron {$deleted} archivos de caché</div>";
        } elseif ($action === 'cleanup') {
            $deleted = $cache->cleanup();
            echo "<div class='success'>✅ Se limpiaron {$deleted} archivos de caché expirados</div>";
        } elseif ($action === 'rate_limit_cleanup') {
            $deleted = $rateLimiter->cleanup();
            echo "<div class='success'>✅ Se limpiaron {$deleted} archivos de rate limiting</div>";
        }
        ?>

        <div class="stats">
            <h3>📊 Estadísticas</h3>
            <?php
            $cacheFiles = glob(__DIR__ . '/../cache/*.cache');
            $rateLimitFiles = glob(__DIR__ . '/../cache/rate_limit/*.limit');
            $logFiles = glob(__DIR__ . '/../logs/*.log');

            echo "<p><strong>Archivos de caché:</strong> " . count($cacheFiles) . "</p>";
            echo "<p><strong>Archivos de rate limiting:</strong> " . count($rateLimitFiles) . "</p>";
            echo "<p><strong>Archivos de log:</strong> " . count($logFiles) . "</p>";

            // Calcular tamaño total
            $totalSize = 0;
            foreach (array_merge($cacheFiles, $rateLimitFiles, $logFiles) as $file) {
                $totalSize += filesize($file);
            }
            echo "<p><strong>Tamaño total:</strong> " . round($totalSize / 1024, 2) . " KB</p>";
            ?>
        </div>

        <h3>⚙️ Acciones</h3>
        <a href="?password=<?php echo $adminPassword; ?>&action=clear_all" class="button" onclick="return confirm('¿Estás seguro de limpiar TODO el caché?')">
            🗑️ Limpiar Todo el Caché
        </a>
        <a href="?password=<?php echo $adminPassword; ?>&action=cleanup" class="button">
            🧹 Limpiar Caché Expirado
        </a>
        <a href="?password=<?php echo $adminPassword; ?>&action=rate_limit_cleanup" class="button">
            🚦 Limpiar Rate Limiting
        </a>

        <div class="info">
            <strong>ℹ️ Información:</strong><br>
            - El caché se limpia automáticamente después de 5 minutos<br>
            - El rate limiting permite 30 requests por minuto por IP<br>
            - Los logs se rotan automáticamente al llegar a 10MB
        </div>

        <p style="margin-top: 30px; color: #999; font-size: 12px;">
            Casa Xuunan - Sistema de Caché v2.0
        </p>
    </div>
</body>
</html>
