<?php
// whatsapp_config_secure.php - Configuración SEGURA del sistema WhatsApp
// ESTA es la versión que subes al servidor

// Cargar variables de entorno
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        die('Error: Archivo .env no encontrado. Asegúrate de subirlo al servidor.');
    }
    
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Saltar comentarios
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Cargar configuración desde .env
loadEnv(__DIR__ . '/.env');

// ===== CONFIGURACIÓN WHATSAPP API =====
$whatsapp_config = [
    'access_token' => $_ENV['WHATSAPP_ACCESS_TOKEN'] ?? '',
    'phone_number_id' => $_ENV['WHATSAPP_PHONE_ID'] ?? '',
    'api_url' => 'https://graph.facebook.com/v23.0/',
    'webhook_verify_token' => $_ENV['WHATSAPP_WEBHOOK_TOKEN'] ?? ''
];

// Verificar que las variables estén configuradas
if (empty($whatsapp_config['access_token']) || empty($whatsapp_config['phone_number_id'])) {
    die('Error: Variables de WhatsApp no configuradas en archivo .env');
}

// ===== CONTACTOS A NOTIFICAR =====
$notification_contacts = [
    'manager' => [
        'name' => 'Manager Principal',
        'phone' => $_ENV['MANAGER_PHONE'] ?? '',
        'events' => ['all'] // Recibe todos los eventos
    ],
    'manager_2' => [
        'name' => 'Manager Secundario',
        'phone' => $_ENV['MANAGER_PHONE_2'] ?? '',
        'events' => ['all'] // Recibe todos los eventos
    ],
    'limpieza' => [
        'name' => 'Equipo Limpieza',
        'phone' => $_ENV['MANAGER_PHONE'] ?? '', // Mismo número para pruebas
        'events' => ['checkin_reminder', 'checkout_reminder', 'date_changes']
    ],
    'recepcion' => [
        'name' => 'Recepción',
        'phone' => $_ENV['MANAGER_PHONE'] ?? '', // Mismo número para pruebas
        'events' => ['new_message', 'reservation_confirmed']
    ]
];

// Verificar que el teléfono esté configurado
if (empty($notification_contacts['manager']['phone'])) {
    die('Error: Número de teléfono no configurado en archivo .env');
}

// ===== CONFIGURACIÓN DE EVENTOS =====
$event_config = [
    'reservation.created' => [
        'active' => true,
        'priority' => 'high',
        'contacts' => ['manager', 'manager_2'],
        'time_restriction' => false // 24/7
    ],
    'reservation.cancelled' => [
        'active' => true,
        'priority' => 'critical',
        'contacts' => ['manager', 'manager_2'],
        'time_restriction' => false
    ],
    'reservation.modified' => [
        'active' => true,
        'priority' => 'medium',
        'contacts' => ['manager', 'manager_2', 'limpieza'],
        'time_restriction' => true // Solo horario laboral
    ],
    'message.created' => [
        'active' => true,
        'priority' => 'high',
        'contacts' => ['manager', 'manager_2', 'recepcion'],
        'time_restriction' => false
    ],
    'review.created' => [
        'active' => true,
        'priority' => 'low',
        'contacts' => ['manager', 'manager_2'],
        'time_restriction' => true
    ]
];

// ===== HORARIOS DE NOTIFICACIÓN =====
$notification_hours = [
    'start' => '08:00',
    'end' => '22:00',
    'timezone' => 'America/Mexico_City'
];

// ===== BASE DE DATOS (SQLite simple) =====
$db_config = [
    'file' => __DIR__ . '/whatsapp_logs.db'
];

// Función para verificar si está en horario de notificación
function isInNotificationHours() {
    global $notification_hours;
    
    date_default_timezone_set($notification_hours['timezone']);
    $current_time = date('H:i');
    
    return ($current_time >= $notification_hours['start'] && 
            $current_time <= $notification_hours['end']);
}

// Función para obtener contactos por evento
function getContactsForEvent($event_type) {
    global $notification_contacts, $event_config;
    
    if (!isset($event_config[$event_type])) {
        return [];
    }
    
    $contacts = [];
    $event_contacts = $event_config[$event_type]['contacts'];
    
    foreach ($event_contacts as $contact_key) {
        if (isset($notification_contacts[$contact_key])) {
            $contacts[] = $notification_contacts[$contact_key];
        }
    }
    
    return $contacts;
}

// Función para verificar si evento debe enviarse ahora
function shouldSendNotification($event_type) {
    global $event_config;
    
    if (!isset($event_config[$event_type]) || !$event_config[$event_type]['active']) {
        return false;
    }
    
    // Si tiene restricción de horario, verificar
    if ($event_config[$event_type]['time_restriction']) {
        return isInNotificationHours();
    }
    
    return true; // Eventos sin restricción (24/7)
}

// Inicializar base de datos SQLite
function initDatabase() {
    global $db_config;
    
    try {
        $pdo = new PDO('sqlite:' . $db_config['file']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Crear tabla de logs si no existe
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS whatsapp_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                event_type TEXT NOT NULL,
                reservation_id TEXT,
                contact_phone TEXT NOT NULL,
                message TEXT NOT NULL,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                sent_at DATETIME,
                error_message TEXT
            )
        ");
        
        // Crear tabla de configuración
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS whatsapp_settings (
                key TEXT PRIMARY KEY,
                value TEXT NOT NULL,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        return $pdo;
        
    } catch (PDOException $e) {
        error_log("Error inicializando base de datos WhatsApp: " . $e->getMessage());
        return null;
    }
}

?>