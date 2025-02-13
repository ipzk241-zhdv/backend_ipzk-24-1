<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab3 Cookie</title>
    <?php
    session_start();
    $logged = false;

    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET["logout"])) {
            if ($_GET["logout"]) {
                unset($_SESSION["logged"]);
                header("Location: index.php");
                die;
            }
        }

        if (isset($_GET["fs"])) {
            setcookie("fs", $_GET["fs"], time() + 3600 * 5);
            header("Location: index.php"); // працює і без подвійної переадресації, але
            die;                           // оставив щоб видалити змінну fs з url
        }
    }

    if (isset($_SESSION["logged"])) {
        if ($_SESSION["logged"]) {
            $logged = true;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        foreach ($_POST as $key => $value) { // перебрати ключі і значення масиву _POST
            if (strlen($_POST[$key]) > 0) { // якщо довжина значення ключа більша за 0 (дефакто, встановлена)
                $$key = $_POST[$key]; // створити змінну з назвою ключа і її значенням
            }
        }
        if (isset($login) && isset($password)) { {
                if ($login == "admin" && $password == "password") {
                    $logged = true;
                    $_SESSION['login'] = $login;
                    $_SESSION['logged'] = true;
                }
            }
        }
    }
    ?>
    <style>
        * {
            font-size:
                <?= isset($_COOKIE["fs"]) ? $_COOKIE['fs'] . "px" : "25px" ?>
        }

        .df {
            display: flex;
        }

        .jc-se {
            justify-content: space-evenly;
        }
    </style>
</head>

<body>
    <div class="df jc-se">
        <a href="?fs=15">Маленький шрифт</a>
        <a href="?fs=20">Середній шрифт</a>
        <a href="?fs=30">Великий шрифт</a>
    </div>

    <?php
    if (!$logged) {
        echo '
        <form method="POST" action="">
        <table>
            <tr>
                <td>Логін:</td>
                <td><input type="text" name="login"></td>
            </tr>
            <tr>
                <td>Пароль:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Log In"></td>
            </tr>
        </table>
        </form> ';
    } else {
        echo '
        <table>
            <tr>
                <td>Добрий день, </td>
                <td>' . $_SESSION["login"] . '</td>
            </tr>
            <tr>
                <td></td>
                <td><a href="?logout=true"><button name="submit">Log Out</button></a></td>
            </tr>
        </table>
        ';
    }
    ?>



</body>

</html>