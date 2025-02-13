<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab2 String Task 2</title>
    <style>
        * {
            font-size: 25px;
        }
    </style>
</head>

<?php

$createOutput = false;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['inputText'])) {
    $inputText = $_POST['inputText'];
    $createOutput = true;
}
?>

<body>
    <form method="POST" action="">
        <table>
            <tr>
                <td>Назви міст через пробіл</td>
                <td><textarea name="inputText" type="text" style="height:150px; width: 311px;"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Розставити за алфавітом</button></td>
            </tr>
            <?php
            if ($createOutput) {
                echo "<tr><td></td><td>";
                $value = explode(" ", $inputText);
                sort($value);
                $value = implode(", ", $value);
                echo $value;
                echo "</td></tr>";
            }
            ?>
        </table>
    </form>



</body>



</html>