<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 4 Tasks</title>
    <?php
    use classList\Controllers\UserController;
    use classList\Models\UserModel;
    use classList\Views\UserView;
    use classList\Circles\Circle;

    include_once ("./autoload.php");
    ?>
</head>

<body>
    <?php
    $controller = new UserController();
    echo $controller->Controller();
    echo "<br>";
    $model = new UserModel();
    echo $model->Model();
    echo "<br>";
    $view = new UserView();
    echo $view->View();
    echo "<hr>";

    $circle1 = new Circle(0, 0, 5);
    echo $circle1->__toString();
    $circle1->SetX(3);
    echo "<br>x = " . $circle1->GetX() . ", y = " . $circle1->GetY() . ", r = " . $circle1->GetRadius();
    echo "<br>";

    $circle2 = new Circle(1, 1, 5);
    $circle3 = new Circle(20, 1, 5);

    if ($circle1->IntersectOther($circle2)) {
        echo $circle1->__toString() . " перетинає " . $circle2->__toString();
        echo "<br>";
    }
    if (!$circle1->IntersectOther($circle3)) {
        echo $circle1->__toString() . " не перетинає " . $circle3->__toString();
        echo "<br>";
    }

    ?>
</body>

</html>