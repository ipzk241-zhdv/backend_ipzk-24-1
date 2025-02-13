<?php

// Lab2 Array Task 2

$parts = [
    "макс",
    "бел",
    "ла",
    "чар",
    "лі",
    "лю",
    "сі",
    "ба",
    "ді",
    "дей",
    "зі",
    "мол",
    "лі",
    "бей",
    "лі",
    "лу",
    "на",
    "стел",
    "ла"
];

echo GenerateName($parts, 2) . "<br>";
echo GenerateName($parts, 3) . "<br>";
echo GenerateName($parts, 4) . "<br>";
echo GenerateName($parts, 5) . "<br>";

function GenerateName($parts, $amountOfParts): string
{
    shuffle($parts); // перемішати склади
    $name = "";
    for ($i = 0; $i < $amountOfParts; $i++) {
        $name .= $parts[$i]; // об'єднати потрібну кількість випадкових складів
    }
    
    $name = mb_str_split($name); // розділити рядок на масив символів
    $name[0] = mb_strtoupper($name[0]); // для того, щоб капіталізувати перший символ
    $name = implode("", $name); // об'єднати масив у рядок

    return $name;
}


