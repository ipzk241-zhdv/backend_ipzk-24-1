<?php
// Запуск буферизації
ob_start();

// Встановлення часової зони
date_default_timezone_set('Europe/Kyiv');

// Приховуємо помилки з екрана, але логуватимемо самі
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Обробник некритичних помилок
set_error_handler('customErrorHandler');

// Обробник фатальних помилок
register_shutdown_function('handleFatalError');

// Обробка некритичних помилок
function customErrorHandler($errno, $errstr, $errfile, $errline)
{
    $time = date('Y-m-d H:i:s');
    $type = match ($errno) {
        E_WARNING => 'Warning',
        E_NOTICE => 'Notice',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        default => 'Error',
    };
    $message = "<p><strong>[$time] [$type]</strong> $errstr in <code>$errfile</code> on line <strong>$errline</strong></p>\n";
    file_put_contents('errors_log.html', $message, FILE_APPEND);

    // Не переривати виконання
    return true;
}

// Обробка фатальних помилок
function handleFatalError()
{
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        ob_clean();
        http_response_code(500);

        $time = date('Y-m-d H:i:s');
        $message = "<p><strong>[$time] [FATAL]</strong> {$error['message']} in <code>{$error['file']}</code> on line <strong>{$error['line']}</strong></p>\n";
        file_put_contents('errors_log.html', $message, FILE_APPEND);

        $when = date('H:i', strtotime('+15 minutes'));
        echo <<<HTML
<!DOCTYPE html>
<html>
<head><title>Помилка сервера</title></head>
<body>
    <h1>500 - Внутрішня помилка сервера</h1>
    <p>Вибачте, сталася фатальна помилка.</p>
    <p>Ми працюємо над її усуненням. Повторіть спробу приблизно о <strong>{$when}</strong>.</p>
</body>
</html>
HTML;
        exit;
    } else {
        http_response_code(200);
        ob_end_flush();
    }
}


echo $undefinedVariable; // Warning
// trigger_error("Користувацька помилка", E_USER_WARNING);
// require('non_existing_file.php'); // Fatal


?>
<!DOCTYPE html>
<html>

<head>
    <title>Головна сторінка</title>
</head>

<body>
    <h1>Сторінка без фатальних помилок</h1>
    <p>Все працює коректно.</p>
</body>

</html>