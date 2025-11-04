<?php
/**
 * Ejemplo de uso del Cliente API de Hospitable v2
 * Demuestra todas las funcionalidades disponibles
 */

// Configuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar dependencias
require_once __DIR__ . '/../config/hospitable_api.php';
require_once __DIR__ . '/../config/cache.php';
require_once __DIR__ . '/../config/logger.php';

// Cargar variables de entorno
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        die('Error: Archivo .env no encontrado');
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0 || strpos($line, '=') === false) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

loadEnv(__DIR__ . '/../.env');

// Inicializar componentes
$cache = new SimpleCache(__DIR__ . '/../cache', 300);
$logger = new Logger('api_example.log', 'DEBUG');
$api = new HospitableAPI($_ENV['HOSPITABLE_API_KEY'], $cache, $logger);

echo "<h1>🏨 Ejemplos de Uso - Hospitable API v2</h1>";
echo "<style>body{font-family:Arial;max-width:900px;margin:0 auto;padding:20px;}pre{background:#f5f5f5;padding:15px;border-radius:5px;overflow-x:auto;}</style>";

// ===== EJEMPLO 1: Obtener todas las propiedades =====
echo "<h2>1️⃣ Obtener Todas las Propiedades</h2>";
try {
    $properties = $api->getProperties();
    echo "<p><strong>✅ Propiedades encontradas:</strong> " . count($properties['data']) . "</p>";
    echo "<pre>" . json_encode($properties['data'][0], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}

// ===== EJEMPLO 2: Obtener una propiedad específica =====
echo "<h2>2️⃣ Obtener Propiedad Específica</h2>";
try {
    if (isset($properties['data'][0]['id'])) {
        $propertyId = $properties['data'][0]['id'];
        $property = $api->getProperty($propertyId);
        echo "<p><strong>✅ Propiedad:</strong> " . $property['data']['name'] . "</p>";
        echo "<pre>" . json_encode($property['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}

// ===== EJEMPLO 3: Obtener imágenes de una propiedad =====
echo "<h2>3️⃣ Obtener Imágenes de Propiedad</h2>";
try {
    if (isset($propertyId)) {
        $images = $api->getPropertyImages($propertyId);
        echo "<p><strong>✅ Imágenes encontradas:</strong> " . count($images['data']) . "</p>";

        if (!empty($images['data'])) {
            echo "<div style='display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin:20px 0;'>";
            foreach (array_slice($images['data'], 0, 6) as $image) {
                echo "<img src='{$image['url']}' style='width:100%;height:200px;object-fit:cover;border-radius:5px;' alt='Property'>";
            }
            echo "</div>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}

// ===== EJEMPLO 4: Verificar disponibilidad (calendario) =====
echo "<h2>4️⃣ Verificar Disponibilidad</h2>";
try {
    if (isset($propertyId)) {
        $today = date('Y-m-d');
        $nextWeek = date('Y-m-d', strtotime('+7 days'));

        $calendar = $api->getPropertyCalendar($propertyId, $today, $nextWeek);
        echo "<p><strong>✅ Calendario obtenido</strong></p>";
        echo "<p>Período: {$today} a {$nextWeek}</p>";

        // Mostrar disponibilidad
        echo "<table style='width:100%;border-collapse:collapse;'>";
        echo "<tr style='background:#4CAF50;color:white;'><th style='padding:10px;'>Fecha</th><th>Disponible</th><th>Precio</th></tr>";

        foreach ($calendar['data']['days'] as $day) {
            $available = $day['status']['available'] ? '✅ Sí' : '❌ No';
            $price = isset($day['price']['amount']) ? '$' . ($day['price']['amount'] / 100) : 'N/A';
            $bgColor = $day['status']['available'] ? '#e8f5e9' : '#ffebee';

            echo "<tr style='background:{$bgColor};'>";
            echo "<td style='padding:10px;border:1px solid #ddd;'>{$day['date']}</td>";
            echo "<td style='padding:10px;border:1px solid #ddd;text-align:center;'>{$available}</td>";
            echo "<td style='padding:10px;border:1px solid #ddd;text-align:center;'>{$price}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}

// ===== EJEMPLO 5: Obtener reservas =====
echo "<h2>5️⃣ Obtener Reservas</h2>";
try {
    $reservations = $api->getReservations([
        'check_in_from' => date('Y-m-d', strtotime('-30 days')),
        'check_in_to' => date('Y-m-d', strtotime('+30 days'))
    ]);

    echo "<p><strong>✅ Reservas encontradas:</strong> " . count($reservations['data']) . "</p>";

    if (!empty($reservations['data'])) {
        echo "<table style='width:100%;border-collapse:collapse;'>";
        echo "<tr style='background:#2196F3;color:white;'><th style='padding:10px;'>ID</th><th>Huésped</th><th>Check-in</th><th>Check-out</th><th>Total</th></tr>";

        foreach (array_slice($reservations['data'], 0, 10) as $reservation) {
            $guestName = ($reservation['guest']['first_name'] ?? '') . ' ' . ($reservation['guest']['last_name'] ?? '');
            $checkIn = $reservation['check_in'] ?? 'N/A';
            $checkOut = $reservation['check_out'] ?? 'N/A';
            $total = isset($reservation['financials']['guest']['total_price']['amount'])
                ? '$' . ($reservation['financials']['guest']['total_price']['amount'] / 100)
                : 'N/A';

            echo "<tr>";
            echo "<td style='padding:10px;border:1px solid #ddd;'>" . substr($reservation['id'], 0, 8) . "...</td>";
            echo "<td style='padding:10px;border:1px solid #ddd;'>{$guestName}</td>";
            echo "<td style='padding:10px;border:1px solid #ddd;'>{$checkIn}</td>";
            echo "<td style='padding:10px;border:1px solid #ddd;'>{$checkOut}</td>";
            echo "<td style='padding:10px;border:1px solid #ddd;'>{$total}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay reservas en el período especificado</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}

// ===== EJEMPLO 6: Estadísticas de caché =====
echo "<h2>6️⃣ Estadísticas de Caché</h2>";
$cacheFiles = glob(__DIR__ . '/../cache/*.cache');
$cacheSize = 0;
foreach ($cacheFiles as $file) {
    $cacheSize += filesize($file);
}

echo "<div style='background:#f5f5f5;padding:15px;border-radius:5px;'>";
echo "<p><strong>📁 Archivos en caché:</strong> " . count($cacheFiles) . "</p>";
echo "<p><strong>💾 Tamaño total:</strong> " . round($cacheSize / 1024, 2) . " KB</p>";
echo "<p><strong>⏱️ TTL configurado:</strong> 5 minutos</p>";
echo "</div>";

// ===== EJEMPLO 7: Limpiar caché =====
echo "<h2>7️⃣ Limpiar Caché</h2>";
echo "<p><a href='?clear_cache=1' style='display:inline-block;padding:10px 20px;background:#f44336;color:white;text-decoration:none;border-radius:5px;'>🗑️ Limpiar Todo el Caché</a></p>";

if (isset($_GET['clear_cache'])) {
    $deleted = $cache->clear();
    echo "<div style='background:#4CAF50;color:white;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "✅ Se eliminaron {$deleted} archivos de caché";
    echo "</div>";
    echo "<script>setTimeout(() => window.location.href = window.location.pathname, 2000);</script>";
}

// ===== Footer =====
echo "<hr style='margin:40px 0;'>";
echo "<p style='text-align:center;color:#999;'>Casa Xuunan - Sistema de API v2.0 | " . date('Y-m-d H:i:s') . "</p>";
?>
