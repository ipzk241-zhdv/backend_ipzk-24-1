<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6 Task 1</title>
    <?php
    session_start();
    ?>
    <script src="js/async.js" defer type="module"></script>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        input {
            width: 145px;
        }
        * {
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .m-t35 {
            margin-top: 35px;
        }

        .padding-custom {
            padding: 5px 16px;
        }

        .width200 {
            width: 200px;
        }

        .width100prc {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="content" class="width100prc">
        </div>
    </div>
</body>

</html>