<?php
$cacheFile = 'cache.html';
$isOk = $_GET['isOk'] ?? null;

if (isset($isOk) && $isOk === "false") {
    // Якщо isOk=false - генеруємо 404 і видаляємо кеш
    http_response_code(404);
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Сторінку не знайдено</title>
    </head>
    <body>
        <h1>404 - Сторінку не знайдено</h1>
    </body>
    </html>
    <?php
    exit;
}

// Якщо кеш існує і isOk=true
if (file_exists($cacheFile)) {
    echo file_get_contents($cacheFile);
    exit;
}

// Початок буферизації виводу
ob_start();
http_response_code(200);
date_default_timezone_set('Europe/Kyiv');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Кешована сторінка</title>
</head>
<body>
    <h1>Це кешована сторінка!</h1>
    <p>Час генерації: <?php echo date('Y-m-d H:i:s'); ?></p>
</body>
</html>
<?php
$content = ob_get_contents();
file_put_contents($cacheFile, $content);
// Завершення буферизації і вивід вмісту
ob_end_flush();

// isOk=false isOk=true cacheExist   printCache printNotFound
// 1          0         no matter    0          1
// 0          1         0            0          0
// 0          1         1            1          0
// 0          0         1            1          0   
// 0          0         0            0          0   