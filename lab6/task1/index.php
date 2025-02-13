<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6 Task 1</title>
    <?php
    session_start();
    ?>
    <script src="js/async.js" defer></script>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        #register {
            display: none;
        }

        #log-in {
            display: block;
        }

        #content {
            display: none;
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
        <div id="register">
            <p>Реєстрація</p>
            <table id="table-register">
                <tr>
                    <td>Логін:</td>
                    <td><input type="text" name="reg_login" id="reg_login"></td>
                </tr>
                <tr>
                    <td>Пароль:</td>
                    <td><input type="password" name="reg_password" id="reg_password"></td>
                </tr>
                <tr>
                    <td>Про себе:</td>
                    <td><textarea name="reg_info" id="reg_info" cols="20" rows="5"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button id="reg_create">Реєстрація</button></td>
                </tr>
                <tr>
                    <td>Вже маєте акаунт?</td>
                    <td><button type="button" id="show_log-in">Увійти</button></td>
                </tr>
            </table>
        </div>
        <div id="log-in">
            <p>Вхід</p>
            <table id="table-log-in">
                <tr>
                    <td>Логін:</td>
                    <td><input type="text" name="log-in_login" id="log-in_login"></td>
                </tr>
                <tr>
                    <td>Пароль:</td>
                    <td><input type="password" name="log-in_password" id="log-in_password"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button id="btn-log-in">Вхід</button></td>
                </tr>
                <tr>
                    <td>Ще не маєте акаунту?</td>
                    <td><button type="button" id="show_register">Реєстрація</button></td>
                </tr>
            </table>
        </div>
        <div id="content" class="width100prc">
            <button type="button" id="update-button">Оновити</button>
            <button type="button" id="log-out">Вихід</button>
        </div>
    </div>
</body>

</html>