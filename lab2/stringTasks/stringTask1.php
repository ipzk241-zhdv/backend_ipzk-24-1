<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab2 String Task 1</title>
    <style>
        * {
            font-size: 25px;
        }
    </style>
</head>

<?php

$createOutput = false;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['inputText']) && isset($_POST['findChar']) && isset($_POST['changeChar'])) {
    $inputText = $_POST['inputText'];
    $findChar = $_POST['findChar'];
    $changeChar = $_POST['changeChar'];
    $createOutput = true;
}
?>

<body>
    <form method="POST" action="">
        <table>
            <tr>
                <td>Текст</td>
                <td><textarea name="inputText" type="text" style="height:150px; width: 311px;"></textarea></td>
            </tr>
            <tr>
                <td>Знайти символ</td>
                <td><input name="findChar" type="text" maxlength="1" value=<?php echo isset($findChar) ? $findChar : "" ?>></td>
            </tr>
            <tr>
                <td>Замінити на</td>
                <td><input name="changeChar" type="text" maxlength="1" value=<?php echo isset($changeChar) ? $changeChar : "" ?>>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Результат</button></td>
            </tr>
            <?php
            if ($createOutput) {
                echo "<tr><td></td><td>";
                $value = str_replace($findChar, $changeChar, $inputText);
                echo $value;
                echo "</td></tr>";
            }
            ?>
        </table>
    </form>



</body>



</html>