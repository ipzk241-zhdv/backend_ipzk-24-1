<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab5 Task 2</title>
    <?php

    $missing = false;
    $wrong = false;
    $error = false;
    $table = "products";
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            $error = true;
        }

        if (!$error) {
            if (isset($_POST["edit"])) { // якщо метод POST і в ньому є edit
                if (strlen($_POST["edit"]) > 0) {
                    $toEdit = $_POST["edit"];
                } else {
                    $missing = true; // якщо не вказан id продукту
                }
            } else { // якщо метод POST і в ньому нема edit
                $set = "";
                foreach ($_POST as $key => $value) { // перебір всіх ключів і занесення їх в 
                    if ($key == "id") {              // $set для використання в $sql чуть нижче
                        continue;
                    }
                    $set .= "$key = :$key, ";
                }
                $set = substr($set, 0, -2); // видалити зайві символи ", "
                $sql = "UPDATE $table SET $set WHERE id = :id";
                $sth = $pdo->prepare($sql); // підготовка sql запиту
                foreach ($_POST as $key => $value) {
                    $sth->bindValue(":$key", $value); // підстановка всіх значень
                }
                $sth->execute();
                $missing = false;
                $toEdit = $_POST['id'];
            }

            if (!$missing) {
                $sql = "SELECT * FROM $table WHERE id = :id"; // підвантаження інформації про продукт або
                $sth = $pdo->prepare($sql);                     // підвантаження вже зміненної інформації про продукт
                $sth->bindValue(":id", $toEdit);
                $sth->execute();
                $product = $sth->fetch(PDO::FETCH_ASSOC);
                if ($product === false) { // якщо запит повернув false, продукту з таким id немає
                    $wrong = true;
                } else {
                    $canChange = [ // ассоціативний масив для динамічного створення таблиці з можливостю редагування продукту
                        "id" => 'type="number" name="id" readonly value="' . $product['id'] . '"',
                        "name" => 'type="text" name="name" value="' . $product['name'] . '"',
                        "cost" => 'type="number" min="1" name="cost" value="' . $product['cost'] . '"',
                        "amount" => 'type="number" min="1" name="amount" value="' . $product['amount'] . '"',
                        "date" => 'type="date" name="date" value="' . $product['date'] . '"'
                    ];
                }
            }
        }

    }
    ?>
    <style>
        * {
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .m-t35 {
            margin-top: 35px;
        }

        .padding-custom {
            padding: 5px 16px;
        }

        .width200 {
            width: 200px;
        }
    </style>
</head>

<body>
    <!-- опрацювання помилок -->
    <?php if (!$error): ?>
        <?php if ($missing): ?>
            <p>id не був переданий!</p>
        <?php elseif ($wrong): ?>
            <p>Продукту з id - <?= $toEdit ?> не знайдено!</p>
        <?php else: ?>
            <form method="POST" action="">
                <table>
                    <tr>
                        <?php
                        foreach ($product as $key => $value) { // відображення назв всіх полів таблиці з бд
                            echo "<td>$key</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        foreach ($product as $key => $value) { // відображення значень ціх полів
                            echo "<td>$value</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        // створення input'ів для кожного ключа за допомогою масиву $canChange
                        foreach ($product as $key => $value) {
                            $buf = in_array($key, array_keys($canChange)) ? "<input " . $canChange[$key] . ">" : "";
                            echo "<td>" . $buf . "</td>";
                        }
                        ?>
                    </tr>
                </table>
                <button class="m-t35 padding-custom width200">Редагувати</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
    <a href="index.php"><button class="m-t35 padding-custom width200">До головного меню</button></a>

</body>

</html>