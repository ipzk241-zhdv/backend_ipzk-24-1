<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3 Delete Folders</title>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        foreach ($_POST as $key => $value) { // перебрати ключі і значення масиву _POST
            if (strlen($_POST[$key]) > 0) { // якщо довжина значення ключа більша за 0 (дефакто, встановлена)
                $$key = $_POST[$key]; // створити змінну з назвою ключа і її значенням
            }
        }

        if (!isset($login) || !isset($password)) {
            $register = "no pass or login";
        } else {
            $path = "./userFolders/" . $login;
            if (file_exists($path)) {
                $register = "already exist";
            } else {
                mkdir($path);
                $pathPassword = $path . "/password.txt";
                $pathVideoDir = $path . "/video";
                $pathPhotoDir = $path . "/photo";
                $pathMusicDir = $path . "/music";
                
                file_put_contents($pathPassword, $password);
                mkdir($pathPhotoDir);
                mkdir($pathMusicDir);
                mkdir($pathVideoDir);

                file_put_contents($pathPhotoDir . "/photo.txt", "someContent");
                file_put_contents($pathMusicDir . "/music.txt", "someContent");
                file_put_contents($pathVideoDir . "/video.txt", "someContent");
                $register = "success";
            }
        }
    }
    ?>

    <style>

    </style>
</head>

<body>

    <form method="POST" action="">
        <table>
            <th>Створення</th>
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
                <td><input type="submit" value="Створити"></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="delete.php">Перейти до видалення</a></td>
            </tr>
            <?php
            if (isset($register)) {
                if ($register == "no pass or login") {
                    echo "
                    <tr>
                        <td></td>
                        <td>Ви не ввели логін або пароль!</td>
                    </tr>
                    ";
                }
                if ($register == "already exist") {
                    echo "
                    <tr>
                        <td></td>
                        <td>Такий логін вже існує!</td>
                    </tr>
                    ";
                }
                if ($register == "success") {
                    echo "
                    <tr>
                        <td></td>
                        <td>Аккаунт створено успішно!</td>
                    </tr>
                    ";
                }
            }
            ?>

        </table>
    </form>

</body>

</html>