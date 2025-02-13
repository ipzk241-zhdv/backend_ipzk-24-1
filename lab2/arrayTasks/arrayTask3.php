<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab2 Array Task 3</title>
    <style>
        * {
            font-size: 20px;
        }

        .content {
            width: 50%;
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
        }
    </style>
</head>

<body>
    <div class="content">
        <?php
        $a = CreateArray();
        $b = CreateArray();
        $ab = MergeArrays($a, $b);

        PrintArray($a, "Масив А");
        PrintArray($b, "Масив Б");
        PrintArray($ab, "Масив А + Б");
        ?>
    </div>
</body>

</html>

<?php

// Lab2 Array Task 3

function CreateArray(): array
{
    $output = [];
    for ($i = 0; $i < rand(3, 7); $i++) {
        array_push($output, rand(10, 20));
    }
    return $output;
}

function MergeArrays(array $array1, array $array2): array
{
    $output = array_merge($array1, $array2); // об'єднати масиви
    $output = array_unique($output); // видалити повторювані елементи
    sort($output, SORT_NUMERIC); // відсортувати за зростанням
    return $output;
}

function PrintArray(array $array, string $caption): void
{
    echo "<table><tr><td>$caption</td></tr>";
    foreach ($array as $a) {
        echo "<tr><td>$a</td></tr>";
    }
    echo "</table>";
}
?>