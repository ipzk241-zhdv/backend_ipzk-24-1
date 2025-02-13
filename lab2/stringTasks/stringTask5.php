<?php
// Lab2 String Task 5

// Генератор паролів: Напишіть програму, яка генерує випадковий пароль заданої довжини. 
// Пароль може містити великі та малі літери, цифри та спеціальні символи.

// Перевірка пароля: Реалізуйте функцію, яка перевіряє, чи є 
// введений користувачем пароль достатньо міцним. Вважайте пароль міцним, 
// якщо він містить принаймні одну велику літеру, одну малу літеру, одну цифру та 
// один спеціальний символ, і його довжина є не менше 8 символів.

$keys = [
    "bigChars" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
    "smallChars" => "abcdefghijklmnopqrstuvwxyz",
    "numbers" => "0123456789",
    "symbolChars" => "!@#$%^&*()_+-=",
];

function GeneratePassword($length, $keys, $minLenghtOfChars): ?string
{
    if ($length < 8) {
        return null;
    }

    $k = array_keys($keys); // забрати ключі для асоціативного масиву
    shuffle($k); // перемішати ці ключи
    $output = "";
    for ($i = 0; $i < count($k); $i++) { // перебрати масив символів
        $buf = str_shuffle($keys[$k[$i]]); // перемішати масив символів
        if ($i + 1 > count($k) - 1) { // якщо це остання ітерація, то замість рандомного числа підставити
            $randLength = $length;    // кількість символів, що не вистачає
        } else {
            $randLength = RandomAmount($minLenghtOfChars, count($keys) - $i, $length);
            // призначити випадкову кількість потрібних символів
        }
        $buf = substr($buf, 0, $randLength); // обрізати масив символів до потрібної довжини
        $output = $output . $buf; // додати до результату
        $length = $length - $randLength; // змінити кількість символів, що залишились
    }
    return str_shuffle($output); // перемішати результат ще раз
}

function RandomAmount($minLenghtOfChars, $amountOfTypes, $length): ?int
{
    return rand($minLenghtOfChars, $length - ($minLenghtOfChars * $amountOfTypes)); // призначити випадкову кількість потрібних символів
}

function CheckPassword($password)
{
    if (strlen($password) < 8) {
        return false;
    }
    if (!preg_match('/[A-Z]/', $password)) { // не містить великої літери
        return false;
    }
    if (!preg_match('/[a-z]/', $password)) { // не містить маленької літери
        return false;
    }
    if (!preg_match('/\d/', $password)) { // не містить цифри
        return false;
    }
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) { // не містить спец. символу
        return false;
    }
    return true;
}

(string) $out = GeneratePassword(15, $keys, 2);
echo "Згенерований пароль: " . $out;
var_dump($out);
if (CheckPassword($out)) {
    echo "Пароль достатньо міцний<br>";
} else {
    echo "<hr>Пароль не достатньо міцний<hr>";
}
