<?php
session_start();
$data = file_get_contents("php://input");
$json = json_decode($data, true);

$table = "shop";
$missing = [];
foreach ($json as $key => $value) {
    if (strlen($json[$key]) > 0) {
        $$key = $value;
    } else {
        array_push($missing, $key);
    }
}
//echo json_encode($action);

$dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";

try {
    $pdo = new PDO($dsn, 'homeuser', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
    return;
}

switch ($action) {
    case "getContent": {
        getContent($pdo, $table);
        break;
    }
    case "addItem": {
        if (empty($_SESSION["basket"])) {
            $_SESSION["basket"] = [];
        }
        array_push($_SESSION["basket"], $id);
        echo json_encode("Success");
        break;
    }
    case "confirm": {
        http_response_code(303);
        echo json_encode("Redirecting...");
        break;
    }
    default: {
        echo json_encode("Unknown action: " . $action);
        break;
    }
}

function getContent($pdo, $table)
{
    $sql = "SELECT * FROM $table ORDER BY id ASC";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}