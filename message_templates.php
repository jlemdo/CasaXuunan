<?php
// message_templates.php - Plantillas de mensajes para WhatsApp

// ===== PLANTILLAS DE MENSAJES =====

function generateNewReservationMessage($reservation) {
    $check_in_formatted = date('d/M/Y', strtotime($reservation['check_in']));
    $check_out_formatted = date('d/M/Y', strtotime($reservation['check_out']));
    
    $message = "🎉 *NUEVA RESERVA*\n\n";
    $message .= "👤 *Huésped:* {$reservation['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$reservation['property_name']}\n";
    $message .= "📅 *Check-in:* {$check_in_formatted}\n";
    $message .= "📅 *Check-out:* {$check_out_formatted}\n";
    $message .= "👥 *Huéspedes:* {$reservation['guests']}\n";
    $message .= "💰 *Total:* $" . number_format($reservation['total'], 2) . " {$reservation['currency']}\n";
    $message .= "📱 *Canal:* {$reservation['channel']}\n\n";
    $message .= "🆔 *ID:* {$reservation['id']}";
    
    return $message;
}

function generateCancelledReservationMessage($reservation) {
    $check_in_formatted = date('d/M/Y', strtotime($reservation['check_in']));
    $check_out_formatted = date('d/M/Y', strtotime($reservation['check_out']));
    
    $message = "❌ *RESERVA CANCELADA*\n\n";
    $message .= "👤 *Huésped:* {$reservation['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$reservation['property_name']}\n";
    $message .= "📅 *Fechas:* {$check_in_formatted} - {$check_out_formatted}\n";
    $message .= "📝 *Motivo:* {$reservation['cancellation_reason']}\n\n";
    $message .= "🔄 *Acción:* Fechas liberadas para nuevas reservas\n";
    $message .= "🆔 *ID:* {$reservation['id']}";
    
    return $message;
}

function generateModifiedReservationMessage($reservation) {
    $message = "📝 *RESERVA MODIFICADA*\n\n";
    $message .= "👤 *Huésped:* {$reservation['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$reservation['property_name']}\n\n";
    $message .= "🔄 *Cambios realizados:*\n";
    
    // Procesar cambios específicos
    if (!empty($reservation['changes'])) {
        foreach ($reservation['changes'] as $change) {
            $message .= "• " . formatChange($change) . "\n";
        }
    } else {
        $message .= "• Detalles de la reserva actualizados\n";
    }
    
    $message .= "\n🆔 *ID:* {$reservation['id']}";
    
    return $message;
}

function generateConfirmedReservationMessage($reservation) {
    $check_in_formatted = date('d/M/Y', strtotime($reservation['check_in']));
    $check_out_formatted = date('d/M/Y', strtotime($reservation['check_out']));
    
    $message = "✅ *RESERVA CONFIRMADA*\n\n";
    $message .= "👤 *Huésped:* {$reservation['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$reservation['property_name']}\n";
    $message .= "📅 *Check-in:* {$check_in_formatted}\n";
    $message .= "📅 *Check-out:* {$check_out_formatted}\n\n";
    $message .= "🎯 *Estado:* Pendiente → Confirmada ✅\n";
    $message .= "🆔 *ID:* {$reservation['id']}";
    
    return $message;
}

function generateNewMessageAlert($message_data) {
    $message = "💬 *NUEVO MENSAJE*\n\n";
    $message .= "👤 *De:* {$message_data['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$message_data['property_name']}\n";
    $message .= "📱 *Canal:* {$message_data['channel']}\n";
    $message .= "⏰ *Recibido:* {$message_data['received_at']}\n\n";
    $message .= "💭 *Mensaje:*\n\"{$message_data['message_content']}\"\n\n";
    $message .= "📲 *Responder en la plataforma correspondiente*";
    
    return $message;
}

function generateNewReviewAlert($review_data) {
    $stars = str_repeat('⭐', $review_data['rating']);
    
    $message = "⭐ *NUEVA RESEÑA*\n\n";
    $message .= "👤 *Cliente:* {$review_data['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$review_data['property_name']}\n";
    $message .= "⭐ *Calificación:* {$stars} ({$review_data['rating']}/5)\n";
    $message .= "📱 *Plataforma:* {$review_data['platform']}\n\n";
    $message .= "💭 *Comentario:*\n\"{$review_data['comment']}";
    
    if (strlen($review_data['comment']) >= 100) {
        $message .= "...\"";
    } else {
        $message .= "\"";
    }
    
    return $message;
}

function generateCheckinReminder($reservation) {
    $check_in_date = date('d/M/Y', strtotime($reservation['check_in']));
    $check_in_time = date('H:i', strtotime($reservation['check_in']));
    
    $message = "🔔 *RECORDATORIO CHECK-IN*\n\n";
    $message .= "👤 *Huésped:* {$reservation['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$reservation['property_name']}\n";
    $message .= "📅 *Check-in:* {$check_in_date} a las {$check_in_time}\n";
    
    if (isset($reservation['guest_phone'])) {
        $message .= "📱 *Contacto:* {$reservation['guest_phone']}\n";
    }
    
    $message .= "\n🏠 *Preparar habitación*\n";
    $message .= "🧹 *Verificar limpieza final*\n";
    $message .= "🆔 *ID:* {$reservation['id']}";
    
    return $message;
}

function generateCheckoutReminder($reservation) {
    $checkout_date = date('d/M/Y', strtotime($reservation['check_out']));
    $checkout_time = date('H:i', strtotime($reservation['check_out']));
    
    $message = "🚪 *CHECK-OUT HOY*\n\n";
    $message .= "👤 *Huésped:* {$reservation['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$reservation['property_name']}\n";
    $message .= "📅 *Check-out:* {$checkout_date} a las {$checkout_time}\n\n";
    $message .= "📋 *Tareas post-salida:*\n";
    $message .= "🧹 Programar limpieza\n";
    $message .= "🔍 Inspección de habitación\n";
    $message .= "📸 Reporte de estado\n\n";
    $message .= "🆔 *ID:* {$reservation['id']}";
    
    return $message;
}

function generateDailySummaryMessage($stats) {
    $today = date('d/M/Y');
    
    $message = "📊 *RESUMEN DIARIO*\n";
    $message .= "📅 {$today}\n\n";
    $message .= "🎉 *Nuevas reservas:* {$stats['new_reservations']}\n";
    $message .= "💰 *Ingresos generados:* $" . number_format($stats['total_revenue'], 2) . " MXN\n";
    $message .= "👥 *Check-ins hoy:* {$stats['checkins_today']}\n";
    $message .= "🚪 *Check-outs hoy:* {$stats['checkouts_today']}\n";
    
    if ($stats['new_reviews'] > 0) {
        $message .= "⭐ *Reseñas nuevas:* {$stats['new_reviews']}\n";
    }
    
    if ($stats['occupancy_rate'] > 0) {
        $message .= "📈 *Ocupación:* {$stats['occupancy_rate']}%\n";
    }
    
    $message .= "\n🏠 *Casa Xu'unan*";
    
    return $message;
}

function generateOccupancyAlert($occupancy_data) {
    $weekend_dates = $occupancy_data['weekend_dates'];
    $occupancy_rate = $occupancy_data['occupancy_rate'];
    $available_rooms = $occupancy_data['available_rooms'];
    $potential_revenue = $occupancy_data['potential_revenue'];
    
    $message = "📈 *ALERTA DE OCUPACIÓN*\n\n";
    $message .= "📅 *Fin de semana:* {$weekend_dates}\n";
    $message .= "🏠 *Ocupación:* {$occupancy_rate}% ({$occupancy_data['occupied_rooms']}/{$occupancy_data['total_rooms']} habitaciones)\n\n";
    
    if ($available_rooms > 0) {
        $message .= "💡 *Oportunidad:*\n";
        $message .= "🔓 Habitaciones disponibles: {$available_rooms}\n";
        $message .= "💰 Ingresos potenciales: $" . number_format($potential_revenue, 2) . "\n";
    } else {
        $message .= "🎉 *¡COMPLETAMENTE OCUPADO!*\n";
        $message .= "✅ Todas las habitaciones reservadas\n";
    }
    
    return $message;
}

function generateProblemAlert($problem_data) {
    $message = "⚠️ *PROBLEMA DETECTADO*\n\n";
    $message .= "👤 *Huésped:* {$problem_data['guest_name']}\n";
    $message .= "🏠 *Habitación:* {$problem_data['property_name']}\n";
    $message .= "🚨 *Tipo:* {$problem_data['problem_type']}\n";
    
    if (isset($problem_data['expected_time'])) {
        $message .= "📅 *Programado:* {$problem_data['expected_time']}\n";
    }
    
    $message .= "⏰ *Detectado:* " . date('d/M/Y H:i') . "\n\n";
    $message .= "🔍 *Requiere atención inmediata*\n";
    $message .= "🆔 *ID:* {$problem_data['reservation_id']}";
    
    return $message;
}

// ===== FUNCIONES AUXILIARES =====

function formatChange($change) {
    switch ($change['type']) {
        case 'check_in_date':
            return "📅 Check-in: {$change['old_value']} → {$change['new_value']}";
        case 'check_out_date':
            return "📅 Check-out: {$change['old_value']} → {$change['new_value']}";
        case 'guest_count':
            return "👥 Huéspedes: {$change['old_value']} → {$change['new_value']}";
        case 'total_amount':
            return "💰 Total: $" . number_format($change['old_value'], 2) . " → $" . number_format($change['new_value'], 2);
        default:
            return "{$change['field']}: {$change['old_value']} → {$change['new_value']}";
    }
}

function getMessageTemplate($template_name, $variables = []) {
    $templates = [
        'welcome' => "¡Bienvenido a Casa Xu'unan! Tu reserva está confirmada.",
        'reminder_checkin' => "Recordatorio: Tu check-in es mañana a las {{time}}",
        'thank_you' => "Gracias por tu estadía en Casa Xu'unan. ¡Esperamos verte pronto!"
    ];
    
    if (!isset($templates[$template_name])) {
        return null;
    }
    
    $message = $templates[$template_name];
    
    // Reemplazar variables
    foreach ($variables as $key => $value) {
        $message = str_replace('{{' . $key . '}}', $value, $message);
    }
    
    return $message;
}

// Función para personalizar mensajes según el contacto
function customizeMessageForContact($message, $contact_type) {
    switch ($contact_type) {
        case 'limpieza':
            // Agregar información específica para limpieza
            if (strpos($message, 'CHECK-IN') !== false || strpos($message, 'CHECK-OUT') !== false) {
                $message .= "\n\n🧹 *Acción requerida para limpieza*";
            }
            break;
            
        case 'recepcion':
            // Agregar información específica para recepción
            if (strpos($message, 'MENSAJE') !== false) {
                $message .= "\n\n📞 *Responder al huésped*";
            }
            break;
            
        case 'manager':
            // Mantener mensaje completo para manager
            break;
    }
    
    return $message;
}

?>