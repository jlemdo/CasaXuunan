<?php
/**
 * Sistema de Caché Simple para API de Hospitable
 * @version 1.0
 */

class SimpleCache {
    private $cacheDir;
    private $defaultTTL;

    /**
     * Constructor
     * @param string $cacheDir Directorio para almacenar cache
     * @param int $defaultTTL Tiempo de vida en segundos (default: 5 minutos)
     */
    public function __construct($cacheDir = null, $defaultTTL = 300) {
        $this->cacheDir = $cacheDir ?: __DIR__ . '/../cache';
        $this->defaultTTL = $defaultTTL;

        // Crear directorio de cache si no existe
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    /**
     * Obtener valor del cache
     * @param string $key Clave del cache
     * @return mixed|null Valor del cache o null si no existe/expiró
     */
    public function get($key) {
        $filename = $this->getCacheFilename($key);

        if (!file_exists($filename)) {
            return null;
        }

        $data = json_decode(file_get_contents($filename), true);

        // Verificar si expiró
        if ($data['expiry'] < time()) {
            unlink($filename);
            return null;
        }

        return $data['value'];
    }

    /**
     * Guardar valor en cache
     * @param string $key Clave del cache
     * @param mixed $value Valor a guardar
     * @param int|null $ttl Tiempo de vida en segundos (opcional)
     * @return bool True si se guardó exitosamente
     */
    public function set($key, $value, $ttl = null) {
        $ttl = $ttl ?: $this->defaultTTL;
        $filename = $this->getCacheFilename($key);

        $data = [
            'value' => $value,
            'expiry' => time() + $ttl,
            'created' => time()
        ];

        return file_put_contents($filename, json_encode($data)) !== false;
    }

    /**
     * Eliminar valor del cache
     * @param string $key Clave del cache
     * @return bool True si se eliminó exitosamente
     */
    public function delete($key) {
        $filename = $this->getCacheFilename($key);

        if (file_exists($filename)) {
            return unlink($filename);
        }

        return false;
    }

    /**
     * Limpiar cache expirado
     * @return int Número de archivos eliminados
     */
    public function cleanup() {
        $deleted = 0;
        $files = glob($this->cacheDir . '/*.cache');

        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);

            if ($data && $data['expiry'] < time()) {
                unlink($file);
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Limpiar todo el cache
     * @return int Número de archivos eliminados
     */
    public function clear() {
        $deleted = 0;
        $files = glob($this->cacheDir . '/*.cache');

        foreach ($files as $file) {
            unlink($file);
            $deleted++;
        }

        return $deleted;
    }

    /**
     * Obtener nombre de archivo para una clave
     * @param string $key Clave
     * @return string Ruta completa del archivo
     */
    private function getCacheFilename($key) {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}
