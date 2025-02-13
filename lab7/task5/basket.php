<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 7 Task 5</title>
    <?php
    session_start();

    $isEmpty = false;

    $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
    try {
        $pdo = new PDO($dsn, 'homeuser', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode($e->getMessage());
        return;
    }

    if (empty($_SESSION["basket"])) {
        $isEmpty = true;
    } else {
        $idItems = $_SESSION["basket"];
        sort($idItems);
        $unique = array_unique($idItems);
        $counts = array_count_values($idItems);
        $items = [];
        foreach ($unique as $id) {
            $sql = "SELECT * FROM shop WHERE id = :id";
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":id", $id);
            $sth->execute();
            array_push($items, $sth->fetch(PDO::FETCH_ASSOC));
        }
    }
    ?>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        input {
            width: 145px;
        }

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
    </style>
</head>

<body>
    <?php if (!$isEmpty): ?>
        <?php
        echo "<table>";
        echo "<tr>";
        foreach (array_keys($items[0]) as $key) {
            echo "<th>$key</th>";
        }
        echo "<th>amount</th>";
        echo "</tr>";
        foreach ($items as $item) {
            echo "<tr>";
            foreach ($item as $key => $value) {
                echo "<td>$value</td>";
            }
            echo "<td>" . $counts[$item['id']] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    <?php else: ?>
        <p>Кошик порожній</p>
    <?php endif; ?>
    <a href="index.php">Назад до магазину</a><br>

</body>

</html>