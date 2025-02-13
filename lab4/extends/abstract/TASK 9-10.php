<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 4 Inheritance</title>
    <?php
    require_once ("autoload.php");
    ?>
</head>

<body>
    <?php
    $student = new StudentForAbstract(190, 45, 85, "зелений", 4, 4098, "ВСП ЖАТФК");
    $programmer = new ProgrammerForAbstract(187, 37, 89, "сірий", ["Ruby", "Assembler"], 6);

    echo $programmer->childNotify() . "<br><hr>";
    echo $programmer->cleanRoom() . "<br><hr>";
    echo $programmer->cleanKitchen() . "<br><hr>";
    echo $student->childNotify() . "<br><hr>";
    echo $student->cleanRoom() . "<br><hr>";
    echo $student->cleanKitchen() . "<br><hr>";
    ?>
</body>

</html>