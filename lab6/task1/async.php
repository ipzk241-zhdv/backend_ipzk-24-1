<?php
$data = file_get_contents("php://input");
$json = json_decode($data, true);

$table = "users";
$missing = [];
foreach ($json as $key => $value) {
    if (strlen($json[$key]) > 0) {
        $$key = $value;
    } else {
        array_push($missing, $key);
    }
}

switch ($action) {
    case "register": {
        if (!in_array("login", $missing) && !in_array("password", $missing)) {
            if (strlen($password) < 8) {
                echo "Password is to short, 8 characters minimum";
                return;
            }

            $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";

            try {
                $pdo = new PDO($dsn, 'homeuser', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo $e->getMessage();
                return;
            }

            $sql = "SELECT * FROM $table WHERE login = :login LIMIT 1";
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":login", $login);
            $sth->execute();
            $already_exist = $sth->rowCount() > 0 ? true : false;

            if ($already_exist) {
                echo "Login is already taken";
                return;
            }

            $values = [
                "id" => null,
                "login" => $login,
                "password" => $password,
                "info" => in_array("info", $missing) ? "" : $info,
            ];
            register($pdo, $table, $values);
        } else {
            echo "Missing login or password";
        }
        break;
    }
    case "log-in": {
        if (!in_array("login", $missing) && !in_array("password", $missing)) {
            $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";

            try {
                $pdo = new PDO($dsn, 'homeuser', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo $e->getMessage();
                return;
            }

            $values = [
                "login" => $login,
                "password" => $password,
            ];
            login($pdo, $table, $values);
        } else
            echo "Missing login or password";
        break;
    }
    case "getContent": {
        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";

        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }

        getContent($pdo, $table);
        break;
    }
    case "log-out": {
        session_start();
        session_destroy();
        break;
    }
    case "delete-id": {
        // чи потрібна тут перевірка, чи прийшов id? ***

        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }

        $sql = "DELETE FROM $table WHERE id = :id";
        $sth = $pdo->prepare($sql);
        $sth->bindValue(":id", $id);
        $sth->execute();
        break;
    }
    case "edit-id": {
        // чи потрібна тут перевірка, чи прийшов id? ***

        $dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
        try {
            $pdo = new PDO($dsn, 'homeuser', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }

        $sql = "UPDATE $table SET login = :login, password = :password, info = :info WHERE id = :id";
        $sth = $pdo->prepare($sql);
        $sth->bindValue(":id", $id);
        $sth->bindValue(":login", $login);
        $sth->bindValue(":password", $password);
        $sth->bindValue(":info", $info);

        $sth->execute();
        break;
    }
    default: {
        echo "Unknown action";
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

function login($pdo, $table, array $values)
{
    $sql = "SELECT * FROM $table WHERE login = :login AND password = :password LIMIT 1";
    $sth = $pdo->prepare($sql);
    foreach ($values as $key => $value) {
        $sth->bindValue(":$key", $value);
    }
    $logged = $sth->execute();
    if ($logged) {
        session_start();
        $_SESSION["logged"] = true;
        $_SESSION["login"] = $values["login"];
        echo "Logged succesfully";
        return;
    } else {
        echo "Wrong login or password";
        return;
    }
}

function register($pdo, $table, array $values)
{
    $sqlset = "(";
    foreach ($values as $key => $value) {
        $sqlset .= ":$key, ";
    }
    $sqlset = substr($sqlset, 0, -2);
    $sqlset .= ")";

    $sql = "INSERT INTO $table VALUES $sqlset";
    $sth = $pdo->prepare($sql);

    foreach ($values as $key => $value) {
        $sth->bindValue(":$key", $value);
    }

    if ($sth->execute()) {
        echo "Registered successfully";
        session_start();
        $_SESSION["logged"] = true;
        $_SESSION["login"] = $values["login"];
    } else {
        echo "Register error";
    }

}


