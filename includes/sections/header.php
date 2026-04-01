<!DOCTYPE html>
<html lang="<?php echo getCurrentLanguage(); ?>">

<head>
    <meta charset="utf-8">

    <!-- Google Ads Conversion Tracking -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18041631980"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-18041631980');
    </script>
    <title><?php echo t('meta_title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Descripción y palabras clave para SEO -->
    <meta name="description" content="<?php echo t('meta_description'); ?>">
    <meta name="keywords" content="<?php echo t('meta_keywords'); ?>">
    <meta name="author" content="Casa Xu'unan">

    <!-- Alternate language tags for SEO -->
    <link rel="alternate" hreflang="es" href="https://casaxuunan.com/?lang=es">
    <link rel="alternate" hreflang="en" href="https://casaxuunan.com/?lang=en">
    <link rel="alternate" hreflang="x-default" href="https://casaxuunan.com/">
    <link rel="icon" href="images/logo/logo.ico" type="image/x-icon" sizes="16x16">

    <!-- Open Graph para Facebook y WhatsApp -->
    <meta property="og:title" content="Casa Xu'unan - Bed & Breakfast Familiar en Valladolid, Yucatán">
    <meta property="og:description" content="Hospedaje familiar con desayuno incluido en Valladolid. Ambiente hogareño y acogedor en una casa tradicional con 9 habitaciones cómodas. Perfecto para explorar cenotes y Chichén Itzá.">
    <meta property="og:image" content="https://casaxuunan.com/images/gallery/gallery-item-3.jpg">
    <meta property="og:url" content="https://casaxuunan.com/">
    <meta property="og:type" content="hotel">
    <meta property="og:locale" content="es_MX">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:site_name" content="Casa Xu'unan Bed & Breakfast">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Casa Xu'unan - Bed & Breakfast Familiar en Valladolid">
    <meta name="twitter:description" content="Hospedaje familiar con desayuno incluido. 9 habitaciones en ambiente hogareño, cerca de cenotes y Chichén Itzá.">
    <meta name="twitter:image" content="https://casaxuunan.com/images/gallery/gallery-item-3.jpg">
    <meta name="twitter:site" content="@CasaXuunan">
    <meta name="twitter:creator" content="@CasaXuunan">

    <!-- Metaetiquetas adicionales -->
    <link rel="canonical" href="https://casaxuunan.com/">
    <meta name="robots" content="index, follow">

    <!-- Preload Critical Resources -->
    <link rel="preload" href="css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" id="bootstrap">
    <link rel="stylesheet" href="css/plugins.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/color.css" type="text/css">

    <!-- Supersized -->
    <link rel='stylesheet' href='js/supersized/css/supersized.css' type='text/css'>
    <link rel='stylesheet' href='js/supersized/theme/supersized.shutter.css' type='text/css'>

    <!-- Color scheme -->
    <link rel="stylesheet" href="css/colors/xuunan.css" type="text/css" id="colors">
    
    <!-- Custom styles for services -->
    <link rel="stylesheet" href="css/masajes-custom.css" type="text/css">
    
    <!-- Responsive styles for services pages -->
    <link rel="stylesheet" href="css/services-responsive.css" type="text/css">

    <!-- Language Switcher Styles -->
    <link rel="stylesheet" href="css/language-switcher.css" type="text/css">

    <!-- WhatsApp Floating Button (todas las paginas) -->
    <link rel="stylesheet" href="css/whatsapp-float.css" type="text/css">

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'index.php'): ?>
    <!-- Reviews Section Styles (solo para index) -->
    <link rel="stylesheet" href="css/reviews-section.css" type="text/css">
    <!-- Elfsight Platform Script -->
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <?php endif; ?>

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'contact.php'): ?>
    <!-- Contact Form Styles (solo para contact) -->
    <link rel="stylesheet" href="css/contact-alerts.css" type="text/css">
    <link rel="stylesheet" href="css/contact-page.css" type="text/css">
    <?php endif; ?>

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'room.php'): ?>
    <!-- Room Single Mobile UX -->
    <link rel="stylesheet" href="css/room-mobile.css" type="text/css">
    <?php endif; ?>

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'search.php' || basename($_SERVER['SCRIPT_NAME']) === 'index.php'): ?>
    <!-- Hospitable Property Search Widget -->
    <script src="https://hospitable.b-cdn.net/direct-property-search-widget/hospitable-search-widget.prod.js" defer></script>
    <link rel="stylesheet" href="css/search-page.css" type="text/css">
    <?php endif; ?>

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'search.php'): ?>
    <!-- Search page fixes:
         1. position:relative so body grows with content (enables scroll)
         2. overflow-x:hidden at every level to clip the widget's 100vw trick
         3. padding on widget container so results don't touch viewport edges -->
    <style>
        html { overflow-x: hidden !important; }
        body { overflow-x: hidden !important; }
        #content-absolute {
            position: relative !important;
            overflow-x: hidden;
        }
        .search-widget-fullwidth {
            padding: 0 15px;
            box-sizing: border-box;
        }
    </style>
    <?php endif; ?>

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'garden.php' || basename($_SERVER['SCRIPT_NAME']) === 'plant.php'): ?>
    <!-- Garden Styles -->
    <link rel="stylesheet" href="css/garden.css" type="text/css">
    <?php endif; ?>

    <!-- Schema.org Structured Data para Bed and Breakfast -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BedAndBreakfast",
      "name": "Casa Xu'unan",
      "image": [
        "https://casaxuunan.com/images/gallery/gallery-item-1.jpg",
        "https://casaxuunan.com/images/gallery/gallery-item-2.jpg",
        "https://casaxuunan.com/images/gallery/gallery-item-3.jpg"
      ],
      "description": "Bed and Breakfast familiar en el corazón de Valladolid, Yucatán. 9 habitaciones limpias y cómodas con ambiente hogareño, desayuno incluido.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Valladolid Centro",
        "addressLocality": "Valladolid",
        "addressRegion": "Yucatán",
        "postalCode": "97780",
        "addressCountry": "MX"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 20.6896,
        "longitude": -88.2019
      },
      "url": "https://casaxuunan.com",
      "telephone": "+52-985-258-0599",
      "priceRange": "$$",
      "amenityFeature": [
        {
          "@type": "LocationFeatureSpecification",
          "name": "Desayuno incluido",
          "value": true
        },
        {
          "@type": "LocationFeatureSpecification",
          "name": "WiFi gratuito",
          "value": true
        },
        {
          "@type": "LocationFeatureSpecification",
          "name": "Ambiente familiar",
          "value": true
        }
      ],
      "numberOfRooms": 9,
      "starRating": {
        "@type": "Rating",
        "ratingValue": "4.8"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "reviewCount": "50"
      },
      "servesCuisine": "Desayuno mexicano tradicional",
      "acceptsReservations": "https://casaxuunan.com/rooms.php",
      "checkinTime": "15:00",
      "checkoutTime": "11:00"
    }
    </script>
</head>