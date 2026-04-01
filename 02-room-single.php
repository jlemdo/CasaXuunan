<?php
// Redirect from Hospitable widget URL to actual room.php
// Fixes: 02-room-single.php?id=xxx?checkin=... (double ? from widget)

$requestUri = $_SERVER['REQUEST_URI'];

// Fix double ? issue: replace second ? with &
$firstQ = strpos($requestUri, '?');
if ($firstQ !== false) {
    $secondQ = strpos($requestUri, '?', $firstQ + 1);
    if ($secondQ !== false) {
        $requestUri = substr($requestUri, 0, $secondQ) . '&' . substr($requestUri, $secondQ + 1);
    }
}

// Extract query string from fixed URI
$queryString = parse_url($requestUri, PHP_URL_QUERY);

header("Location: /room.php?" . $queryString, true, 301);
exit;
?>
