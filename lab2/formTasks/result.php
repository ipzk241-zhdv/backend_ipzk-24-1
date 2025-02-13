<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab2 Form Task</title>
    <style>
        tr {
            vertical-align: initial;
        }

        table {
            border-spacing: 10px;
            vertical-align: initial;
        }

        * {
            font-size: 20px;
        }

        img {
            width: 30%;
            height: 30%;
        }

        tr td:first-child {
            color: gray;
        }
    </style>
</head>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    foreach ($_POST as $key => $value) { // перебрати ключі і значення масиву _POST
        if ($key == 'games') {
            $$key = $_POST[$key];
            $_SESSION[$key] = serialize($_POST[$key]);
            continue;
        }
        if (strlen($_POST[$key]) > 0) { // якщо довжина значення ключа більша за 0 (дефакто, встановлена)
            $$key = $_POST[$key]; // створити змінну з назвою ключа і її значенням
            $_SESSION[$key] = $_POST[$key];
        }
    }

    if (isset($games)) {
        $translated = [
            "Футбол" => "football",
            "Баскетбол" => "basketball",
            "Волейбол" => "volleyball",
            "Шахи" => "chess",
        ];

        for ($i = 0; $i < count($games); $i++) {
            foreach ($translated as $key => $value) {
                if ($games[$i] == $value) {
                    $games[$i] = $key; // переклад
                }
            }
        }
    }

    $isPhoto = false;
    if ($_FILES['userPhoto']['error'] != 4) {
        $isPhoto = true;
        $photo = $_FILES['userPhoto']['tmp_name'];
        $i = uniqid(); // унікальний ідентифікатор для збереження файлу
        do {
            $path = "./photos/$i.png"; // майбутній шлях, який буде перевірятися чи вже зайнятий
            $i = uniqid(); // підготовка нового ідентифікатору у разі якщо поточний зайнятий
            // можливо не потрібна така перевірка, якщо ж uniqid використовує
            // у паттерні створення ідентифікатору поточний час
        } while (is_file($path));
        move_uploaded_file($photo, $path); // зберігає завантажений файл з POST відправленний через HTTP
    }
}
?>

<body>
    <table>
        <tr>
            <td>Логін:</td>
            <td>
                <?php echo isset($login) ? $login : "Логін не був введений" ?>
            </td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td>
                <?php
                if (isset($password) && isset($passwordCheck)) { // неможливо перевірити чи паролі співпадають
                    if ($password == $passwordCheck) {           // якщо один з них не був введений
                        echo "Паролі співпадають";
                    } else {
                        echo "Паролі не співпадають";
                    }
                } else {
                    echo "Пароль не був введений";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Стать:</td>
            <td>
                <?php
                echo isset($gender) ? // краще if..else?
                    $gender == 'male' ? "Чоловік" : "Жінка"
                    : "Стать не встановлена";
                ?>
            </td>
        </tr>
        <tr>
            <td>Місто:</td>
            <!-- city у цьому випадку завжди буде, оскільки передається через select -->
            <!-- в якому обран якийсь option за замовчуванням -->
            <td><?= $city ?></td>
        </tr>
        <tr>
            <td>Улюблені ігри:</td>
            <td>
                <?php
                if (isset($games)) {
                    foreach ($games as $game) {
                        echo "$game<br>";
                    }
                } else {
                    echo "-";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Про себе:</td>
            <td>
                <?php
                if (isset($info)) {
                    $info = nl2br($info); // new line to br, класна назва
                    echo $info;
                } else {
                    echo "Опис не був введений";
                }
                ?>
            </td>
        </tr>
        <tr style="vertical-align: inherit;">
            <td>Фотографія:</td>
            <td>
                <?php
                if ($isPhoto) {
                    echo '<img src=' . $path . ' alt="user photo">';
                } else {
                    echo "Фото не було завантажено";
                }
                ?>
            </td>
        </tr>
    </table>
    <p><a href="./index.php">Повернутися на головну сторінку</a></p>
</body>

</html>