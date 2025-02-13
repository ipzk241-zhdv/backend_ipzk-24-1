<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab1 Task 3</title>
    <style>
        * {
            font-size: 25px;
        }
    </style>
</head>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST" && (float) $_POST["amount"] > 0 && isset($_POST["USDtoUAH"])) {
    // якщо метод пост, вказана кількість і курс валют
    $amount = $_POST["amount"];
    $rate = $_POST["USDtoUAH"];
    $output = "$amount гривень(ні) можна обміняти на " . number_format((float) $amount / (float) $rate, 2, ".") . " долар(ів)";
}
?>

<body>
    <form method="POST" action="">
        <table>
            <tr>
                <td>Курс долару до гривні</td>
                <td><input name="USDtoUAH" type="number" value="39.70"></td>
                <!-- за замовчуванням курс 39.70 -->
            </tr>
            <tr>
                <td>Кількість гривень</td>
                <td><input name="amount" type="number" value=<?php echo isset($amount) ? $amount : "" ?>></td>
                <!-- якщо є кількість, вставити її -->
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Перевести гривні в долари</button></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php if (isset($output)) {
                        echo $output;
                        // якщо є результат, вивести його
                        // можна було б виводити повністю тег tr при наявності змінної, щоб не ломати структуру
                    }
                    ?>
                </td>
            </tr>
        </table>
    </form>

</body>



</html>