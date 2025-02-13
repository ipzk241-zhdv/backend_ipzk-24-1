<?php
$data = file_get_contents("php://input");
$json = json_decode($data, true);

$table = "notes";
$missing = [];
foreach ($json as $key => $value) {
    if (strlen($json[$key]) > 0) {
        $$key = $value;
    } else {
        array_push($missing, $key);
    }
}

switch ($action) {
    case "getContent": {
        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";

        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode($e->getMessage());
            return;
        }

        getContent($pdo, $table);
        break;
    }
    case "delete-id": {
        // чи потрібна тут перевірка, чи прийшов id? ***

        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode($e->getMessage());
            return;
        }

        $sql = "DELETE FROM $table WHERE id = :id";
        $sth = $pdo->prepare($sql);
        $sth->bindValue(":id", $id);
        $sth->execute();
        echo json_encode("Success");
        break;
    }
    case "edit-id": {
        // чи потрібна тут перевірка, чи прийшов id? ***

        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode($e->getMessage());
            return;
        }

        $set = "";

        $sql = "UPDATE $table SET caption = :caption, note = :note, city = :city, isEdited = :isEdited, editedDate = :editedDate WHERE id = :id";
        $sth = $pdo->prepare($sql);
        $sth->bindValue(":id", $id);
        $sth->bindValue(":caption", $caption);
        $sth->bindValue(":note", $note);
        $sth->bindValue(":city", $city);
        $sth->bindValue(":isEdited", $isEdited);
        $sth->bindValue(":editedDate", $editedDate);

        $sth->execute();
        echo json_encode("Success");
        break;
    }
    case "create": {
        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode($e->getMessage());
            return;
        }

        if (!in_array("caption", $missing) && !in_array("note", $missing) && !in_array("author", $missing) && !in_array("city", $missing) && !in_array("created", $missing)) {
            $sql = "INSERT INTO $table (caption, note, author, city, created) VALUES (:caption, :note, :author, :city, :created)";
            $sth = $pdo->prepare($sql);

            $sth->bindValue(":caption", $caption);
            $sth->bindValue(":note", $note);
            $sth->bindValue(":author", $author);
            $sth->bindValue(":city", $city);
            $sth->bindValue(":created", $created);

            $sth->execute();
            echo json_encode("Success " . $caption . $note . $author);
        } else {
            echo json_encode("Failed. Missing " . implode(" ", $missing));
        }
        break;
    }
    default: {
        echo json_encode("Unknown action");
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