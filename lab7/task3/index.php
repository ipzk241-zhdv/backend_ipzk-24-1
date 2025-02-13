<?php
session_start();
$dsn = "mysql:host=localhost;dbname=lab5;charset=utf8";
try {
    $pdo = new PDO($dsn, 'homeuser', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $user_id = session_id();

    ob_start();
    echo $content;
    $content_buffered = ob_get_contents();
    ob_end_clean();

    $sth = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)");

    $sth->bindValue(":user_id", $user_id);
    $sth->bindValue(":title", $title);
    $sth->bindValue(":content", $content_buffered);

    $sth->execute();

    header("Location: index.php");
    exit();
}


$sth = $pdo->query("SELECT * FROM posts ORDER BY posts.created_at DESC");
$posts = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>
    <h1>Blog</h1>
    <form action="" method="POST">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="content">Content:</label><br>
        <textarea id="content" name="content"></textarea><br>
        <input type="submit" value="Add Post">
    </form>

    <hr>
    <?php foreach ($posts as $post): ?>
        <div>
            <h2><?php echo $post['title']; ?></h2>
            <p><?php echo $post['content']; ?></p>
            <p>Posted by: <?php echo $post['user_id']; ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
</body>

</html>