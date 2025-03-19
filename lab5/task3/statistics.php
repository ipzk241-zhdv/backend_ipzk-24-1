<?php

$error = false;
$dsn = "mysql:host=localhost;dbname=company_db;charset=utf8";
$table = "employees";
try {
    $pdo = new PDO($dsn, 'homeuser', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = true;
    echo $e->getMessage();
}

if (!$error) {
    $sql = "SELECT * FROM $table ORDER BY id ASC"; // підвантаження списку всіх продуктів
    $employees = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $positions;
    if (count($employees) > 0) {
        $average_salary = 0;
        foreach ($employees as $employee) {
            $average_salary += $employee['salary'];
        }
        $positions = array_column($employees, 'position');
        $position_counts = array_count_values($positions);
        $average_salary /= count($employees);
        echo "Середня заробітна плата " . number_format($average_salary, 2) . "<br>" ;
        echo "Кількість працівників на кожній посаді:";
        var_dump($position_counts);
    }
}
