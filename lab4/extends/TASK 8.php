<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 4 Inheritance</title>
    <?php
    require_once ("autoload.php");
    ?>
    <style>
        .df {
            display: flex;
        }

        .jc-se {
            justify-content: space-evenly
        }

        .al-ce {
            align-items: center;
        }

        td {
            padding-right: 30px;
        }
    </style>
</head>

<body>
    <div class="df jc-se al-ce">
        <?php
        $human = new Human(180, 19, 70, "зелений");
        $student = new Student(190, 21, 80, "голубий", 2, 2048, "ВСП ЖТФК КНУБА");
        $programmer = new Programmer(173, 30, 85, "сірий", ["C#", "PHP", "SQL"], 3);
        $classes = [$human, $student, $programmer];
        ?>

        <table>
            <tr>
                <th>Human до змін</th>
                <th>Student до змін</th>
                <th>Programmer до змін</th>
            </tr>
            <tr>
                <?php
                foreach ($classes as $class) {
                    echo "<td>" . $class->__toString() . "</td>";
                }
                ?>
            </tr>
        </table>
    </div>
    <hr>
    <div class="df jc-se al-ce">
        <?php
        $human->setColorOfEyes("якийсьНовийКолірОчей");
        $human->setHeight(2000);
        $human->setMass(500);

        $student->toNewCourse();
        $student->setCollege("ІншийКоледж");
        $student->setMass(-500);

        $programmer->setYearsExperiance(1200);
        $programmer->addProgramLanguage("НоваМП");
        $programmer->addProgramLanguage("МоваПрограмування2000SuperDeluxeProNote10");
        $programmer->setYearsOld(9999);

        $classes = [$human, $student, $programmer];
        ?>

        <table>
            <tr>
                <th>Human після змін</th>
                <th>Student після змін</th>
                <th>Programmer після змін</th>
            </tr>
            <tr>
                <?php
                foreach ($classes as $class) {
                    echo "<td>" . $class->__toString() . "</td>";
                }
                ?>
            </tr>
        </table>
    </div>
</body>

</html>