<?php
ob_start();

date_default_timezone_set('Europe/Kyiv');

$requestedPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
var_dump($requestedPath);

$redirects = json_decode(file_get_contents("redirects.json"), true);

var_dump($redirects[$requestedPath]);

if (isset($redirects[$requestedPath])) {
    $target = $redirects[$requestedPath];
    header("Location: $target", true, 301);
} else {
    http_response_code(200);
    echo "<h1>Головна або довільна сторінка</h1><p>Немає правила для <code>$requestedPath</code>.</p>";
}

ob_end_flush();
