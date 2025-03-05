<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab3 Send Files</title>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (!empty($_FILES['userPhoto']['name'][0])) { // Перевіряємо, чи були завантажені файли
            foreach ($_FILES['userPhoto']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['userPhoto']['error'][$key] == 0) { // Якщо немає помилок
                    $i = uniqid();
                    do {
                        $path = "./photos/$i.png";
                        $i = uniqid();
                    } while (is_file($path));

                    move_uploaded_file($tmp_name, $path);
                }
            }
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
                <td><input type="file" accept="image/png" name="userPhoto[]" id="userPhoto" multiple></td>
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