<!-- includes/sections/js.php -->

<!-- Idioma actual desde PHP para sincronizar con JavaScript -->
<script>
    window.PHP_LANG = '<?php echo getCurrentLanguage(); ?>';
    window.HOSPITABLE_MARKUP = <?php echo defined('HOSPITABLE_DIRECT_MARKUP') ? HOSPITABLE_DIRECT_MARKUP : 1.10; ?>;
    // Cache buster de la imagen del popup: usa filemtime para que al cambiar
    // la foto el navegador (y CDN) baje la nueva sin necesidad de Ctrl+Shift+R.
    window.CX_POPUP_IMG_V = '<?php echo @filemtime(__DIR__ . '/../../images/popup/popup-casa10-v2.jpg') ?: time(); ?>';
</script>

<!-- Lang switcher legacy: ya no se usa.
     El selector de idioma actual es un dropdown de 3 idiomas (ES/EN/FR)
     manejado en navbar.php y navbar-index.php con su propio JS. -->

<!-- JS aquí -->
<!-- Archivos Javascript Comunes -->
<script src="<?php echo BASE_URL; ?>/js/plugins.js"></script>
<script src="<?php echo BASE_URL; ?>/js/designesia.js"></script>
<script src="<?php echo BASE_URL; ?>/js/custom-mobile-menu.js"></script>
<script src="<?php echo BASE_URL; ?>/js/neuro-caption-words.js" defer></script>
<script src="<?php echo BASE_URL; ?>/js/direct-booking-banner.js" defer></script>
<script src="<?php echo BASE_URL; ?>/js/scroll-header.js" defer></script>
<?php if (basename($_SERVER['SCRIPT_NAME']) === 'index.php'): ?>
<script src="<?php echo BASE_URL; ?>/js/flag-emoji-detect.js" defer></script>
<!-- home-snap-scroll.js desactivado: scroll libre natural -->
<?php endif; ?>

<!-- Supersized (solo para la página index) -->
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'index.php') {
    echo '<script src="' . BASE_URL . '/js/supersized/js/supersized.3.2.7.js"></script>';
    echo '<script src="' . BASE_URL . '/js/supersized/theme/supersized.shutter.min.js"></script>';
    echo '<script src="' . BASE_URL . '/js/index.js"></script>';
    echo '<script src="' . BASE_URL . '/js/reviews-section.js"></script>';
    echo '<script src="' . BASE_URL . '/js/homepage-sections.js"></script>';
    // Carrusel de reseñas: auto-scroll + pausa hover + drag mouse/touch
    // cache buster con filemtime para forzar recarga al actualizar
    $carousel_v = @filemtime(__DIR__ . '/../../js/reviews-carousel.js') ?: time();
    echo '<script src="' . BASE_URL . '/js/reviews-carousel.js?v=' . $carousel_v . '" defer></script>';
    // Welcome Popup CASA10 - solo home, 1 vez por sesion, delay 3s
    // cache buster con filemtime para forzar recarga al actualizar
    $popup_v = @filemtime(__DIR__ . '/../../js/welcome-popup.js') ?: time();
    echo '<script src="' . BASE_URL . '/js/welcome-popup.js?v=' . $popup_v . '" defer></script>';
}
?>
<?php
// Welcome Popup CASA10 tambien en search.php (landing de los ads).
// Recuerda el descuento CASA10 al viajero que llega directo desde Google Ads.
// El popup detecta que esta en search.php y su CTA solo cierra (no redirige).
if (basename($_SERVER['SCRIPT_NAME']) === 'search.php') {
    $popup_v = @filemtime(__DIR__ . '/../../js/welcome-popup.js') ?: time();
    echo '<script src="' . BASE_URL . '/js/welcome-popup.js?v=' . $popup_v . '" defer></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'rooms.php') {
    echo '<script src="' . BASE_URL . '/js/rooms.js"></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'masajes.php') {
    echo '<script src="' . BASE_URL . '/js/masajes.js"></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'tours.php') {
    echo '<script src="' . BASE_URL . '/js/tours.js"></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'cuidado-personal.php') {
    echo '<script src="' . BASE_URL . '/js/cuidado-personal.js"></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'transporte.php') {
    echo '<script src="' . BASE_URL . '/js/transporte.js"></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'contact.php') {
    echo '<script src="' . BASE_URL . '/js/contact-whatsapp.js"></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'gallery.php') {
    echo '<script src="' . BASE_URL . '/js/gallery.js"></script>';
}
?>
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'garden.php' || basename($_SERVER['SCRIPT_NAME']) === 'plant.php') {
    echo '<script src="' . BASE_URL . '/js/garden.js"></script>';
}
?>
