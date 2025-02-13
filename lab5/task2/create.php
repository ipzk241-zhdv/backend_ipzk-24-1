<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab5 Task 2</title>
    <?php

    $missing = false;
    $error = false;
    $created = false;
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
            $sqlkeys = "(:id, ";
            foreach ($_POST as $key => $value) {
                if (strlen($value) > 0) {
                    $sqlkeys .= ":$key, ";
                } else {
                    $missing = true;
                }
            }
            if (!$missing) {
                $sqlkeys = substr($sqlkeys, 0, -2);
                $sqlkeys .= ")";
                $sql = "INSERT INTO $table VALUES $sqlkeys";
                $sth = $pdo->prepare($sql);
                foreach ($_POST as $key => $value) {
                    $sth->bindValue(":$key", $value);
                }
                $sth->bindValue(":id", null);
                $sth->execute();
                $created = true;
            }
        }

    }

    $canChange = [ // ассоціативний масив для динамічного створення таблиці
        "name" => 'type="text" name="name"',
        "cost" => 'type="number" min="1" name="cost"',
        "amount" => 'type="number" min="1" name="amount"',
        "date" => 'type="date" name="date"'
    ];
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
            <p>Жодне поле не може бути пустим!</p>
        <?php else: ?>
            <form method="POST" action="">
                <table>
                    <tr>
                        <?php
                        foreach ($canChange as $key => $value) { // відображення назв всіх полів
                            echo "<td>$key</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        // створення input'ів для кожного ключа за допомогою масиву $canChange
                        foreach ($canChange as $key => $value) {
                            $buf = "<input " . $canChange[$key] . ">";
                            echo "<td>" . $buf . "</td>";
                        }
                        ?>
                    </tr>
                </table>
                <?php if ($created): ?>
                    <p>Запис успішно додано!</p>
                <?php endif; ?>
                <button class="m-t35 padding-custom width200">Створити</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
    <a href="index.php"><button class="m-t35 padding-custom width200">До головного меню</button></a>

</body>

</html>