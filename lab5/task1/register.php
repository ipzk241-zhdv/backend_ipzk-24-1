<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 5 Task 1</title>

    <?php
    session_start();
    $missing = false;
    $already_exist = false;
    if (isset($_SESSION["logged"]) && isset($_SESSION["login"])) {
        header("Location: userProfile.php");
        die;
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $post_keys = [];
        foreach ($_POST as $key => $value) {
            if ($key == "info") {
                $value = nl2br($value);
                $$key = $value;
                array_push($post_keys, $key);
                continue;
            }
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

            $sql = "SELECT * FROM users WHERE login = :login LIMIT 1";
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":login", $login);
            $sth->execute();

            if (count($sth->fetchAll()) > 0) {
                $already_exist = true;
            }
            if (!$already_exist) {
                $sql = "INSERT INTO users VALUES (NULL, :login, :password, :info)";
                $sth = $pdo->prepare($sql);

                foreach ($post_keys as $key) {
                    $sth->bindValue(":$key", $$key);
                }

                $sth->execute();
                $_SESSION["logged"] = true;
                $_SESSION["login"] = $login;
                header("Location: userProfile.php");
                die;
            }
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
        <p>Реєстрація</p>
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
                    <td>Про себе:</td>
                    <td>
                        <textarea name="info" cols="20" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Реєстрація" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="login.php">Вхід</a></td>
                </tr>
                <?php
                if ($missing) {
                    RegisterError("Ви не ввели пароль або логін!");
                }
                if ($already_exist) {
                    RegisterError("Такий логін вже існує!");
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