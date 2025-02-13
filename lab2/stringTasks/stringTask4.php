<?php
// Lab2 String Task 4

$realeseDate = "09.07.2013";
$patch735dDate = "19.04.2024";

$output = "Дата виходу гри: " . $realeseDate . "<br>Дата виходу останнього патчу: " . $patch735dDate . "<br>";

$realeseDate = strtotime($realeseDate);
$patch735dDate = strtotime($patch735dDate);

$differenceInDays = ceil(($patch735dDate - $realeseDate) / 60 / 60 / 24); // ceil - округлення
echo $output . "Різниця в днях: " . $differenceInDays . "<br>Різниця в годинах: " . $differenceInDays * 24;
