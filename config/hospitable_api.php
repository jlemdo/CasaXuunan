<?php
/**
 * Cliente para Hospitable API v2
 * Proporciona acceso fácil a todos los endpoints de la API
 * @version 2.0
 */

class HospitableAPI {
    private $apiKey;
    private $baseUrl = 'https://public.api.hospitable.com/v2/';
    private $cache;
    private $logger;

    /**
     * Constructor
     * @param string $apiKey API Key de Hospitable
     * @param SimpleCache $cache Sistema de caché (opcional)
     * @param Logger $logger Sistema de logging (opcional)
     */
    public function __construct($apiKey, $cache = null, $logger = null) {
        $this->apiKey = $apiKey;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * Obtener todas las propiedades
     * @return array
     */
    public function getProperties() {
        return $this->request('properties');
    }

    /**
     * Obtener una propiedad específica
     * @param string $propertyId ID de la propiedad
     * @return array
     */
    public function getProperty($propertyId) {
        return $this->request("properties/{$propertyId}");
    }

    /**
     * Obtener imágenes de una propiedad
     * @param string $propertyId ID de la propiedad
     * @return array
     */
    public function getPropertyImages($propertyId) {
        return $this->request("properties/{$propertyId}/images");
    }

    /**
     * Obtener calendario de una propiedad
     * @param string $propertyId ID de la propiedad
     * @param string $startDate Fecha inicio (Y-m-d)
     * @param string $endDate Fecha fin (Y-m-d)
     * @return array
     */
    public function getPropertyCalendar($propertyId, $startDate, $endDate) {
        $endpoint = "properties/{$propertyId}/calendar?start_date={$startDate}&end_date={$endDate}";
        return $this->request($endpoint);
    }

    /**
     * Obtener todas las reservas
     * @param array $filters Filtros opcionales (check_in_from, check_in_to, etc)
     * @return array
     */
    public function getReservations($filters = []) {
        $queryString = !empty($filters) ? '?' . http_build_query($filters) : '';
        return $this->request("reservations{$queryString}");
    }

    /**
     * Obtener una reserva específica
     * @param string $reservationId ID de la reserva
     * @return array
     */
    public function getReservation($reservationId) {
        return $this->request("reservations/{$reservationId}");
    }

    /**
     * Actualizar calendario de una propiedad
     * @param string $propertyId ID de la propiedad
     * @param array $updates Actualizaciones de calendario
     * @return array
     */
    public function updatePropertyCalendar($propertyId, $updates) {
        return $this->request(
            "properties/{$propertyId}/calendar",
            'PATCH',
            $updates
        );
    }

    /**
     * Request genérico a la API
     * @param string $endpoint Endpoint sin base URL
     * @param string $method Método HTTP (GET, POST, PATCH, etc)
     * @param array $data Datos para POST/PATCH
     * @param bool $useCache Usar caché para esta request
     * @return array
     */
    private function request($endpoint, $method = 'GET', $data = null, $useCache = true) {
        // Verificar caché para GET requests
        if ($method === 'GET' && $useCache && $this->cache) {
            $cacheKey = 'hospitable_' . md5($endpoint);
            $cached = $this->cache->get($cacheKey);

            if ($cached !== null) {
                if ($this->logger) {
                    $this->logger->debug("Cache HIT para {$endpoint}");
                }
                return json_decode($cached, true);
            }
        }

        // Hacer request
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init();

        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10
        ]);

        // Configurar método y datos
        if ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Log de errores
        if ($error) {
            if ($this->logger) {
                $this->logger->error("Error cURL en {$endpoint}", [
                    'error' => $error,
                    'method' => $method
                ]);
            }
            throw new Exception("Error en API request: {$error}");
        }

        if ($httpCode >= 400) {
            if ($this->logger) {
                $this->logger->error("Error HTTP {$httpCode} en {$endpoint}", [
                    'response' => substr($response, 0, 500)
                ]);
            }
            throw new Exception("Error HTTP {$httpCode}: " . substr($response, 0, 200));
        }

        // Guardar en caché si fue exitoso
        if ($method === 'GET' && $httpCode === 200 && $this->cache) {
            $this->cache->set($cacheKey, $response);
        }

        if ($this->logger) {
            $this->logger->info("Request exitosa a {$endpoint}", [
                'method' => $method,
                'http_code' => $httpCode
            ]);
        }

        return json_decode($response, true);
    }

    /**
     * Limpiar caché completo
     */
    public function clearCache() {
        if ($this->cache) {
            return $this->cache->clear();
        }
        return 0;
    }
}
