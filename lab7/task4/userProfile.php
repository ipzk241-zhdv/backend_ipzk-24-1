<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 5 Task 1</title>


    <?php
    require_once ("checkLogged.php");
    session_start();
    $account = checkLogged();
    $edit = false;
    $missing = false;
    $changed = false;
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET["edit"])) {
            if ($_GET["edit"] == "true") {
                $edit = true;
                unset($_GET["edit"]);
            }
        }

        if (isset($_GET["logout"])) {
            if ($_GET["logout"] == "true") {
                unset($_SESSION["login"]);
                unset($_SESSION["logged"]);
                // session_abort() ?
                header("Location: index.php");
                die;
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $post_keys = [];
        foreach ($_POST as $key => $value) {
            if ($key == "info") {
                $$key = $value;
                $post_keys[$key] = $value;
                continue;
            }
            if (strlen($value) > 0) {
                $$key = $value;
                $post_keys[$key] = $value;
            } else {
                $missing = true;
                $edit = true;
                break;
            }
        }
        if (!$missing) {

            $dsn = "mysql:host=localhost;dbname=lab5";
            $pdo = new PDO($dsn, "root", "");
            $set = "";

            foreach ($post_keys as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ', ');
            $sql = "UPDATE users SET $set WHERE id = :id LIMIT 1";
            $sth = $pdo->prepare($sql);

            foreach ($post_keys as $key => $value) {
                $sth->bindValue(":$key", $value);
            }

            $sth->bindValue("id", $account['id']);
            $sth->execute();
            $_SESSION['login'] = $post_keys['login'];
            $account = checkLogged();
            $changed = true;
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

        .jc-e {
            justify-content: end;
        }

        .al-i-c {
            align-items: center;
        }

        .height {
            height: 600px;
        }

        a {
            text-decoration: none;
        }

        .width {
            width: 1000px;
        }
    </style>
</head>

<body>
    <div class="df jc-e al-i-c width">
        <a href="?logout=true"><input type="submit" value="Вихід"></a>
    </div>
    <div class="df fd-c jc-c al-i-c height">
        <p>Привіт, <?= $account['login'] ?></p>
        <?php if ($changed): ?>
            <p>Дані змінено успішно!</p>
        <?php endif ?>
        <?php if (!$edit): ?>
            <a href="?edit=true">
                <p>Змінити дані</p>
            </a>
        <?php else: ?>
            <a href="userProfile.php">
                <p>Відмінити зміни</p>
            </a>
        <?php endif; ?>
        <?php
        if ($edit || $missing):
            $new_data = $account;
            unset($new_data['id']);
            ?>
            <form method="POST" action="userProfile.php">
                <table>
                    <?php
                    foreach ($new_data as $key => $value) {
                        echo "<tr><th>" . ucfirst($key) . "</th>";
                        if ($key == "info") {
                            echo '<td><textarea name="' . $key . '" cols="20" rows="5">' . $value . '</textarea></td>';
                        } else {
                            echo '<td><input type="text" value="' . $value . '" name="' . $key . '"></td>';
                        }
                        echo "</tr>";
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Змінити"></td>
                    </tr>
                    <?php if ($missing): ?>
                        <tr>
                            <td></td>
                            <td>Логін і пароль не можуть бути порожніми!</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>