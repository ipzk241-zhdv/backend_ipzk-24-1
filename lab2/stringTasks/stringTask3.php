<?php
// Lab2 String Task 3

$pathToFile = "D: \ WebServers \ home \ testsite \ www \ myfile.txt";
$pathToFile = str_replace(' ', "", $pathToFile); // опціонально видалити пробіли
$file = pathinfo($pathToFile, PATHINFO_FILENAME);
echo "Шлях до файлу: $pathToFile<br>Назва файлу без розширення: $file";
