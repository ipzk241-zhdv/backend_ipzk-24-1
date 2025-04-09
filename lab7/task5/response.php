<?php

class Response
{
    public function setStatus($code)
    {
        http_response_code($code);
    }

    // Метод для додавання заголовка
    public function addHeader($header)
    {
        header($header);
    }

    public function send($content)
    {
        ob_start(); 
        ob_clean();

        echo $content;

        ob_end_flush();
    }
}

$response = new Response();
$response->setStatus(200);
$response->addHeader("Content-Type: text/html");
$response->send("<h1>Вітаємо!</h1><p>Це динамічна відповідь.</p>");
