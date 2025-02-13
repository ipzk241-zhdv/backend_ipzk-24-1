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
            $check = "no pass or login";
        } else {
            $path = "./userFolders/";
            if (!is_dir($path . $login)) {
                $check = "wrong";
            } else {
                $scan = scandir($path);
                $scan = array_reverse($scan);
                array_pop($scan);
                array_pop($scan);
                if (in_array($login, $scan)) {
                    $passwordInFile = file_get_contents($path . $login . "/password.txt");
                    if ($password != $passwordInFile) {
                        $check = "wrong";
                    } else {
                        rmDirWithFiles($path . $login);
                    }
                }
            }
        }
    }

    function rmDirWithFiles($dirPath)
    {
        $dirElements = scandir($dirPath);
        foreach ($dirElements as $element) {
            if ($element === "." || $element === "..") {
                continue;
            }
            $path = $dirPath . "/" . $element;
            if (is_file($path)) {
                unlink($path);
            }
            if (is_dir($path)) {
                rmdirWithFiles($path);
                if (is_dir($path)) {
                    rmdir($path);
                }
            }
        }
        rmdir($dirPath);
    }
    ?>

    <style>

    </style>
</head>

<body>

    <form method="POST" action="">
        <table>
            <th>Видалення</th>
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
                <td><input type="submit" value="Видалити"></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="index.php">Перейти до створення</a></td>
            </tr>
            <?php
            if (isset($check)) {
                if ($check == "no pass or login") {
                    echo "
                    <tr>
                        <td></td>
                        <td>Ви не ввели логін або пароль!</td>
                    </tr>
                    ";
                }
                if ($check == "wrong") {
                    echo "
                    <tr>
                        <td></td>
                        <td>Неіснуючий логін або неправильний пароль!</td>
                    </tr>
                    ";
                }
            }
            ?>

        </table>
    </form>

</body>

</html>