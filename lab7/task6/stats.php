<?php
$host = 'localhost';
$dbname = 'lab5';
$username = 'root';
$password = '';

$isOk = $_GET['isOk'] ?? null;
if (isset($isOk) && $isOk === "false")
{
    http_response_code(404);
    // die;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Не вдалося підключитися до бази даних: " . $e->getMessage());
}

$yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));

// Загальна кількість запитів за останню добу
$totalQueriesQuery = "SELECT COUNT(*) FROM logger WHERE date > ?";
$stmt = $pdo->prepare($totalQueriesQuery);
$stmt->execute([$yesterday]);
$totalQueries = $stmt->fetchColumn();

// Кількість 404 помилок за останню добу
$errors404Query = "SELECT COUNT(*) FROM logger WHERE date > ? AND status_code = 404";
$stmt = $pdo->prepare($errors404Query);
$stmt->execute([$yesterday]);
$errors404 = $stmt->fetchColumn();

// Обчислюємо відсоток 404 помилок
$percent404 = ($totalQueries > 0) ? ($errors404 / $totalQueries) * 100 : 0;

// Якщо відсоток 404 помилок перевищує 10%, надсилаємо повідомлення адміністратору
if ($percent404 > 10) {
    $message = "За останню добу відсоток 404 помилок перевищив 10%. Поточний відсоток: $percent404%";
    var_dump($message); // mail() / tg bot
}

echo "<h1>Статистика за останню добу</h1>";
echo "<p>Загальна кількість запитів: $totalQueries</p>";
echo "<p>Кількість 404 помилок: $errors404</p>";
echo "<p>Відсоток 404 помилок: $percent404%</p>";
