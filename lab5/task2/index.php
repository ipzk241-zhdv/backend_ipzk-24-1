<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 5 Task 2</title>

    <?php
    $error = false;
    $deleted = -1;
    $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
    $table = "products";
    try {
        $pdo = new PDO($dsn, 'homeuser', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
        $error = true;
    }

    if (!$error) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST["toDelete"])) {
                if (strlen($_POST["toDelete"]) > 0) { // якщо не порожній
                    $toDelete = $_POST["toDelete"];
                    $sql = "DELETE FROM $table WHERE id = :id"; // то видалити з бд
                    $sth = $pdo->prepare($sql);
                    $sth->bindValue(":id", $toDelete);
                    $sth->execute();
                    $deleted = $toDelete;
                }
            }
        }

        $sql = "SELECT * FROM $table ORDER BY id ASC"; // підвантаження списку всіх продуктів
        $products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
    <?php if (!$error): ?>
        <table>
            <tr>
                <?php
                if (isset($products[0])) {
                    foreach ($products[0] as $key => $value) {
                        echo "<th>" . $key . "</th>"; // створення назв полів з бд
                    }
                }
                ?>
            </tr>
            <?php
            foreach ($products as $product) {
                echo "<tr>";
                foreach ($product as $key => $value) { // підстановка значень для цих полів
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>

        <a href="create.php"><button class="m-t35 padding-custom width200">Додати запис</button></a>
        <div class="df">
            <form method="POST" action="edit.php">
                <button type="submit" class="m-t35 padding-custom width200">Редагувати запис</button>
                <input type="number" name="edit" class="padding-custom" style="width: 120px;" min="1">
            </form>
        </div>
        <div class="df">
            <form method="POST" action="">
                <button class="m-t35 padding-custom width200">Видалити запис</button>
                <input type="number" name="toDelete" class="padding-custom" style="width: 120px;" min="1">
            </form>
        </div>
        <?php if ($deleted != -1): ?>
            <p>Продукт з номером id - <?= $deleted ?> було видалено.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>