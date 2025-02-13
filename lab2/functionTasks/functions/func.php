<?php

function MySin($angleInDegrees): float
{
    $angleRadians = deg2rad($angleInDegrees); // кут в радіани
    return sin($angleRadians);
}

function MyCos($angleInDegrees): float
{
    $angleRadians = deg2rad($angleInDegrees); // кут в радіани
    return cos($angleRadians);
}

function MyTg($angleInDegrees): float
{
    $angleRadians = deg2rad($angleInDegrees); // кут в радіани
    return tan($angleRadians);
}

function MyPower($number, $power): float|int
{
    $output = $number;
    $counter = 1;
    do
    {
        $output = $output * $number;
        $counter++;
    } while ($counter != $power - 1);
    return $output;
}

function MyFactorial($number): int
{
    $output = $number;
    $counter = 1;
    do
    {
        $output = $output * ($number - $counter);
        $counter++;
    } while ($number != $counter);
    return $output;
}