<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 5 Task 1</title>

    <?php
    session_start();
    if (!isset($_SESSION["ob"])) {
        $_SESSION["ob"] = [];
    }
    $wrong = false;
    $missing = false;
    if (isset($_SESSION["logged"]) && isset($_SESSION["login"])) {
        header("Location: userProfile.php");
        die;
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $post_keys = [];
        foreach ($_POST as $key => $value) {
            if (strlen($value) > 0) {
                $$key = $value;
                array_push($post_keys, $key);
            } else {
                $missing = true;
                break;
            }
        }
        if (!$missing) {
            $dsn = "mysql:host=localhost;dbname=lab5";
            $pdo = new PDO($dsn, "root", "");

            $sql = "SELECT * FROM users WHERE login = :login AND password = :password LIMIT 1";
            $sth = $pdo->prepare($sql);
            foreach ($post_keys as $key) {
                $sth->bindValue(":$key", $$key);
            }
            $sth->execute();
            if (count($sth->fetchAll()) > 0) {
                $_SESSION['logged'] = true;
                $_SESSION['login'] = $login;
                array_push($_SESSION["ob"], "Logined succesfully");
                header("Location: userProfile.php?");
                die;
            }
            $wrong = true;
        }
    }
    ?>

    <style>
        .df {
            display: flex;
        }

        .fd-c {
            flex-direction: column;
        }

        .jc-c {
            justify-content: center;
        }

        .al-i-c {
            align-items: center;
        }

        .height {
            height: 600px;
        }
    </style>
</head>

<body>
    <div class="df fd-c jc-c al-i-c height">
        <p>Вхід</p>
        <form method="POST" action="">
            <table>
                <tr>
                    <td>Логін:</td>
                    <td><input type="text" name="login" /></td>
                </tr>
                <tr>
                    <td>Пароль:</td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Вхід" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="register.php">Реєстрація</a></td>
                </tr>
                <?php
                if ($missing) {
                    ob_start();
                    RegisterError("Ви не ввели пароль або логін!");
                    array_push($_SESSION["ob"], ob_get_contents());
                    ob_clean();
                }
                if ($wrong) {
                    ob_start();
                    RegisterError("Неправильний логін або пароль!");
                    array_push($_SESSION["ob"], ob_get_contents());
                    ob_clean();
                }
                ?>
            </table>
        </form>
    </div>
</body>

<?php

function RegisterError($error): void
{
    echo "
    <tr>
        <td></td>
        <td>$error</td>
    </tr>
    ";
}
?>

</html>