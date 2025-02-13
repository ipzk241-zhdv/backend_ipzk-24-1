<?php

// Lab2 Array Task 1

$someArray = [];
$toFill = 20; // кількість елементів масиву

for ($i = 0; $i < $toFill; $i++) {
    array_push($someArray, rand(0, 10)); // наповнення випадковими значенням
}

var_dump($someArray);
IdenticalNumbers($someArray);


function IdenticalNumbers($someArray): void
{
    $output = [];
    $iterations = count($someArray);
    $counter = 0;
    for ($i = 1; $i < $iterations; $i++) {
        if ($someArray[$counter] == $someArray[$i] && !in_array($someArray[$i], $output)) {
            array_push($output, $someArray[$i]); // якщо числа повторюються і таке число ще не було виписане
        }
        $counter++;
    }

    echo "Повторювані елементи:<br>";
    for ($i = 0; $i < count($output); $i++) {
        echo $i + 1 . ") " . $output[$i] . "<br>";
    }
    return;
}



