<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab1 Task 7-1</title>
    <style>
        * {
            font-size: 25px;
        }
    </style>
</head>

<?php
$canCreate = false;
if (isset($_POST["width"])) {
    $width = $_POST["width"];
}
if (isset($_POST["height"])) {
    $height = $_POST["height"];
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && (int) $width > 0 && (int) $height > 0) {
    $canCreate = true;
}
?>

<body>
    <form method="POST" action="">
        <table>
            <tr>
                <td>Ширина</td>
                <td><input name="width" type="number" value=<?php echo isset($width) ? $width : "" ?>></td>
            </tr>
            <tr>
                <td>Висота</td>
                <td><input name="height" type="number" value=<?php echo isset($height) ? $height : "" ?>></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Створити таблицю</button></td>
            </tr>
        </table>
    </form>

    <?php if ($canCreate == true) {
        echo "<table>";
        for ($i = 0; $i < (int) $height; $i++) {
            echo '<tr>';
            for ($j = 0; $j < (int) $width; $j++) {
                $factor = 35; // множник для кольору
                $color = "rgb(" . (MyMap(($i + 1) * $factor)) . ", " . (MyMap(($j + 1) * $factor)) . ", " . (MyMap(($i + $j + 1) * $factor)) . ")";
                echo '<td style="height: 50px;width: 50px; background-color:' . $color . ';"></td>';
            }
            echo "</tr>";
        }

        echo "</table>";
    } ?>

</body>

<?php
function MyMap($value) // масштабування вхідного кольору до діапазону (1,255)
{
    $scaledValue = ($value - 1) / (500 - 1);
    $mappedValue = 1 + $scaledValue * (255 - 1);
    return $mappedValue;
}

?>

</html>