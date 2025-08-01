<?php
// webhook_receiver.php - Recibe webhooks de Hospitable y procesa eventos

require_once 'whatsapp_config_secure.php';
require_once 'whatsapp_sender.php';
require_once 'message_templates.php';

// Configurar headers para JSON
header('Content-Type: application/json');

// Función para log de debug
function logDebug($message, $data = null) {
    $log_entry = date('Y-m-d H:i:s') . " - " . $message;
    if ($data) {
        $log_entry .= " - Data: " . json_encode($data);
    }
    error_log($log_entry . "\n", 3, __DIR__ . '/webhook_debug.log');
}

// Verificación de webhook (para configuración inicial)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $verify_token = $_GET['hub_verify_token'] ?? '';
    $challenge = $_GET['hub_challenge'] ?? '';
    
    if ($verify_token === $whatsapp_config['webhook_verify_token']) {
        echo $challenge;
        exit;
    } else {
        http_response_code(403);
        echo json_encode(['error' => 'Token de verificación inválido']);
        exit;
    }
}

// Procesar webhook POST de Hospitable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener datos del webhook
    $raw_input = file_get_contents('php://input');
    $webhook_data = json_decode($raw_input, true);
    
    // Log del webhook recibido
    logDebug("Webhook recibido", $webhook_data);
    
    // Verificar que tenemos datos válidos
    if (!$webhook_data || !isset($webhook_data['action'])) {
        logDebug("Webhook inválido - no contiene action");
        http_response_code(400);
        echo json_encode(['error' => 'Datos de webhook inválidos']);
        exit;
    }
    
    $action = $webhook_data['action'];
    $data = $webhook_data['data'] ?? [];
    
    // Procesar según el tipo de evento
    try {
        switch ($action) {
            case 'reservation.created':
                processNewReservation($data);
                break;
                
            case 'reservation.cancelled':
                processCancelledReservation($data);
                break;
                
            case 'reservation.modified':
                processModifiedReservation($data);
                break;
                
            case 'reservation.confirmed':
                processConfirmedReservation($data);
                break;
                
            case 'message.created':
                processNewMessage($data);
                break;
                
            case 'review.created':
                processNewReview($data);
                break;
                
            default:
                logDebug("Evento no manejado: " . $action);
        }
        
        // Respuesta exitosa a Hospitable
        http_response_code(200);
        echo json_encode(['status' => 'processed', 'action' => $action]);
        
    } catch (Exception $e) {
        logDebug("Error procesando webhook: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Error interno del servidor']);
    }
    
    exit;
}

// ===== FUNCIONES DE PROCESAMIENTO =====

function processNewReservation($data) {
    global $event_config;
    
    if (!shouldSendNotification('reservation.created')) {
        logDebug("Nueva reserva - fuera de horario de notificación");
        return;
    }
    
    // Extraer información de la reserva (formato Hospitable)
    $guest_first = $data['guest']['first_name'] ?? '';
    $guest_last = $data['guest']['last_name'] ?? '';
    $guest_name = trim($guest_first . ' ' . $guest_last) ?: 'Huésped sin nombre';
    
    $property_name = $data['properties'][0]['name'] ?? 'Propiedad desconocida';
    
    // Extraer totales de financials
    $total_amount = $data['financials']['guest']['total_price']['amount'] ?? 0;
    $total_amount = $total_amount / 100; // Hospitable envía en centavos
    
    $reservation = [
        'id' => $data['id'] ?? 'N/A',
        'guest_name' => $guest_name,
        'property_name' => $property_name,
        'check_in' => $data['check_in'] ?? '',
        'check_out' => $data['check_out'] ?? '',
        'guests' => $data['guests']['total'] ?? 1,
        'total' => $total_amount,
        'currency' => $data['financials']['currency'] ?? 'MXN',
        'channel' => ucfirst($data['platform'] ?? 'Directo')
    ];
    
    // Generar mensaje
    $message = generateNewReservationMessage($reservation);
    
    // Enviar a contactos configurados
    $contacts = getContactsForEvent('reservation.created');
    foreach ($contacts as $contact) {
        sendWhatsAppMessage($contact['phone'], $message, 'reservation.created', $reservation['id']);
    }
    
    logDebug("Nueva reserva procesada", $reservation);
}

function processCancelledReservation($data) {
    if (!shouldSendNotification('reservation.cancelled')) {
        return;
    }
    
    $reservation = [
        'id' => $data['id'] ?? 'N/A',
        'guest_name' => $data['guest']['name'] ?? 'Huésped sin nombre',
        'property_name' => $data['property']['name'] ?? 'Propiedad desconocida',
        'check_in' => $data['check_in_date'] ?? '',
        'check_out' => $data['check_out_date'] ?? '',
        'cancellation_reason' => $data['cancellation_reason'] ?? 'No especificada'
    ];
    
    $message = generateCancelledReservationMessage($reservation);
    
    $contacts = getContactsForEvent('reservation.cancelled');
    foreach ($contacts as $contact) {
        sendWhatsAppMessage($contact['phone'], $message, 'reservation.cancelled', $reservation['id']);
    }
    
    logDebug("Reserva cancelada procesada", $reservation);
}

function processModifiedReservation($data) {
    if (!shouldSendNotification('reservation.modified')) {
        return;
    }
    
    $reservation = [
        'id' => $data['id'] ?? 'N/A',
        'guest_name' => $data['guest']['name'] ?? 'Huésped sin nombre',
        'property_name' => $data['property']['name'] ?? 'Propiedad desconocida',
        'changes' => $data['changes'] ?? []
    ];
    
    $message = generateModifiedReservationMessage($reservation);
    
    $contacts = getContactsForEvent('reservation.modified');
    foreach ($contacts as $contact) {
        sendWhatsAppMessage($contact['phone'], $message, 'reservation.modified', $reservation['id']);
    }
    
    logDebug("Reserva modificada procesada", $reservation);
}

function processConfirmedReservation($data) {
    $reservation = [
        'id' => $data['id'] ?? 'N/A',
        'guest_name' => $data['guest']['name'] ?? 'Huésped sin nombre',
        'property_name' => $data['property']['name'] ?? 'Propiedad desconocida',
        'check_in' => $data['check_in_date'] ?? '',
        'check_out' => $data['check_out_date'] ?? ''
    ];
    
    $message = generateConfirmedReservationMessage($reservation);
    
    $contacts = getContactsForEvent('reservation.confirmed');
    foreach ($contacts as $contact) {
        sendWhatsAppMessage($contact['phone'], $message, 'reservation.confirmed', $reservation['id']);
    }
    
    logDebug("Reserva confirmada procesada", $reservation);
}

function processNewMessage($data) {
    if (!shouldSendNotification('message.created')) {
        return;
    }
    
    // Extraer datos del mensaje (formato Hospitable)
    $message_data = [
        'guest_name' => $data['sender']['full_name'] ?? 'Huésped desconocido',
        'property_name' => 'Casa Xu\'unan', // Por defecto
        'message_content' => $data['body'] ?? 'Mensaje vacío',
        'channel' => ucfirst($data['platform'] ?? 'Desconocido'),
        'received_at' => date('H:i')
    ];
    
    $message = generateNewMessageAlert($message_data);
    
    $contacts = getContactsForEvent('message.created');
    foreach ($contacts as $contact) {
        sendWhatsAppMessage($contact['phone'], $message, 'message.created');
    }
    
    logDebug("Nuevo mensaje procesado", $message_data);
}

function processNewReview($data) {
    if (!shouldSendNotification('review.created')) {
        return;
    }
    
    // Extraer datos de la reseña (formato Hospitable)
    $guest_first = $data['guest']['first_name'] ?? '';
    $guest_last = $data['guest']['last_name'] ?? '';
    $guest_name = trim($guest_first . ' ' . $guest_last) ?: 'Huésped anónimo';
    
    $review_data = [
        'guest_name' => $guest_name,
        'property_name' => $data['property']['name'] ?? 'Casa Xu\'unan',
        'rating' => $data['public']['rating'] ?? 0,
        'comment' => substr($data['public']['review'] ?? 'Sin comentario', 0, 100),
        'platform' => ucfirst($data['platform'] ?? 'Desconocida')
    ];
    
    $message = generateNewReviewAlert($review_data);
    
    $contacts = getContactsForEvent('review.created');
    foreach ($contacts as $contact) {
        sendWhatsAppMessage($contact['phone'], $message, 'review.created');
    }
    
    logDebug("Nueva reseña procesada", $review_data);
}

?>