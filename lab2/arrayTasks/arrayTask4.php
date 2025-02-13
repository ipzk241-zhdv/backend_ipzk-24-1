<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab2 Array Task 4</title>
    <style>
        * {
            font-size: 20px;
        }

        .content {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
        }
    </style>
</head>

<body>
    <div class="content">
        <?php
        $names = [];

        for ($i = 0; $i < 10; $i++) {
            $names["name_$i$i$i"] = ($i + 1) * rand(3, 11); // створення асоціативного масиву
        }

        PrintAssociativeArray($names, "До сортування");
        $names = SortAssociative($names, false, false);
        PrintAssociativeArray($names, "За спадаючим значенням");
        $names = SortAssociative($names, true, false);
        PrintAssociativeArray($names, "За спадаючими ключами");
        ?>
    </div>
    <div class="content" style="margin-top: 50px;">
        <?php
        $names = SortAssociative($names, false, true);
        PrintAssociativeArray($names, "За зростаючим значенням");
        ?>
    </div>
</body>

</html>

<?php

// Lab2 Array Task 3


function SortAssociative(array $associativeArray, bool $sortByKey, bool $ascending): ?array
{
    if ($sortByKey) { // якщо сортувати за ключами
        $ascending ? ksort($associativeArray) : krsort($associativeArray); // сортувати на зростання чи спадання
    } else {
        $ascending ? asort($associativeArray) : arsort($associativeArray);
    }
    return $associativeArray;
}

function PrintAssociativeArray(array $array, string $caption): void
{
    echo "<table><tr><td>$caption</td></tr>";
    foreach ($array as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td></tr>";
    }
    echo "</table>";
}