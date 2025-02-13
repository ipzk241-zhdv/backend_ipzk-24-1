<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab1 Task 7-2</title>
    <style>
        * {
            font-size: 25px;
        }
    </style>
</head>

<?php


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["amount"])) {
    $amount = $_POST["amount"];
}
?>

<body>
    <form method="POST" action="">
        <table>
            <tr>
                <td>Кількість квадратів</td>
                <td><input name="amount" type="number" value=<?php echo isset($amount) ? $amount : "" ?>></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Створити</button></td>
            </tr>
        </table>
    </form>

    <?php
    if (isset($amount)) {
        for ($i = 0; $i < $amount; $i++) {
            $size = rand(5, 50);
            $style = 'style="position: absolute; width: ' . $size . 'px; height: ' . $size . 'px; background-color: red;';
            $position = 'left: ' . rand(0, 1000) . 'px; top: ' . rand(0, 600) . 'px;"';
            echo "<div $style $position></div>";
        }
    }
    ?>

</body>

</html>