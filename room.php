<?php
// Fix double ? from Hospitable widget: room.php?id=xxx?checkin=... → room.php?id=xxx&checkin=...
$uri = $_SERVER['REQUEST_URI'];
$firstQ = strpos($uri, '?');
if ($firstQ !== false) {
    $secondQ = strpos($uri, '?', $firstQ + 1);
    if ($secondQ !== false) {
        $fixed = substr($uri, 0, $secondQ) . '&' . substr($uri, $secondQ + 1);
        header("Location: $fixed", true, 302);
        exit;
    }
}

require 'includes/funciones.php';
incluirTemplate('room-single', true);
