<?php
// whatsapp_admin.php - Panel de administración simple para WhatsApp
// ESTADO: DESACTIVADO - Para uso futuro

// ===== BLOQUEO DE ACCESO TEMPORAL =====
$admin_active = false; // Cambiar a true para activar

if (!$admin_active) {
    http_response_code(503);
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <title>Panel WhatsApp - Temporalmente desactivado</title>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial; text-align: center; margin-top: 100px; }
            .container { max-width: 500px; margin: 0 auto; padding: 20px; }
            .status { background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="status">
                <h2>🔧 Panel de Administración WhatsApp</h2>
                <p><strong>Estado:</strong> Temporalmente desactivado</p>
                <p>Este panel se activará cuando el sistema WhatsApp esté completamente configurado.</p>
                <hr>
                <small>Para activar: Cambiar <code>$admin_active = true</code> en whatsapp_admin.php</small>
            </div>
        </div>
    </body>
    </html>
    ');
}

// ===== CÓDIGO DEL PANEL (Solo se ejecuta si está activado) =====

require_once 'whatsapp_config_secure.php';
require_once 'whatsapp_sender.php';
require_once 'message_templates.php';

// Procesar acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'test_connection':
            $phone = $_POST['test_phone'] ?? '';
            if ($phone) {
                $result = testWhatsAppConnection($phone);
                $test_result = $result;
            }
            break;
            
        case 'send_daily_summary':
            $result = sendDailySummary();
            $summary_result = $result;
            break;
            
        case 'update_contact':
            $contact_type = $_POST['contact_type'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $name = $_POST['name'] ?? '';
            
            if ($contact_type && $phone) {
                // Actualizar configuración (en producción usar base de datos)
                $update_result = "Contacto {$contact_type} actualizado: {$name} - {$phone}";
            }
            break;
    }
}

// Obtener estadísticas
$stats = getWhatsAppStats(7);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Admin - Casa Xu'unan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin-header {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            padding: 20px 0;
        }
        .stat-card {
            border-left: 4px solid #25D366;
            background: #f8f9fa;
        }
        .btn-whatsapp {
            background-color: #25D366;
            border-color: #25D366;
            color: white;
        }
        .btn-whatsapp:hover {
            background-color: #128C7E;
            border-color: #128C7E;
            color: white;
        }
        .status-sent { color: #28a745; }
        .status-failed { color: #dc3545; }
        .status-pending { color: #ffc107; }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="container">
            <h1><i class="fab fa-whatsapp"></i> WhatsApp Admin</h1>
            <p>Sistema de notificaciones - Casa Xu'unan</p>
        </div>
    </div>

    <div class="container mt-4">
        
        <?php if (isset($test_result)): ?>
        <div class="alert alert-<?= $test_result['success'] ? 'success' : 'danger' ?>">
            <strong>Prueba de conexión:</strong> <?= htmlspecialchars($test_result['message']) ?>
            <?php if ($test_result['success']): ?>
                <br><small>Enviado a: <?= htmlspecialchars($test_result['phone']) ?></small>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($summary_result)): ?>
        <div class="alert alert-<?= $summary_result['success'] ? 'success' : 'danger' ?>">
            <strong>Resumen diario:</strong> <?= htmlspecialchars($summary_result['message']) ?>
        </div>
        <?php endif; ?>

        <?php if (isset($update_result)): ?>
        <div class="alert alert-success">
            <strong>Actualización:</strong> <?= htmlspecialchars($update_result) ?>
        </div>
        <?php endif; ?>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>📊 Estadísticas (últimos 7 días)</h3>
            </div>
            
            <?php if ($stats): ?>
                <?php 
                $total_sent = 0;
                $total_failed = 0;
                foreach ($stats as $stat) {
                    if ($stat['status'] === 'sent') $total_sent += $stat['count'];
                    if ($stat['status'] === 'failed') $total_failed += $stat['count'];
                }
                ?>
                
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title text-success">✅ Enviados</h5>
                            <h2 class="text-success"><?= $total_sent ?></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title text-danger">❌ Fallidos</h5>
                            <h2 class="text-danger"><?= $total_failed ?></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title text-info">📱 Total</h5>
                            <h2 class="text-info"><?= $total_sent + $total_failed ?></h2>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No hay estadísticas disponibles aún.</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Configuración -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>🔧 Configuración de Contactos</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($notification_contacts as $key => $contact): ?>
                        <form method="POST" class="mb-3">
                            <input type="hidden" name="action" value="update_contact">
                            <input type="hidden" name="contact_type" value="<?= $key ?>">
                            
                            <div class="form-group">
                                <label><strong><?= ucfirst($key) ?></strong></label>
                                <input type="text" name="name" class="form-control" 
                                       value="<?= htmlspecialchars($contact['name']) ?>" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" class="form-control" 
                                       value="<?= htmlspecialchars($contact['phone']) ?>" placeholder="Teléfono">
                            </div>
                            <button type="submit" class="btn btn-sm btn-outline-primary">Actualizar</button>
                        </form>
                        <hr>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>🧪 Pruebas y Acciones</h5>
                    </div>
                    <div class="card-body">
                        <!-- Prueba de conexión -->
                        <form method="POST" class="mb-4">
                            <input type="hidden" name="action" value="test_connection">
                            <div class="form-group">
                                <label>Probar conexión WhatsApp</label>
                                <input type="tel" name="test_phone" class="form-control" 
                                       placeholder="5219999999999" required>
                                <small class="form-text text-muted">
                                    Formato: 521 + 10 dígitos (ej: 5219999999999)
                                </small>
                            </div>
                            <button type="submit" class="btn btn-whatsapp">
                                📱 Enviar Prueba
                            </button>
                        </form>

                        <!-- Enviar resumen -->
                        <form method="POST" class="mb-4">
                            <input type="hidden" name="action" value="send_daily_summary">
                            <button type="submit" class="btn btn-outline-info">
                                📊 Enviar Resumen Diario
                            </button>
                        </form>

                        <!-- Estado del sistema -->
                        <div class="alert alert-info">
                            <strong>🔗 URL del Webhook:</strong><br>
                            <code><?= "https://" . $_SERVER['HTTP_HOST'] . "/webhook_receiver.php" ?></code>
                            <br><br>
                            <strong>🔑 Token de verificación:</strong><br>
                            <code><?= htmlspecialchars($whatsapp_config['webhook_verify_token']) ?></code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Eventos configurados -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>⚙️ Eventos Configurados</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Estado</th>
                                        <th>Prioridad</th>
                                        <th>Contactos</th>
                                        <th>Horario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($event_config as $event => $config): ?>
                                    <tr>
                                        <td><code><?= htmlspecialchars($event) ?></code></td>
                                        <td>
                                            <span class="badge badge-<?= $config['active'] ? 'success' : 'secondary' ?>">
                                                <?= $config['active'] ? 'Activo' : 'Inactivo' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= 
                                                $config['priority'] === 'critical' ? 'danger' : 
                                                ($config['priority'] === 'high' ? 'warning' : 'info') 
                                            ?>">
                                                <?= ucfirst($config['priority']) ?>
                                            </span>
                                        </td>
                                        <td><?= implode(', ', $config['contacts']) ?></td>
                                        <td>
                                            <?= $config['time_restriction'] ? 
                                                $notification_hours['start'] . '-' . $notification_hours['end'] : 
                                                '24/7' ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Log reciente -->
        <?php if ($stats): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>📝 Resumen por Evento</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tipo de Evento</th>
                                        <th>Estado</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stats as $stat): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($stat['event_type']) ?></td>
                                        <td>
                                            <span class="status-<?= $stat['status'] ?>">
                                                <?= ucfirst($stat['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= $stat['count'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <footer class="mt-5 py-4 bg-light text-center">
        <small class="text-muted">
            WhatsApp Admin Panel - Casa Xu'unan | 
            Configurado para <?= count($notification_contacts) ?> contactos | 
            <?= count(array_filter($event_config, function($c) { return $c['active']; })) ?> eventos activos
        </small>
    </footer>

</body>
</html>