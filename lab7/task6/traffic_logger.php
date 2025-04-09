<?php
if ($_SERVER['REQUEST_URI'] == '/traffic_logger.php') {
    exit;
}

$host = 'localhost';
$dbname = 'lab5';
$username = 'root';
$password = '';

// Get the requested URI and split it into path and query string
$requestUri = $_SERVER['REQUEST_URI'];
$uriParts = parse_url($requestUri);

$filePath = $uriParts['path'];
$queryString = isset($uriParts['query']) ? $uriParts['query'] : '';

// Process the query string using $_GET before including the file
parse_str($queryString, $_GET);

// Output buffering to catch status code *after* script runs
ob_start();
include($_SERVER['DOCUMENT_ROOT'] . $filePath);
ob_end_flush(); // Let output flow to client

// Database logging
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Не вдалося підключитися до бази даних: " . $e->getMessage());
}

$ip = $_SERVER['REMOTE_ADDR'];
$date = date('Y-m-d H:i:s');
$url = $_SERVER['REQUEST_URI'];
$status_code = http_response_code();

$sql = "INSERT INTO logger (ip, date, url, status_code) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$ip, $date, $url, $status_code]);
?>
