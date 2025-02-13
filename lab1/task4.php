<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab1 Task 4</title>
    <style>
        * {
            font-size: 25px;
        }
    </style>
</head>

<body>
    <!-- було реалізовано 3 різних способи вирішення завдання -->
    <!-- всі 3 варіанти виводять ідентичний результат -->
    <!-- варіанти розділені горизонтальною лінією -->
    <?php
    $month = [rand(1, 12), rand(1, 12), rand(1, 12), rand(1, 12), rand(1, 12),]; // випадкові числа
    $seasonNumbers = [
        0 => [12, 1, 2],
        1 => [3, 4, 5],
        2 => [6, 7, 8],
        3 => [9, 10, 11]
    ];

    $seasonNames = [
        0 => "зима",
        1 => "весна",
        2 => "літо",
        3 => "осінь",
    ];

    foreach ($month as $m) { // перебираємо всі вхідні номери місяців
        foreach ($seasonNumbers as $key => $season) {
            if (in_array($m, $season)) { // якщо вхідний номер місяцю $m є в массиві $season ($seasonNumbers[$i][$j])
                echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[$key] . "<br>"; // то виводимо сезон
            }
        }
    }

    echo "<hr>";

    foreach ($month as $m) { // перебираємо всі вхідні номери місяців
        if (in_array($m, $seasonNumbers[0])) { // напряму перевіряємо чи число $m є в масиві $seasonNumbers[$i]
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[0] . "<br>"; // виводимо сезон
        } else if (in_array($m, $seasonNumbers[1])) {
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[1] . "<br>";
        } else if (in_array($m, $seasonNumbers[2])) {
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[2] . "<br>";
        } else if (in_array($m, $seasonNumbers[3])) {
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[3] . "<br>";
        }
    }
    
    echo "<hr>";

    foreach ($month as $m) {
        if ($m < 3 || $month == 12) {
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[0] . "<br>";
        } else if ($m < 6) {
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[1] . "<br>";
        } else if ($m < 9) {
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[2] . "<br>";
        } else {
            echo "Номер місяця " . $m . " відповідає сезону " . $seasonNames[3] . "<br>";
        }
    }
    ?>
</body>

</html>