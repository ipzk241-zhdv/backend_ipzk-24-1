<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab3 File</title>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        foreach ($_POST as $key => $value) { // перебрати ключі і значення масиву _POST
            if (strlen($_POST[$key]) > 0) { // якщо довжина значення ключа більша за 0 (дефакто, встановлена)
                $$key = $_POST[$key]; // створити змінну з назвою ключа і її значенням
            }
        }
        if (strlen($_POST["commentName"]) > 0 && strlen($_POST["comment"]) > 0) {
            $commentName = $_POST["commentName"];
            $comment = $_POST["comment"];

            file_put_contents("task1.txt", "$commentName:$comment\n", FILE_APPEND);
        }
    }

    $comments = file_get_contents("task1.txt");
    $comments = explode("\n", $comments);
    for ($i = count($comments) - 1; $i > -1; $i--) {
        if ($comments[$i] === '') {
            array_pop($comments); // якщо елемент порожній, видалити його
        }
    }
    ?>
    <style>

    </style>
</head>

<body>

    <form method="post" action="">
        <table>
            <tr>
                <td>Ім'я</td>
                <td><input type="text" name="commentName"></td>
            </tr>
            <tr>
                <td>Коментар</td>
                <td><input type="text" name="comment"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Відправити"></td>
            </tr>
        </table>
    </form>

    <table>
        <tr>
            <th>Ім'я</th>
            <th>Коментар</th>
        </tr>
        <?php
        for ($i = 0; $i < count($comments); $i++) {
            $buf = explode(":", $comments[$i]);
            echo "<tr>";
            echo "<td>" . $buf[0] . "</td><td>" . $buf[1] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>

</html>