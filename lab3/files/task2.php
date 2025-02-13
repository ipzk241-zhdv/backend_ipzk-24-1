<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3, File Task 2</title>
    <?php
    // Lab 3, File Task 2
    
    $words1 = file_get_contents("./task2files/first.txt");
    $words2 = file_get_contents("./task2files/second.txt");

    $words1 = explode(" ", $words1);
    $words2 = explode(" ", $words2);

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        foreach ($_POST as $key => $value) { // перебрати ключі і значення масиву _POST
            if (strlen($_POST[$key]) > 0) { // якщо довжина значення ключа більша за 0 (дефакто, встановлена)
                if (str_starts_with($key, "delete")) {
                    deleteFile($key);
                } else {
                    $key($words1, $words2); // автоматичний визов методу
                }
            }
        }
    }

    function deleteFile($fileName)
    {
        $path = str_replace("delete", "", $fileName);
        $path = "./task2files/" . $path . ".txt";
        if (is_file($path)) {
            unlink($path);
        }
    }

    function uniqueWordsInFirstFile($words1, $words2): void
    {
        $uniqueWordsInFirstFile = array_diff($words1, $words2);
        $uniqueWordsInFirstFile = implode(" ", $uniqueWordsInFirstFile);
        file_put_contents("./task2files/uniqueWordsInFirstFile.txt", $uniqueWordsInFirstFile);
    }

    function identicalWordsInFiles($words1, $words2): void
    {
        $identicalWordsInFiles = array_intersect($words1, $words2);
        $identicalWordsInFiles = implode(" ", $identicalWordsInFiles);
        file_put_contents("./task2files/identicalWordsInFiles.txt", $identicalWordsInFiles);
    }


    function countValues($words1, $words2): void
    {
        $countValues = array_count_values(array_merge($words1, $words2));
        foreach ($countValues as $key => $value) {
            if ($value < 3) {
                unset($countValues[$key]);
            }
        }
        file_put_contents("./task2files/countValues.txt", implode(" ", array_keys($countValues)));
    }

    function GetFileContents($path, $separator): array
    {
        $content = file_get_contents($path);
        $content = explode($separator, $content);
        for ($i = count($content) - 1; $i > -1; $i--) {
            if ($content[$i] === '') {
                array_pop($content);
            } else {
                break;
            }
        }
        return $content;
    }

    function GetFileNames($path): array
    {
        return scandir($path);
    }

    function PrintContent(array $content, string $caption): void
    {
        echo "<table><th>$caption</th>";
        for ($i = 0; $i < count($content); $i++) {
            echo "<tr>";
            echo "<td>" . $i + 1 . "</td><td>" . $content[$i] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
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
    </style>
</head>

<body>
    <div class="df jc-se al-ce">
        <?php
        PrintContent($words1, "FirstFile.txt");
        PrintContent($words2, "SecondFile.txt");
        ?>
    </div>
    <form method="post" action="">
        <div class="df jc-se al-ce">
            <input type="submit" name="uniqueWordsInFirstFile"
                value="Створити файл з унікальними словами першого файлу">
            <input type="submit" name="identicalWordsInFiles"
                value="Створити файл зі словами, які зустрічаються в обох файлах">
            <input type="submit" name="countValues"
                value="Створити файл зі словами, які зустрічаються в обох файлах більше 2 раз">
        </div>
        <hr>
    </form>
    <div class="df jc-se al-ce">
        <?php
        $notUsedFiles = [".", "..", "first.txt", "second.txt"];
        $files = GetFileNames("./task2files/");

        foreach ($files as $key => $file) {
            if (in_array($file, $notUsedFiles)) {
                unset($files[$key]);
            }
        }

        sort($files); // встановити заново ключі
        
        for ($i = 0; $i < count($files); $i++) {
            $bufWords = GetFileContents("./task2files/" . $files[$i], " ");
            PrintContent($bufWords, $files[$i]);
        }
        ?>
    </div>

    <form method="post" action="">
        <?php
        for ($i = 0; $i < count($files); $i++) {
            $files[$i] = "delete" . $files[$i];
            $files[$i] = str_replace(".txt", "", $files[$i]);
        }

        ?>
        <div class="df jc-se al-ce">
            <?php
            for ($i = 0; $i < count($files); $i++) {
                echo '<input type="submit" name="' . $files[$i] . '"
                value="' . $files[$i] . '">';
            }
            ?>
        </div>
    </form>
</body>

</html>