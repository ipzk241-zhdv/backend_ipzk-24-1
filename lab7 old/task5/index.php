<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab7 Task 5</title>
    <?php
    session_start();
    ?>
    <script src="async.js" defer>

    </script>
    <style>
        #content {
            margin-top: 80px;
        }

        .header {
            display: flex;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            justify-content: space-between;
            padding: 10px 80px;
        }

        .row {
            display: flex;
            justify-content: space-around;
            border: 1px solid red;
            margin-top: 50px;
            height: 250px;
        }

        .item {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            border: 1px solid purple;
            width: 150px;
            width: 15%;
        }

        a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Shop 1</h1>
        <h1 id="basket">Кошик</h1>
    </div>
    <div id="content">

    </div>
    </div>
</body>

</html>