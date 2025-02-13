<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab2 Function Task</title>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        require_once "./functions/func.php";

        $x = $_POST["x"];
        $y = $_POST["y"];

    } else {
        header("Location: index.php");
        die;
    }
    ?>
    <style>
        table {
            border-collapse: collapse;
        }

        th {
            background-color: yellow;
            font-size: 30px;
            height: 80px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>
<table>
    <tr>
        <th>x^y</th>
        <th>x!</th>
        <th>my_tg(x)</th>
        <th>sin(x)</th>
        <th>cos(x)</th>
    </tr>
    <tr>
        <td><?= MyPower($x, $y) ?></td>
        <td><?= MyFactorial($x) ?></td>
        <td><?= MyTg($x) ?></td>
        <td><?= MySin($x) ?></td>
        <td><?= MyCos($x) ?></td>
    </tr>
</table>

<body>

</body>

</html>