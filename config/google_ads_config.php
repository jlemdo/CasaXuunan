<?php
/**
 * Google Ads Conversion Tracking Config
 * Para Casa Xu'unan
 */

return [
    // Conversion ID de Google Ads (ya instalado en header.php)
    'conversion_id' => 'AW-18041631980',

    // Acciones de conversion (label code)
    'conversions' => [
        'reserva_confirmada' => [
            'label' => 'iN5dCO6stpwcEOzp9ZpD',
            'default_value' => 2500.0,
            'currency' => 'MXN',
        ],
        'whatsapp_click' => [
            'label' => '6AUyCN_D3pMcEOzp9ZpD',
            'default_value' => 1400.0,
            'currency' => 'MXN',
        ],
    ],

    // Cookie donde guardamos el GCLID al llegar de Google Ads
    'gclid_cookie' => 'cx_gclid',
    'gclid_cookie_days' => 90,
];
