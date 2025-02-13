<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab3 Send Files</title>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
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

    <style>
        .df {
            display: flex;
        }

        .jc-se {
            justify-content: space-evenly
        }

        .al-ce {
            align-items: center;
        }

        .fw {
            flex-wrap: wrap;
        }
        img {
            margin-top: 25px;
            width: 15%;
        }
    </style>
</head>

<body>

    <form method="POST" action="" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Фотографія:</td>
                <td><input type="file" accept="image/png" name="userPhoto" id="userPhoto" multiple></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Відправити"></td>
            </tr>
        </table>
    </form>

    <div class="df jc-se al-ce fw">
        <?php
        $path = "./photos";
        $pathPhotos = scandir($path);
        for ($i = 2; $i < count($pathPhotos); $i++) { // і = 2, оскільки перших два елементи службові
            echo '<img src="' . $path . "/" . $pathPhotos[$i] . '" alt="userImage' . $i - 1 . '">';
        }
        ?>
    </div>
</body>

</html>