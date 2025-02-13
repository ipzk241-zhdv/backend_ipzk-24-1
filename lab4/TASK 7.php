<?php

require_once ("./text/Text.php");

$text = new Text();

echo "Перед записом:<br>";
echo "1.txt: ";
echo $text::ReadFromFile("1.txt");
echo "<br>2.txt: ";
echo $text::ReadFromFile("2.txt");
echo "<br>2.txt: ";
echo $text::ReadFromFile("3.txt");
echo "<hr>";

$text::WriteToFile("1.txt", "some new content");
$text::WriteToFile("2.txt", "some other new conter");
$text::WriteToFile("3.txt", "some other other new content");

echo "Після запису:<br>";
echo "1.txt: ";
echo $text::ReadFromFile("1.txt");
echo "<br>2.txt: ";
echo $text::ReadFromFile("2.txt");
echo "<br>2.txt: ";
echo $text::ReadFromFile("3.txt");
echo "<hr>";

$text::ClearFile("1.txt");
$text::ClearFile("2.txt");
$text::ClearFile("3.txt");