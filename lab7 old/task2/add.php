<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 7 Task 2</title>

    <?php

    $cache_path = "cache.txt";
    $table = "menu";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        foreach ($_POST as $key => $value) {
            $values[$key] = $value;
        }
        addItem($table, $values, $cache_path);

    }

    function addItem($table, $values, $cache_path)
    {
        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        $into = "(";
        $set = "(";
        foreach ($values as $key => $value) {
            $set .= "$key, ";
            $into .= ":$key, ";
        }

        $into = substr($into, 0, -2) . ")";
        $set = substr($set, 0, -2) . ")";

        $sql = "INSERT INTO $table $set VALUES $into";
        $sth = $pdo->prepare($sql);

        foreach ($values as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
        updateCache($cache_path, $table);
        echo "Updated";
    }

    function getKeys($table)
    {
        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        $sql = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA = 'lab5' ORDER BY ORDINAL_POSITION";
        $sth = $pdo->prepare($sql);
        $sth->execute();
        $keys = $sth->fetchAll(PDO::FETCH_COLUMN);
        return $keys;
    }

    function printAdd($table)
    {
        $keys = getKeys($table);
        unset($keys[0]); // id
        echo "<table>";

        echo "<tr>";
        foreach ($keys as $key) {
            echo "<th>$key</th>";
        }
        echo "</tr>";

        echo "<tr>";
        foreach ($keys as $key) {
            echo "<td>";
            echo '<input type="text" required name="' . $key . '">';
            echo "</td>";
        }
        echo "</tr>";

        echo "</table>";
    }

    function updateCache($cache_path, $table)
    {
        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        $sql = "SELECT * from $table ORDER BY id ASC";
        $items = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        if (count($items) > 0) {
            ob_start();

            echo "<table>";
            echo "<tr>";
            foreach (array_keys($items[0]) as $key) {
                echo "<th>$key</th>";
            }
            echo "<th>delete</th>";
            echo "</tr>";
            foreach ($items as $item) {
                echo "<tr>";
                foreach ($item as $key => $value) {
                    echo "<td>$value</td>";
                }
                echo '<td><a href="?delete=' . $item['id'] . '"><button>Видалити</button></a></td>';
                echo "</tr>";
            }
            echo "</table>";

            $menu = ob_get_clean();
            file_put_contents($cache_path, $menu);
            return $menu;
        } else {
            file_put_contents($cache_path, "Пуста таблиця");
            return "Пуста таблиця";
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
    </style>
</head>

<body>
    <form method="POST" action="">
        <?php
        printAdd($table);
        ?>
        <input type="submit" value="Додати">
        <a href="index.php">Назад</a>
    </form>
</body>

</html>