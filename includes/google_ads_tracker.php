<?php
/**
 * Google Ads Server-Side Conversion Tracker
 *
 * Cuando llega una reserva via webhook de Hospitable, registra la conversion
 * en un log local. Para que Google Ads la cuente, las conversiones se envian
 * via Enhanced Conversions usando el GCLID capturado al entrar al sitio.
 *
 * Estrategia: Guardamos las conversiones pendientes en cola (queue) y las
 * subimos manualmente o via cron a Google Ads (Offline Conversion Upload).
 *
 * Para subida automatica via API se requiere Developer Token + OAuth.
 * Mientras tanto, este script genera un CSV listo para subir manualmente
 * en Google Ads > Conversiones > Subidas.
 */

class GoogleAdsTracker {

    private $config;
    private $logDir;
    private $queueFile;
    private $csvFile;

    public function __construct() {
        $this->config = require __DIR__ . '/../config/google_ads_config.php';
        $this->logDir = __DIR__ . '/../logs';
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0755, true);
        }
        $this->queueFile = $this->logDir . '/google_ads_conversions.json';
        $this->csvFile = $this->logDir . '/google_ads_conversions_upload.csv';
    }

    /**
     * Registra una conversion para subir a Google Ads
     *
     * @param string $type Tipo: 'reserva_confirmada', 'whatsapp_click'
     * @param array $data Datos de la conversion:
     *   - gclid: string (Google Click ID, requerido para attribution)
     *   - value: float (valor real de la reserva)
     *   - transaction_id: string (ID unico, evita duplicados)
     *   - timestamp: string (ISO 8601, opcional - default ahora)
     *   - email: string (opcional, para Enhanced Conversions)
     *   - phone: string (opcional)
     * @return bool
     */
    public function trackConversion($type, $data) {
        if (!isset($this->config['conversions'][$type])) {
            $this->log("Tipo de conversion desconocido: $type", 'ERROR');
            return false;
        }

        $conv = $this->config['conversions'][$type];

        $entry = [
            'type' => $type,
            'conversion_id' => $this->config['conversion_id'],
            'conversion_label' => $conv['label'],
            'value' => $data['value'] ?? $conv['default_value'],
            'currency' => $conv['currency'],
            'transaction_id' => $data['transaction_id'] ?? uniqid('cx_', true),
            'gclid' => $data['gclid'] ?? null,
            'timestamp' => $data['timestamp'] ?? date('c'),
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
        ];

        // Guardar en queue JSON
        $queue = $this->loadQueue();
        $queue[] = $entry;
        $this->saveQueue($queue);

        // Generar/actualizar CSV listo para subir a Google Ads
        $this->appendToCsv($entry);

        $this->log("Conversion registrada: $type, valor: {$entry['value']} {$entry['currency']}, gclid: " . ($entry['gclid'] ? 'si' : 'no'));

        return true;
    }

    private function loadQueue() {
        if (!file_exists($this->queueFile)) return [];
        $content = file_get_contents($this->queueFile);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    private function saveQueue($queue) {
        file_put_contents($this->queueFile, json_encode($queue, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Genera CSV en formato de Google Ads Offline Conversion Import
     * Headers requeridos por Google Ads:
     * Google Click ID, Conversion Name, Conversion Time, Conversion Value, Conversion Currency
     */
    private function appendToCsv($entry) {
        if (!$entry['gclid']) {
            // Sin GCLID no se puede atribuir offline - se queda solo en queue
            return;
        }

        $headers = ['Google Click ID', 'Conversion Name', 'Conversion Time', 'Conversion Value', 'Conversion Currency'];
        $newFile = !file_exists($this->csvFile);

        $fp = fopen($this->csvFile, 'a');
        if ($newFile) {
            // Google Ads requiere estas dos lineas al inicio del CSV
            fputs($fp, "Parameters:TimeZone=America/Mexico_City\n");
            fputcsv($fp, $headers);
        }

        // Conversion Name = nombre exacto creado en Google Ads
        $names = [
            'reserva_confirmada' => 'Reserva Confirmada',
            'whatsapp_click' => 'WhatsApp Click',
        ];

        // Formato de tiempo requerido por Google: yyyy-mm-dd hh:mm:ss+/-hh:mm
        $time = date('Y-m-d H:i:sP', strtotime($entry['timestamp']));

        fputcsv($fp, [
            $entry['gclid'],
            $names[$entry['type']] ?? $entry['type'],
            $time,
            number_format($entry['value'], 2, '.', ''),
            $entry['currency'],
        ]);
        fclose($fp);
    }

    private function log($message, $level = 'INFO') {
        $logFile = $this->logDir . '/google_ads_tracker.log';
        $line = sprintf("[%s] [%s] %s\n", date('Y-m-d H:i:s'), $level, $message);
        file_put_contents($logFile, $line, FILE_APPEND);
    }
}
