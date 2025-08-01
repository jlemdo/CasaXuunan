<?php
// whatsapp_sender.php - Envía mensajes via WhatsApp Business API

require_once 'whatsapp_config_secure.php';

// Función principal para enviar mensaje de WhatsApp
function sendWhatsAppMessage($phone_number, $message, $event_type = '', $reservation_id = '') {
    global $whatsapp_config;
    
    // Limpiar número de teléfono (remover espacios, guiones, etc.)
    $clean_phone = preg_replace('/[^0-9]/', '', $phone_number);
    
    // Asegurar formato internacional
    if (!str_starts_with($clean_phone, '521') && strlen($clean_phone) === 10) {
        $clean_phone = '521' . $clean_phone; // Agregar código México
    }
    
    // Preparar datos para la API
    $api_data = [
        'messaging_product' => 'whatsapp',
        'to' => $clean_phone,
        'type' => 'text',
        'text' => [
            'body' => $message
        ]
    ];
    
    // URL de la API de WhatsApp
    $api_url = $whatsapp_config['api_url'] . $whatsapp_config['phone_number_id'] . '/messages';
    
    // Headers para la petición
    $headers = [
        'Authorization: Bearer ' . $whatsapp_config['access_token'],
        'Content-Type: application/json'
    ];
    
    // Realizar petición cURL
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $api_url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($api_data),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Para desarrollo
        CURLOPT_TIMEOUT => 10
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    // Procesar respuesta
    $success = false;
    $error_message = '';
    
    if ($curl_error) {
        $error_message = "Error cURL: " . $curl_error;
    } elseif ($http_code !== 200) {
        $error_message = "HTTP Error: " . $http_code . " - " . $response;
    } else {
        $response_data = json_decode($response, true);
        if ($response_data && isset($response_data['messages'])) {
            $success = true;
        } else {
            $error_message = "Respuesta API inválida: " . $response;
        }
    }
    
    // Guardar log en base de datos
    logWhatsAppMessage($clean_phone, $message, $event_type, $reservation_id, $success, $error_message);
    
    // Log para debug
    $log_data = [
        'phone' => $clean_phone,
        'success' => $success,
        'http_code' => $http_code,
        'response' => $response
    ];
    
    if ($error_message) {
        $log_data['error'] = $error_message;
    }
    
    error_log("WhatsApp Send Result: " . json_encode($log_data) . "\n", 3, __DIR__ . '/whatsapp_send.log');
    
    return [
        'success' => $success,
        'message' => $success ? 'Mensaje enviado correctamente' : $error_message,
        'phone' => $clean_phone
    ];
}

// Función para enviar mensaje con plantilla (futuro)
function sendWhatsAppTemplate($phone_number, $template_name, $parameters = []) {
    global $whatsapp_config;
    
    $clean_phone = preg_replace('/[^0-9]/', '', $phone_number);
    if (!str_starts_with($clean_phone, '521') && strlen($clean_phone) === 10) {
        $clean_phone = '521' . $clean_phone;
    }
    
    $api_data = [
        'messaging_product' => 'whatsapp',
        'to' => $clean_phone,
        'type' => 'template',
        'template' => [
            'name' => $template_name,
            'language' => [
                'code' => 'es_MX'
            ]
        ]
    ];
    
    // Agregar parámetros si existen
    if (!empty($parameters)) {
        $components = [];
        foreach ($parameters as $param) {
            $components[] = [
                'type' => 'text',
                'text' => $param
            ];
        }
        $api_data['template']['components'] = [
            [
                'type' => 'body',
                'parameters' => $components
            ]
        ];
    }
    
    // Similar implementación que sendWhatsAppMessage...
    // Por ahora usar mensaje de texto simple
    return sendWhatsAppMessage($phone_number, "Mensaje con plantilla: " . $template_name);
}

// Función para guardar log en base de datos
function logWhatsAppMessage($phone, $message, $event_type, $reservation_id, $success, $error_message = '') {
    try {
        $pdo = initDatabase();
        if (!$pdo) {
            return false;
        }
        
        $status = $success ? 'sent' : 'failed';
        $sent_at = $success ? date('Y-m-d H:i:s') : null;
        
        $stmt = $pdo->prepare("
            INSERT INTO whatsapp_logs 
            (event_type, reservation_id, contact_phone, message, status, sent_at, error_message) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $event_type,
            $reservation_id,
            $phone,
            $message,
            $status,
            $sent_at,
            $error_message
        ]);
        
    } catch (PDOException $e) {
        error_log("Error guardando log WhatsApp: " . $e->getMessage());
        return false;
    }
}

// Función para enviar resumen diario
function sendDailySummary() {
    global $notification_contacts;
    
    // Obtener estadísticas del día usando tu API de Hospitable
    $today = date('Y-m-d');
    
    try {
        // Usar tu api_proxy.php existente para obtener reservas del día
        $reservations_url = "http://" . $_SERVER['HTTP_HOST'] . "/api_proxy.php?endpoint=reservations?check_in_date=" . $today;
        $reservations_response = file_get_contents($reservations_url);
        $reservations_data = json_decode($reservations_response, true);
        
        $new_reservations = $reservations_data['data'] ?? [];
        $count_reservations = count($new_reservations);
        
        // Calcular ingresos totales
        $total_revenue = 0;
        foreach ($new_reservations as $reservation) {
            $total_revenue += $reservation['total_amount'] ?? 0;
        }
        
        // Generar mensaje de resumen
        $summary_message = "📊 *RESUMEN DIARIO* - " . date('d/M/Y') . "\n\n";
        $summary_message .= "🎉 Nuevas reservas: *{$count_reservations}*\n";
        $summary_message .= "💰 Ingresos generados: *$" . number_format($total_revenue, 2) . " MXN*\n\n";
        
        if ($count_reservations > 0) {
            $summary_message .= "📋 *Detalles:*\n";
            foreach (array_slice($new_reservations, 0, 3) as $reservation) { // Solo primeras 3
                $guest_name = $reservation['guest']['name'] ?? 'N/A';
                $property = $reservation['property']['name'] ?? 'N/A';
                $summary_message .= "• {$guest_name} - {$property}\n";
            }
            
            if ($count_reservations > 3) {
                $remaining = $count_reservations - 3;
                $summary_message .= "• ... y {$remaining} más\n";
            }
        }
        
        $summary_message .= "\n🏠 *Casa Xu'unan* - Sistema automático";
        
        // Enviar solo al manager
        $manager_contact = $notification_contacts['manager'];
        return sendWhatsAppMessage($manager_contact['phone'], $summary_message, 'daily_summary');
        
    } catch (Exception $e) {
        error_log("Error generando resumen diario: " . $e->getMessage());
        return false;
    }
}

// Función para probar envío (para configuración inicial)
function testWhatsAppConnection($phone_number) {
    $test_message = "🧪 *PRUEBA DE CONEXIÓN*\n\n";
    $test_message .= "✅ Sistema WhatsApp de Casa Xu'unan configurado correctamente\n";
    $test_message .= "📅 " . date('d/M/Y H:i') . "\n\n";
    $test_message .= "Ya puedes recibir notificaciones automáticas de reservaciones.";
    
    return sendWhatsAppMessage($phone_number, $test_message, 'test');
}

// Función para obtener estadísticas de envíos
function getWhatsAppStats($days = 7) {
    try {
        $pdo = initDatabase();
        if (!$pdo) {
            return false;
        }
        
        $since_date = date('Y-m-d', strtotime("-{$days} days"));
        
        $stmt = $pdo->prepare("
            SELECT 
                event_type,
                status,
                COUNT(*) as count
            FROM whatsapp_logs 
            WHERE DATE(created_at) >= ?
            GROUP BY event_type, status
            ORDER BY event_type, status
        ");
        
        $stmt->execute([$since_date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Error obteniendo estadísticas WhatsApp: " . $e->getMessage());
        return false;
    }
}

?>