<?php
// Lab1 task6
$numbers = [(string) rand(100, 999), "якийсь текст", rand(100, 999), rand(100, 999), rand(100, 999), rand(100, 999), rand(100, 999)];

function summOfDigits($number): ?int
{
    if (is_numeric($number)) { // якщо число (також опрацьовує тип даних string)
        $strNumber = str_split((string) $number); // приводимо до типу string та розбиваємо на масив
        $output = 0;
        foreach ($strNumber as $digit) {
            $output = $output + $digit; // сумуємо елементи масиву
        }
        return $output;
    } else {
        return null;
    }
}

function reverseNumber($number): ?string
{
    if (is_numeric($number)) { // якщо число (також опрацьовує тип даних string)
        $strNumber = (string) $number; // приводимо до типу string
        $strNumber = strrev($strNumber); // реверсимо
        return $strNumber;
    } else {
        return null;
    }
}

function rearrangeNumbers($number): ?int
{
    if (is_numeric($number)) { // якщо число (також опрацьовує тип даних string)
        $strNumbers = str_split((string) $number); // приводимо до типу string
        arsort($strNumbers, SORT_NUMERIC); // сортуємо отримані числа в порядку спадіння
        return (int) implode($strNumbers); // повертаємо отримане число
    } else {
        return null;
    }
}

// -------------------------------------------
echo "Сума цифр:<br>";
foreach ($numbers as $n) {
    $buf = summOfDigits($n);
    if ($buf != null) {
        echo "Сума цифр числа $n = $buf";
    } else {
        echo "'$n' не є числом";
    }
    echo "<br>";
}
echo "<hr>";
// -------------------------------------------
echo "Обернені числа:<br>";
foreach ($numbers as $n) {
    $buf = reverseNumber($n);
    if ($buf != null) {
        echo "Обернене число $n - $buf";
    } else {
        echo "'$n' не є числом";
    }
    echo "<br>";
}
echo "<hr>";
// -------------------------------------------
echo "Перестановка цифр до найбільшого можливого числа:<br>";
foreach ($numbers as $n) {
    $buf = rearrangeNumbers($n);
    if ($buf != null) {
        echo "Перестановка числа до найбільшого для $n - $buf";
    } else {
        echo "'$n' не є числом";
    }
    echo "<br>";
}
echo "<hr>";
// -------------------------------------------

