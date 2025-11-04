<?php
/**
 * Sistema de Logging Mejorado
 * @version 1.0
 */

class Logger {
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const ERROR = 'ERROR';
    const CRITICAL = 'CRITICAL';

    private $logDir;
    private $logFile;
    private $minLevel;

    private $levels = [
        'DEBUG' => 0,
        'INFO' => 1,
        'WARNING' => 2,
        'ERROR' => 3,
        'CRITICAL' => 4
    ];

    /**
     * Constructor
     * @param string $logFile Nombre del archivo de log
     * @param string $minLevel Nivel mínimo de log
     */
    public function __construct($logFile = 'app.log', $minLevel = 'INFO') {
        $this->logDir = __DIR__ . '/../logs';
        $this->logFile = $logFile;
        $this->minLevel = $minLevel;

        // Crear directorio si no existe
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0755, true);
        }
    }

    /**
     * Log genérico
     */
    public function log($level, $message, $context = []) {
        // Verificar nivel
        if ($this->levels[$level] < $this->levels[$this->minLevel]) {
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';

        $logEntry = sprintf(
            "[%s] [%s] %s%s\n",
            $timestamp,
            $level,
            $message,
            $contextStr
        );

        $logPath = $this->logDir . '/' . $this->logFile;
        file_put_contents($logPath, $logEntry, FILE_APPEND | LOCK_EX);

        // Rotar logs si es muy grande (> 10MB)
        $this->rotateLogs($logPath);
    }

    /**
     * Métodos de conveniencia
     */
    public function debug($message, $context = []) {
        $this->log(self::DEBUG, $message, $context);
    }

    public function info($message, $context = []) {
        $this->log(self::INFO, $message, $context);
    }

    public function warning($message, $context = []) {
        $this->log(self::WARNING, $message, $context);
    }

    public function error($message, $context = []) {
        $this->log(self::ERROR, $message, $context);
    }

    public function critical($message, $context = []) {
        $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Rotar logs si exceden 10MB
     */
    private function rotateLogs($logPath) {
        if (file_exists($logPath) && filesize($logPath) > 10 * 1024 * 1024) {
            $backupPath = $logPath . '.' . date('Y-m-d_His') . '.bak';
            rename($logPath, $backupPath);

            // Mantener solo los últimos 5 backups
            $this->cleanupOldBackups();
        }
    }

    /**
     * Limpiar backups antiguos
     */
    private function cleanupOldBackups() {
        $pattern = $this->logDir . '/' . $this->logFile . '.*.bak';
        $backups = glob($pattern);

        if (count($backups) > 5) {
            // Ordenar por fecha (más antiguos primero)
            usort($backups, function($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            // Eliminar los más antiguos
            $toDelete = array_slice($backups, 0, count($backups) - 5);
            foreach ($toDelete as $file) {
                unlink($file);
            }
        }
    }
}
