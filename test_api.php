<?php
// Script de prueba para diagnosticar problemas con la API
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico de API Hospitable</h1>";

// Test 1: Verificar variables de entorno
echo "<h2>1. Verificando archivo .env</h2>";
if (file_exists('.env')) {
    echo "✅ Archivo .env existe<br>";
    
    // Cargar .env
    function loadEnv($filePath) {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') === false) continue;
            
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
        }
    }
    
    loadEnv('.env');
    
    $apiKey = $_ENV['HOSPITABLE_API_KEY'] ?? '';
    if (!empty($apiKey)) {
        echo "✅ API Key encontrada (longitud: " . strlen($apiKey) . ")<br>";
        echo "🔑 Inicio del token: " . substr($apiKey, 0, 20) . "...<br>";
    } else {
        echo "❌ API Key NO encontrada<br>";
    }
} else {
    echo "❌ Archivo .env NO existe<br>";
}

// Test 2: Verificar cURL
echo "<h2>2. Verificando cURL</h2>";
if (function_exists('curl_init')) {
    echo "✅ cURL está habilitado<br>";
    $curlVersion = curl_version();
    echo "📝 Versión cURL: " . $curlVersion['version'] . "<br>";
} else {
    echo "❌ cURL NO está habilitado<br>";
}

// Test 3: Probar conexión a la API
echo "<h2>3. Probando conexión a API Hospitable</h2>";
if (!empty($apiKey)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://public.api.hospitable.com/v2/properties');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    echo "📡 Código HTTP: " . $httpCode . "<br>";
    
    if ($error) {
        echo "❌ Error cURL: " . $error . "<br>";
    } else {
        echo "✅ Conexión exitosa<br>";
    }
    
    if ($response) {
        $data = json_decode($response, true);
        if ($data) {
            echo "📄 Respuesta válida JSON<br>";
            if (isset($data['data'])) {
                echo "🏠 Habitaciones encontradas: " . count($data['data']) . "<br>";
                
                // Mostrar primeras 3 propiedades si existen
                if (count($data['data']) > 0) {
                    echo "<h3>Primeras propiedades:</h3>";
                    foreach (array_slice($data['data'], 0, 3) as $property) {
                        echo "- ID: " . ($property['id'] ?? 'N/A') . " | Nombre: " . ($property['name'] ?? 'N/A') . "<br>";
                    }
                }
            } else {
                echo "⚠️ No se encontró 'data' en la respuesta<br>";
            }
        } else {
            echo "❌ Respuesta no es JSON válido<br>";
            echo "📄 Respuesta: " . substr($response, 0, 500) . "...<br>";
        }
    } else {
        echo "❌ No se recibió respuesta<br>";
    }
    
    curl_close($ch);
} else {
    echo "❌ No se puede probar sin API Key<br>";
}

// Test 4: Verificar proxy API
echo "<h2>4. Probando api_proxy_secure.php</h2>";
if (file_exists('api_proxy_secure.php')) {
    echo "✅ Archivo api_proxy_secure.php existe<br>";
    
    // Simular una petición al proxy
    $testUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/api_proxy_secure.php?endpoint=properties";
    echo "🔗 URL de prueba: " . $testUrl . "<br>";
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 30
        ]
    ]);
    
    $proxyResponse = @file_get_contents($testUrl, false, $context);
    
    if ($proxyResponse) {
        $proxyData = json_decode($proxyResponse, true);
        if ($proxyData) {
            echo "✅ Proxy responde correctamente<br>";
            if (isset($proxyData['data'])) {
                echo "🏠 Habitaciones desde proxy: " . count($proxyData['data']) . "<br>";
            }
        } else {
            echo "❌ Proxy no devuelve JSON válido<br>";
            echo "📄 Respuesta proxy: " . substr($proxyResponse, 0, 200) . "...<br>";
        }
    } else {
        echo "❌ No se puede acceder al proxy<br>";
        echo "⚠️ Puede ser un problema de configuración del servidor web<br>";
    }
} else {
    echo "❌ Archivo api_proxy_secure.php NO existe<br>";
}

echo "<h2>5. Recomendaciones</h2>";
echo "1. Verifica la consola del navegador en rooms.php para errores JavaScript<br>";
echo "2. Si hay errores 500, revisa los logs del servidor web<br>";
echo "3. Asegúrate de que el servidor web puede ejecutar PHP y hacer peticiones cURL<br>";
echo "4. Verifica que no hay problemas de firewall bloqueando conexiones a api.hospitable.com<br>";
?>