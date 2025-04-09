<?php

$logFile = 'requests.log';
date_default_timezone_set('Europe/Kyiv');

$currentTime = time();

$rateLimitWindow = 60;
$cleanupThreshold = 120;

// IP користувача
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown'; // потенційно баг

// Зчитування існуючих логів
$logs = file_exists($logFile) ? file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

$filteredLogs = [];
$requestCount = 0;

// Фільтрація старих записів і підрахунок запитів цього IP
foreach ($logs as $line) {
    [$logIp, $timestamp] = explode('|', $line);
    $timestamp = (int)$timestamp;

    // Пропускаємо старі записи (старше 2 хвилин)
    if ($currentTime - $timestamp > $cleanupThreshold) {
        continue;
    }

    // Зберігаємо лише актуальні записи
    $filteredLogs[] = "$logIp|$timestamp";

    // Підрахунок запитів за останню хвилину для поточного IP
    if ($logIp === $ip && ($currentTime - $timestamp <= $rateLimitWindow)) {
        $requestCount++;
    }
}

if ($requestCount >= 5) {
    http_response_code(429);
    header('Retry-After: 60'); // Рекомендувати спробувати через 60 секунд
    echo "<h1>429 Too Many Requests</h1><p>Будь ласка, спробуйте пізніше.</p>";
    exit;
}

// Додаємо поточний запит до логів
$filteredLogs[] = "$ip|$currentTime";
file_put_contents($logFile, implode("\n", $filteredLogs) . "\n");

// Відповідь при нормальному запиті
http_response_code(200);
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ласкаво просимо</title>
</head>
<body>
    <h1>Ви успішно отримали доступ</h1>
    <p>IP: <?php echo htmlspecialchars($ip); ?></p>
    <p>Час: <?php echo date('Y-m-d H:i:s'); ?></p>
</body>
</html>
<?php
ob_end_flush();
