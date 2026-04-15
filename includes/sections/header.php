<?php
// ===== SEO ENGINE: Dynamic per-page meta tags, canonical, hreflang =====
$_seo_current_page = basename($_SERVER['SCRIPT_NAME'], '.php');
$_seo_page_file = basename($_SERVER['SCRIPT_NAME']);
$_seo_lang = getCurrentLanguage();

// Build canonical URL
$_seo_canonical_path = ($_seo_page_file === 'index.php') ? '' : $_seo_page_file;
// Special case: room.php keeps ?id= param in canonical
if ($_seo_page_file === 'room.php' && isset($_GET['id'])) {
    $_seo_canonical_url = 'https://casaxuunan.com/room.php?id=' . urlencode($_GET['id']);
} elseif ($_seo_page_file === 'blog-post.php' && isset($_GET['slug'])) {
    $_seo_canonical_url = 'https://casaxuunan.com/blog-post.php?slug=' . urlencode($_GET['slug']);
} else {
    $_seo_canonical_url = 'https://casaxuunan.com/' . $_seo_canonical_path;
}

// Special case: blog-post.php gets dynamic title/description from post data
if ($_seo_page_file === 'blog-post.php' && isset($_GET['slug'])) {
    require_once __DIR__ . '/../blog-posts.php';
    $_blog_slug = $_GET['slug'];
    foreach ($blog_posts as $_bp) {
        if ($_bp['slug'] === $_blog_slug || $_bp['slug_en'] === $_blog_slug) {
            $_seo_blog_post_found = $_bp;
            break;
        }
    }
}

// Hreflang base (without lang param)
$_seo_hreflang_base = $_seo_canonical_url;
$_seo_hreflang_sep = (strpos($_seo_hreflang_base, '?') !== false) ? '&' : '?';

// Page-specific SEO keys lookup
$_seo_map = [
    'index'            => ['title' => 'index_meta_title',         'desc' => 'index_meta_description',         'keywords' => 'index_meta_keywords'],
    'rooms'            => ['title' => 'rooms_meta_title',         'desc' => 'rooms_meta_description',         'keywords' => 'rooms_meta_keywords'],
    'room'             => ['title' => 'room_meta_title',          'desc' => 'room_meta_description',          'keywords' => ''],
    'services'         => ['title' => 'services_meta_title',      'desc' => 'services_meta_description',      'keywords' => 'services_meta_keywords'],
    'tours'            => ['title' => 'tours_meta_title',         'desc' => 'tours_meta_description',         'keywords' => 'tours_meta_keywords'],
    'masajes'          => ['title' => 'masajes_meta_title',       'desc' => 'masajes_meta_description',       'keywords' => 'masajes_meta_keywords'],
    'cuidado-personal' => ['title' => 'personal_care_meta_title', 'desc' => 'personal_care_meta_description', 'keywords' => ''],
    'transporte'       => ['title' => 'transport_meta_title',     'desc' => 'transport_meta_description',     'keywords' => 'transport_meta_keywords'],
    'gallery'          => ['title' => 'gallery_meta_title',       'desc' => 'gallery_meta_description',       'keywords' => ''],
    'contact'          => ['title' => 'contact_meta_title',       'desc' => 'contact_meta_description',       'keywords' => ''],
    'about'            => ['title' => 'about_meta_title',         'desc' => 'about_meta_description',         'keywords' => 'about_meta_keywords'],
    'search'           => ['title' => 'search_meta_title',        'desc' => 'search_meta_description',        'keywords' => ''],
    'blog'             => ['title' => 'blog_meta_title',         'desc' => 'blog_meta_description',         'keywords' => 'blog_meta_keywords'],
    'blog-post'        => ['title' => 'blog_meta_title',         'desc' => 'blog_meta_description',         'keywords' => 'blog_meta_keywords'],
];
$_seo_data = $_seo_map[$_seo_current_page] ?? $_seo_map['index'];
$_seo_title = t($_seo_data['title']);
$_seo_description = t($_seo_data['desc']);
$_seo_keywords = !empty($_seo_data['keywords']) ? t($_seo_data['keywords']) : t('index_meta_keywords');

// Override with blog post data if available
if (isset($_seo_blog_post_found)) {
    $_seo_title = ($_seo_lang === 'es') ? $_seo_blog_post_found['title_es'] : $_seo_blog_post_found['title_en'];
    $_seo_description = ($_seo_lang === 'es') ? $_seo_blog_post_found['meta_desc_es'] : $_seo_blog_post_found['meta_desc_en'];
    $_seo_keywords = ($_seo_lang === 'es') ? $_seo_blog_post_found['keywords_es'] : $_seo_blog_post_found['keywords_en'];
}

// OG image per page (blog posts use their own image)
$_seo_og_images = [
    'index'   => 'gallery-item-3.jpg',
    'rooms'   => 'gallery-item-1.jpg',
    'gallery' => 'gallery-item-2.jpg',
    'about'   => 'gallery-item-3.jpg',
    'tours'   => 'gallery-item-1.jpg',
    'blog'    => 'gallery-item-2.jpg',
];
$_seo_og_image = 'https://casaxuunan.com/images/gallery/' . ($_seo_og_images[$_seo_current_page] ?? 'gallery-item-3.jpg');

// Blog posts: use the actual post image for OG/Twitter (not generic)
if (isset($_seo_blog_post_found)) {
    $_blog_img = file_exists($_seo_blog_post_found['image']) ? $_seo_blog_post_found['image'] : $_seo_blog_post_found['fallback_image'];
    $_seo_og_image = 'https://casaxuunan.com/' . $_blog_img;
}

// Blog posts: build correct hreflang URLs with language-specific slugs
// Each language version is its own canonical page
if (isset($_seo_blog_post_found)) {
    $_seo_hreflang_es = 'https://casaxuunan.com/blog-post.php?slug=' . urlencode($_seo_blog_post_found['slug']);
    $_seo_hreflang_en = 'https://casaxuunan.com/blog-post.php?slug=' . urlencode($_seo_blog_post_found['slug_en']);
    $_seo_hreflang_default = $_seo_hreflang_es;
    // Canonical must match current language slug
    if ($_seo_lang === 'en') {
        $_seo_canonical_url = $_seo_hreflang_en;
    } else {
        $_seo_canonical_url = $_seo_hreflang_es;
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_seo_lang; ?>">

<head>
    <meta charset="utf-8">

    <!-- Google Ads Conversion Tracking -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18041631980"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-18041631980');

        // Captura GCLID de Google Ads y lo guarda en cookie 90 dias
        // Necesario para atribuir reservas server-side via webhook
        (function(){
            var params = new URLSearchParams(window.location.search);
            var gclid = params.get('gclid');
            if (gclid) {
                var d = new Date();
                d.setTime(d.getTime() + (90*24*60*60*1000));
                document.cookie = 'cx_gclid=' + encodeURIComponent(gclid) +
                    ';expires=' + d.toUTCString() +
                    ';path=/;SameSite=Lax';
            }
        })();
    </script>
    <title><?php echo $_seo_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags (dynamic per page) -->
    <meta name="description" content="<?php echo $_seo_description; ?>">
    <meta name="keywords" content="<?php echo $_seo_keywords; ?>">
    <meta name="author" content="Casa Xu'unan">

    <!-- Hreflang: per-page language alternates -->
    <?php if (isset($_seo_hreflang_es)): ?>
    <link rel="alternate" hreflang="es" href="<?php echo $_seo_hreflang_es; ?>">
    <link rel="alternate" hreflang="en" href="<?php echo $_seo_hreflang_en; ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo $_seo_hreflang_default; ?>">
    <?php else: ?>
    <link rel="alternate" hreflang="es" href="<?php echo $_seo_hreflang_base . $_seo_hreflang_sep; ?>lang=es">
    <link rel="alternate" hreflang="en" href="<?php echo $_seo_hreflang_base . $_seo_hreflang_sep; ?>lang=en">
    <link rel="alternate" hreflang="x-default" href="<?php echo $_seo_hreflang_base; ?>">
    <?php endif; ?>
    <link rel="icon" href="images/logo/logo.ico" type="image/x-icon" sizes="16x16">

    <!-- Open Graph (dynamic per page) -->
    <meta property="og:title" content="<?php echo $_seo_title; ?>">
    <meta property="og:description" content="<?php echo $_seo_description; ?>">
    <meta property="og:image" content="<?php echo $_seo_og_image; ?>">
    <meta property="og:url" content="<?php echo $_seo_canonical_url; ?>">
    <meta property="og:type" content="<?php echo (isset($_seo_blog_post_found)) ? 'article' : 'website'; ?>">
    <?php if (isset($_seo_blog_post_found)): ?>
    <meta property="article:published_time" content="<?php echo $_seo_blog_post_found['date']; ?>">
    <meta property="article:author" content="Casa Xu'unan">
    <meta property="article:section" content="<?php echo ($_seo_lang === 'es') ? $_seo_blog_post_found['category_es'] : $_seo_blog_post_found['category_en']; ?>">
    <?php endif; ?>
    <meta property="og:locale" content="<?php echo ($_seo_lang === 'es') ? 'es_MX' : 'en_US'; ?>">
    <meta property="og:locale:alternate" content="<?php echo ($_seo_lang === 'es') ? 'en_US' : 'es_MX'; ?>">
    <meta property="og:site_name" content="Casa Xu'unan Bed & Breakfast">

    <!-- Twitter Cards (dynamic per page) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $_seo_title; ?>">
    <meta name="twitter:description" content="<?php echo $_seo_description; ?>">
    <meta name="twitter:image" content="<?php echo $_seo_og_image; ?>">
    <meta name="twitter:site" content="@CasaXuunan">
    <meta name="twitter:creator" content="@CasaXuunan">

    <!-- Canonical URL (self-referencing per page) -->
    <link rel="canonical" href="<?php echo $_seo_canonical_url; ?>">
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
    <!-- Homepage Conversion Sections -->
    <link rel="stylesheet" href="css/homepage-sections.css" type="text/css">
    <!-- Elfsight Platform Script: loaded dynamically by reviews-section.js when overlay opens -->
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
    <!-- Search page: single scroll only.
         Body scroll is disabled; #content-absolute owns the only scrollbar.
         #background stays fixed behind with z-index:0. -->
    <style>
        html, body {
            overflow: hidden !important;
            height: 100% !important;
        }
        #wrapper {
            overflow: hidden !important;
            height: 100% !important;
        }
        #background {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        #content-absolute {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow-x: hidden;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            z-index: 1;
        }
        .search-widget-fullwidth {
            max-width: 1240px;
            margin: 0 auto 20px;
            overflow-x: hidden;
            overflow-y: visible;
            box-sizing: border-box;
        }
        /* WOW.js can't detect scroll inside fixed container — force visible */
        #content-absolute .wow {
            visibility: visible !important;
            animation: none !important;
            opacity: 1 !important;
        }
        /* Ensure section covers full viewport */
        #section-main {
            min-height: 100vh;
        }
    </style>
    <?php endif; ?>

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'garden.php' || basename($_SERVER['SCRIPT_NAME']) === 'plant.php'): ?>
    <!-- Garden Styles -->
    <link rel="stylesheet" href="css/garden.css" type="text/css">
    <?php endif; ?>

    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'blog.php' || basename($_SERVER['SCRIPT_NAME']) === 'blog-post.php'): ?>
    <!-- Blog Styles -->
    <link rel="stylesheet" href="css/blog.css" type="text/css">
    <?php endif; ?>

    <!-- Schema.org Structured Data para Bed and Breakfast -->
    <!-- Organization Schema (top-level, enables Knowledge Panel) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "@id": "https://casaxuunan.com/#organization",
      "name": "Casa Xu'unan",
      "alternateName": "Casa Xuunan B&B",
      "url": "https://casaxuunan.com",
      "logo": {
        "@type": "ImageObject",
        "url": "https://casaxuunan.com/images/logo/blanco.png",
        "width": 300,
        "height": 60
      },
      "image": "https://casaxuunan.com/images/gallery/gallery-item-3.jpg",
      "telephone": "+52-985-258-0599",
      "email": "reservas@casaxuunan.com",
      "sameAs": [
        "https://www.facebook.com/people/Casa-Xuunan/61578964945156/",
        "https://www.instagram.com/casa_xuunan/"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+52-985-258-0599",
        "contactType": "reservations",
        "availableLanguage": ["Spanish", "English"],
        "areaServed": "MX"
      }
    }
    </script>

    <!-- WebSite Schema (enables Sitelinks Search Box in Google) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "@id": "https://casaxuunan.com/#website",
      "name": "Casa Xu'unan - B&B Familiar Valladolid",
      "url": "https://casaxuunan.com",
      "inLanguage": ["es", "en"],
      "publisher": { "@id": "https://casaxuunan.com/#organization" },
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://casaxuunan.com/search.php?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

    <!-- BedAndBreakfast Schema (enhanced with reviews, amenities, offers) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BedAndBreakfast",
      "@id": "https://casaxuunan.com/#hotel",
      "name": "Casa Xu'unan",
      "alternateName": "Casa Xuunan Bed and Breakfast",
      "image": [
        "https://casaxuunan.com/images/gallery/gallery-item-1.jpg",
        "https://casaxuunan.com/images/gallery/gallery-item-2.jpg",
        "https://casaxuunan.com/images/gallery/gallery-item-3.jpg",
        "https://casaxuunan.com/images/gallery/gallery-item-4.jpg",
        "https://casaxuunan.com/images/gallery/gallery-item-5.jpg",
        "https://casaxuunan.com/images/slider/1.jpg",
        "https://casaxuunan.com/images/slider/2.jpg",
        "https://casaxuunan.com/images/slider/3.jpg"
      ],
      "description": "B&B familiar en el barrio de Sisal, Valladolid, Yucatán. 9 habitaciones con desayuno regional casero incluido, piscina, jardín tropical y Starlink WiFi. A 40 min de Chichén Itzá. Atención personalizada con la calidez que nos define.",
      "slogan": "El Lujo de lo Auténtico",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Calle 49, Barrio de Sisal, frente al Convento de San Bernardino de Siena",
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
        { "@type": "LocationFeatureSpecification", "name": "Desayuno regional casero incluido", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Starlink WiFi", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Piscina al aire libre", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Jardín tropical", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Estacionamiento privado gratuito", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Aire acondicionado", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Hamacas", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Atención personalizada", "value": true }
      ],
      "numberOfRooms": 9,
      "petsAllowed": false,
      "starRating": {
        "@type": "Rating",
        "ratingValue": "4.8",
        "bestRating": "5"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "bestRating": "5",
        "worstRating": "1",
        "ratingCount": "50",
        "reviewCount": "50"
      },
      "review": [
        {
          "@type": "Review",
          "reviewRating": { "@type": "Rating", "ratingValue": "5", "bestRating": "5" },
          "author": { "@type": "Person", "name": "María" },
          "reviewBody": "El desayuno fue increíble, cada mañana algo diferente. El jardín tropical es un sueño. Sin duda el mejor lugar para hospedarse en Valladolid.",
          "datePublished": "2026-02-15"
        },
        {
          "@type": "Review",
          "reviewRating": { "@type": "Rating", "ratingValue": "5", "bestRating": "5" },
          "author": { "@type": "Person", "name": "Johnson Family" },
          "reviewBody": "Nos recibieron como si fuéramos familia. Nos recomendaron cenotes que no aparecen en ninguna guía. Una experiencia que no encontrarás en ningún hotel.",
          "datePublished": "2026-01-20"
        },
        {
          "@type": "Review",
          "reviewRating": { "@type": "Rating", "ratingValue": "5", "bestRating": "5" },
          "author": { "@type": "Person", "name": "Sophie" },
          "reviewBody": "La ubicación es perfecta: a pasos de la Calzada de los Frailes y a minutos de los cenotes. Exactamente lo que buscaba: autenticidad sin sacrificar comodidad.",
          "datePublished": "2025-12-10"
        }
      ],
      "servesCuisine": ["Desayuno mexicano tradicional", "Cocina yucateca"],
      "acceptsReservations": "https://casaxuunan.com/search.php",
      "checkinTime": "15:00",
      "checkoutTime": "11:00",
      "availableLanguage": ["Spanish", "English"],
      "sameAs": [
        "https://www.facebook.com/people/Casa-Xuunan/61578964945156/",
        "https://www.instagram.com/casa_xuunan/"
      ],
      "hasMap": "https://maps.google.com/?q=20.6896,-88.2019",
      "paymentAccepted": "Cash, Credit Card, Debit Card",
      "currenciesAccepted": "MXN, USD",
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
        "opens": "07:00",
        "closes": "22:00"
      },
      "tourBookingPage": "https://casaxuunan.com/tours.php",
      "containsPlace": {
        "@type": "TouristAttraction",
        "name": "Jardín Xu'unan - Experiencia Botánica",
        "description": "Jardín tropical con más de 100 plantas nativas yucatecas, sistema interactivo con códigos QR"
      }
    }
    </script>

    <?php if ($_seo_current_page === 'index'): ?>
    <!-- FAQPage Schema - Home (enables FAQ rich results on main search result) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "<?php echo t('faq_about_q1'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_about_a1'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_about_q2'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_about_a2'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_about_q3'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_about_a3'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_rooms_q1'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_rooms_a1'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_rooms_q2'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_rooms_a2'); ?>" }
        }
      ]
    }
    </script>
    <?php endif; ?>

    <?php if ($_seo_current_page !== 'index'): ?>
    <!-- BreadcrumbList Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "<?php echo t('breadcrumb_home'); ?>",
          "item": "https://casaxuunan.com/"
        }<?php if ($_seo_current_page === 'blog-post'): ?>,
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Blog",
          "item": "https://casaxuunan.com/blog.php"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "<?php echo addslashes($_seo_title); ?>",
          "item": "<?php echo $_seo_canonical_url; ?>"
        }<?php else: ?>,
        {
          "@type": "ListItem",
          "position": 2,
          "name": "<?php echo addslashes($_seo_title); ?>",
          "item": "<?php echo $_seo_canonical_url; ?>"
        }<?php endif; ?>
      ]
    }
    </script>
    <?php endif; ?>

    <?php if ($_seo_current_page === 'tours'): ?>
    <!-- FAQPage Schema - Tours -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "<?php echo t('faq_tours_q1'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_tours_a1'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_tours_q2'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_tours_a2'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_tours_q3'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_tours_a3'); ?>" }
        }
      ]
    }
    </script>
    <?php endif; ?>

    <?php if ($_seo_current_page === 'about'): ?>
    <!-- FAQPage Schema - About -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "<?php echo t('faq_about_q1'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_about_a1'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_about_q2'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_about_a2'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_about_q3'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_about_a3'); ?>" }
        }
      ]
    }
    </script>
    <?php endif; ?>

    <?php if ($_seo_current_page === 'rooms'): ?>
    <!-- FAQPage Schema - Rooms -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "<?php echo t('faq_rooms_q1'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_rooms_a1'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_rooms_q2'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_rooms_a2'); ?>" }
        },
        {
          "@type": "Question",
          "name": "<?php echo t('faq_rooms_q3'); ?>",
          "acceptedAnswer": { "@type": "Answer", "text": "<?php echo t('faq_rooms_a3'); ?>" }
        }
      ]
    }
    </script>
    <?php endif; ?>

    <?php if ($_seo_current_page === 'tours'): ?>
    <!-- TouristTrip Schema - Tours -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ItemList",
      "name": "<?php echo t('tours_meta_title'); ?>",
      "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Maravilla Maya - Chichen Itza", "url": "https://casaxuunan.com/tours.php" },
        { "@type": "ListItem", "position": 2, "name": "Aventura Arqueologica - Ek Balam", "url": "https://casaxuunan.com/tours.php" },
        { "@type": "ListItem", "position": 3, "name": "Magia Rosa - Las Coloradas", "url": "https://casaxuunan.com/tours.php" }
      ]
    }
    </script>
    <?php endif; ?>

    <?php if ($_seo_current_page === 'masajes' || $_seo_current_page === 'cuidado-personal' || $_seo_current_page === 'transporte'): ?>
    <!-- Service Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Service",
      "name": "<?php echo $_seo_title; ?>",
      "description": "<?php echo $_seo_description; ?>",
      "provider": {
        "@type": "BedAndBreakfast",
        "name": "Casa Xu'unan",
        "url": "https://casaxuunan.com"
      },
      "areaServed": {
        "@type": "City",
        "name": "Valladolid, Yucatan"
      }
    }
    </script>
    <?php endif; ?>

    <?php if ($_seo_current_page === 'blog-post' && isset($_seo_blog_post_found)): ?>
    <?php
      $_blog_content_raw = ($_seo_lang === 'es') ? $_seo_blog_post_found['content_es'] : $_seo_blog_post_found['content_en'];
      $_blog_word_count = str_word_count(strip_tags($_blog_content_raw));
      $_blog_category = ($_seo_lang === 'es') ? $_seo_blog_post_found['category_es'] : $_seo_blog_post_found['category_en'];
    ?>
    <!-- BlogPosting Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "<?php echo addslashes($_seo_title); ?>",
      "description": "<?php echo addslashes($_seo_description); ?>",
      "image": "https://casaxuunan.com/<?php echo file_exists($_seo_blog_post_found['image']) ? $_seo_blog_post_found['image'] : $_seo_blog_post_found['fallback_image']; ?>",
      "datePublished": "<?php echo $_seo_blog_post_found['date']; ?>",
      "dateModified": "<?php echo $_seo_blog_post_found['date']; ?>",
      "inLanguage": "<?php echo $_seo_lang; ?>",
      "wordCount": <?php echo $_blog_word_count; ?>,
      "articleSection": "<?php echo addslashes($_blog_category); ?>",
      "keywords": "<?php echo addslashes($_seo_keywords); ?>",
      "author": {
        "@type": "Organization",
        "name": "Casa Xu'unan",
        "url": "https://casaxuunan.com",
        "logo": "https://casaxuunan.com/images/logo/blanco.png"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Casa Xu'unan",
        "logo": {
          "@type": "ImageObject",
          "url": "https://casaxuunan.com/images/logo/blanco.png",
          "width": 300,
          "height": 60
        }
      },
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo $_seo_canonical_url; ?>"
      },
      "isPartOf": {
        "@type": "Blog",
        "name": "Blog Casa Xu'unan",
        "url": "https://casaxuunan.com/blog.php"
      }
    }
    </script>
    <?php endif; ?>
</head>