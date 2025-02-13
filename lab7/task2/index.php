<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 7 Task 2</title>
    <?php

    $cache_path = "cache.txt";
    $table = "menu";

    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (isset($_GET['delete'])) {
            deleteId($_GET['delete'], $table, $cache_path);
            unset($_GET['delete']);
        }
    }

    function deleteId($id, $table, $cache_path)
    {
        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        $sql = "DELETE from $table where id = :id";
        $sth = $pdo->prepare($sql);
        $sth->bindValue(":id", $id);
        $sth->execute();

        updateCache($cache_path, $table);
    }

    function getMenuItems(string $cache_path, $table)
    {
        $isOutdated = time() - filemtime($cache_path) > 3600 /* 3600 x 24 */ ? true : false;
        // якщо файл не оновлювався більше 24 годин, то він застарів
    
        if ($isOutdated) {
            echo updateCache($cache_path, $table);
            return;
        } else {
            $menu = file_get_contents($cache_path);
            echo $menu;
        }
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
    <?php
    getMenuItems($cache_path, $table)
        ?>
        <a href="add.php">Додати</a>
</body>

</html>