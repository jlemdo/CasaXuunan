<?php
/**
 * Rate Limiter Simple para proteger endpoints
 * @version 1.0
 */

class RateLimiter {
    private $storageDir;
    private $maxRequests;
    private $timeWindow;

    /**
     * Constructor
     * @param string $storageDir Directorio para almacenar datos de rate limiting
     * @param int $maxRequests Número máximo de requests permitidos
     * @param int $timeWindow Ventana de tiempo en segundos
     */
    public function __construct($storageDir = null, $maxRequests = 60, $timeWindow = 60) {
        $this->storageDir = $storageDir ?: __DIR__ . '/../cache/rate_limit';
        $this->maxRequests = $maxRequests;
        $this->timeWindow = $timeWindow;

        // Crear directorio si no existe
        if (!is_dir($this->storageDir)) {
            mkdir($this->storageDir, 0755, true);
        }
    }

    /**
     * Verificar si un cliente puede hacer una request
     * @param string $identifier Identificador único (IP, user ID, etc)
     * @return array ['allowed' => bool, 'remaining' => int, 'reset' => timestamp]
     */
    public function check($identifier) {
        $filename = $this->getFilename($identifier);
        $now = time();

        // Leer datos existentes
        $data = $this->readData($filename);

        // Si no hay datos o expiró la ventana, crear nueva ventana
        if (empty($data) || ($now - $data['start']) > $this->timeWindow) {
            $data = [
                'start' => $now,
                'count' => 0,
                'requests' => []
            ];
        }

        // Limpiar requests antiguos
        $data['requests'] = array_filter($data['requests'], function($timestamp) use ($now) {
            return ($now - $timestamp) <= $this->timeWindow;
        });

        $data['count'] = count($data['requests']);

        // Verificar límite
        $allowed = $data['count'] < $this->maxRequests;

        if ($allowed) {
            // Registrar nueva request
            $data['requests'][] = $now;
            $data['count']++;
        }

        // Guardar datos
        $this->writeData($filename, $data);

        return [
            'allowed' => $allowed,
            'remaining' => max(0, $this->maxRequests - $data['count']),
            'reset' => $data['start'] + $this->timeWindow,
            'limit' => $this->maxRequests
        ];
    }

    /**
     * Resetear límite para un identificador
     * @param string $identifier Identificador único
     * @return bool True si se resetea exitosamente
     */
    public function reset($identifier) {
        $filename = $this->getFilename($identifier);
        if (file_exists($filename)) {
            return unlink($filename);
        }
        return true;
    }

    /**
     * Limpiar datos antiguos
     * @return int Número de archivos eliminados
     */
    public function cleanup() {
        $deleted = 0;
        $files = glob($this->storageDir . '/*.limit');
        $now = time();

        foreach ($files as $file) {
            $data = $this->readData($file);
            if (empty($data) || ($now - $data['start']) > ($this->timeWindow * 2)) {
                unlink($file);
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Obtener nombre de archivo para un identificador
     */
    private function getFilename($identifier) {
        return $this->storageDir . '/' . md5($identifier) . '.limit';
    }

    /**
     * Leer datos de archivo
     */
    private function readData($filename) {
        if (!file_exists($filename)) {
            return [];
        }

        $content = file_get_contents($filename);
        return json_decode($content, true) ?: [];
    }

    /**
     * Escribir datos a archivo
     */
    private function writeData($filename, $data) {
        return file_put_contents($filename, json_encode($data), LOCK_EX) !== false;
    }
}
