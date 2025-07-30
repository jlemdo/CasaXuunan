<!-- includes/sections/js.php -->

<!-- JS aquí -->
<!-- Archivos Javascript Comunes -->
<script src="<?php echo BASE_URL; ?>/js/plugins.js"></script>
<script src="<?php echo BASE_URL; ?>/js/designesia.js"></script>


<!-- Supersized (solo para la página index) -->
<?php
if (basename($_SERVER['SCRIPT_NAME']) === 'index.php') {
    echo '<script src="' . BASE_URL . '/js/supersized/js/supersized.3.2.7.js"></script>';
    echo '<script src="' . BASE_URL . '/js/supersized/theme/supersized.shutter.min.js"></script>';
    echo '<script src="' . BASE_URL . '/js/index.js"></script>';
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
