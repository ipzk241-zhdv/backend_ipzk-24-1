<?php

/**
 * checkLogged перевіряє чи користувач авторизувався на сайті
 * використовуючи супер глобальний асоціативний масив $_SESSION
 * @return array повертає ассоціативний масив зі всіма полями таблиці users з бази даних для
 * цього користувача або переадресовує його на форму авторизації
 */
function checkLogged(): ?array
{
    if (!isset($_SESSION["logged"]) || !isset($_SESSION["login"])) {
        header("Location: login.php");
        die;
    } else {
        $dsn = "mysql:host=localhost;dbname=lab5";
        $pdo = new PDO($dsn, "root", "");

        $login = $_SESSION["login"];
        $sql = "SELECT * FROM users WHERE login = :login LIMIT 1";

        $sth = $pdo->prepare($sql);
        $sth->bindValue(":login", $login);
        // чи потрібно bindValue, якщо використані змінні зберігаються в сессії?
        $sth->execute();
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
}