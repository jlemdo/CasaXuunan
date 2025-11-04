# 🏨 Casa Xuunan - Integración con Hospitable API v2

## 📋 Descripción

Sistema completo de integración con Hospitable API v2 para gestión de propiedades, reservas y webhooks con características profesionales de caché, rate limiting y logging.

## ✅ Estado de la Integración

**✅ API v2 Completamente Implementada**

- Base URL: `https://public.api.hospitable.com/v2/`
- Autenticación: Bearer JWT Token (Personal Access Token)
- Token válido hasta: 29 de Marzo de 2026

## 🎯 Características

### A. Sistema de Caché (✅ Implementado)
- **Caché de 5 minutos** para reducir llamadas a la API
- Sistema de archivos con expiración automática
- Headers `X-Cache: HIT/MISS` para debugging
- Limpieza automática de caché expirado

### B. Rate Limiting (✅ Implementado)
- **30 requests por minuto** por IP
- Headers estándar de rate limit: `X-RateLimit-Limit`, `X-RateLimit-Remaining`, `X-RateLimit-Reset`
- Protección contra abuso de webhooks
- Almacenamiento en archivos JSON

### C. Sistema de Logging (✅ Implementado)
- Logs estructurados con niveles (DEBUG, INFO, WARNING, ERROR, CRITICAL)
- Rotación automática de logs > 10MB
- Logs separados por tipo: API, Webhooks, WhatsApp
- Formato JSON para fácil parsing

### D. Seguridad (✅ Mejorado)
- Validación de tokens de webhook
- Rate limiting por IP
- SSL verificado en todas las conexiones
- Variables de entorno para credenciales
- .gitignore configurado

## 📁 Estructura de Archivos

```
Beta/
├── api_proxy_secure.php          # Proxy seguro con caché
├── webhook_receiver.php           # Receptor de webhooks con rate limiting
├── test_api.php                   # Script de diagnóstico mejorado
├── config/
│   ├── cache.php                  # Sistema de caché
│   ├── rate_limiter.php           # Rate limiting
│   ├── logger.php                 # Sistema de logging
│   └── hospitable_api.php         # Cliente API completo
├── admin/
│   └── clear_cache.php            # Panel de administración de caché
├── cache/                         # Archivos de caché (auto-generado)
├── logs/                          # Archivos de log (auto-generado)
├── .env                           # Variables de entorno
└── .gitignore                     # Archivos ignorados por Git
```

## 🔌 Endpoints Disponibles

### Propiedades
```php
GET /v2/properties                          # Listar propiedades
GET /v2/properties/{id}                     # Obtener propiedad
GET /v2/properties/{id}/images              # Imágenes de propiedad
GET /v2/properties/{id}/calendar            # Calendario con disponibilidad
PATCH /v2/properties/{id}/calendar          # Actualizar calendario
```

### Reservas (Nuevo en v2)
```php
GET /v2/reservations                        # Listar reservas
GET /v2/reservations/{id}                   # Obtener reserva específica
```

### Webhooks
```php
POST /webhook_receiver.php                  # Recibir eventos de Hospitable
```

## 🚀 Uso del Cliente API

### Ejemplo Básico

```php
<?php
require_once 'config/hospitable_api.php';
require_once 'config/cache.php';
require_once 'config/logger.php';

// Cargar .env
require_once 'api_proxy_secure.php'; // Usa la función loadEnv()

// Inicializar
$cache = new SimpleCache(__DIR__ . '/cache', 300);
$logger = new Logger('api.log', 'INFO');
$api = new HospitableAPI($_ENV['HOSPITABLE_API_KEY'], $cache, $logger);

// Obtener propiedades
try {
    $properties = $api->getProperties();
    echo "Propiedades encontradas: " . count($properties['data']) . "\n";

    foreach ($properties['data'] as $property) {
        echo "- {$property['name']}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Obtener reservas (Nuevo)
try {
    $reservations = $api->getReservations([
        'check_in_from' => '2025-01-01',
        'check_in_to' => '2025-12-31'
    ]);

    echo "Reservas encontradas: " . count($reservations['data']) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```

### Limpiar Caché desde Código

```php
<?php
require_once 'config/cache.php';

$cache = new SimpleCache(__DIR__ . '/cache');

// Limpiar todo el caché
$deleted = $cache->clear();
echo "Se eliminaron {$deleted} archivos\n";

// Limpiar solo caché expirado
$deleted = $cache->cleanup();
echo "Se limpiaron {$deleted} archivos expirados\n";
?>
```

## 🛠️ Administración

### Panel de Administración de Caché

Accede a: `https://tu-dominio.com/admin/clear_cache.php?password=xuunan2024`

**⚠️ IMPORTANTE:** Cambia la contraseña en producción editando `admin/clear_cache.php`

Funciones disponibles:
- Ver estadísticas de caché
- Limpiar todo el caché
- Limpiar solo caché expirado
- Limpiar rate limiting
- Ver tamaño de archivos

### Diagnóstico de API

Ejecuta el script de diagnóstico:

```bash
# Desde navegador
https://tu-dominio.com/test_api.php

# Desde CLI
php test_api.php
```

Verifica:
- ✅ Archivo .env existe
- ✅ API Key configurada
- ✅ cURL habilitado
- ✅ Conexión a Hospitable API
- ✅ Propiedades cargadas

## 📊 Monitoreo

### Ver Logs

```bash
# Logs de API
tail -f logs/api_errors.log

# Logs de Webhooks
tail -f logs/webhook_debug.log

# Logs de WhatsApp
tail -f logs/whatsapp_send.log
```

### Verificar Caché

```bash
# Archivos en caché
ls -lh cache/*.cache

# Rate limiting
ls -lh cache/rate_limit/*.limit
```

## 🔐 Seguridad

### Variables de Entorno

Nunca subas el archivo `.env` a Git. Las credenciales incluyen:

```env
HOSPITABLE_API_KEY=tu_token_jwt_aqui
WHATSAPP_ACCESS_TOKEN=tu_token_whatsapp
WHATSAPP_PHONE_ID=tu_phone_id
MANAGER_PHONE=525647851365
```

### Rate Limiting

Por defecto: **30 requests/minuto por IP**

Puedes ajustarlo en `webhook_receiver.php`:

```php
$rateLimiter = new RateLimiter(__DIR__ . '/cache/rate_limit', 60, 60); // 60 req/min
```

### Caché TTL

Por defecto: **5 minutos (300 segundos)**

Puedes ajustarlo en `api_proxy_secure.php`:

```php
$cache = new SimpleCache(__DIR__ . '/cache', 600); // 10 minutos
```

## 🐛 Solución de Problemas

### Error: "API Key no configurada"
- Verifica que `.env` existe en la raíz
- Verifica que `HOSPITABLE_API_KEY` está presente
- Ejecuta `test_api.php` para diagnosticar

### Error: "cURL no habilitado"
- Instala/habilita extensión PHP cURL
- En Ubuntu: `sudo apt-get install php-curl`
- Reinicia servidor web

### Caché no funciona
- Verifica permisos de carpeta `cache/`
- Debe ser escribible por el servidor web
- `chmod 755 cache/`

### Rate limiting muy estricto
- Ajusta límite en `webhook_receiver.php`
- O limpia rate limiting: `admin/clear_cache.php`

## 📈 Mejoras Futuras

- [ ] Dashboard de analytics
- [ ] Notificaciones por email
- [ ] Integración con Google Calendar
- [ ] Sistema de backup automático
- [ ] API de reportes personalizados

## 📝 Changelog

### v2.0 (2025-01-04)
- ✅ Actualización completa a Hospitable API v2
- ✅ Sistema de caché implementado
- ✅ Rate limiting agregado
- ✅ Sistema de logging mejorado
- ✅ Cliente API completo con todos los endpoints
- ✅ Panel de administración de caché
- ✅ Corrección de warnings en test_api.php
- ✅ Documentación completa

### v1.0
- Integración inicial con Hospitable API v2
- Webhooks para reservas
- Notificaciones por WhatsApp

## 👨‍💻 Soporte

Para problemas o preguntas:
1. Revisa los logs en `logs/`
2. Ejecuta `test_api.php` para diagnosticar
3. Verifica la documentación oficial: https://developer.hospitable.com

---

**Casa Xuunan** - Sistema Profesional de Gestión Hotelera
