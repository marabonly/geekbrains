<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            font-size: 24px;
        }
        input[type=submit] {
            width: 40px;
        }
        .bottom-margin {
            margin-bottom: 10px;
        }
        label {
            display: inline-block;
            width: 200px;
        }
    </style>
</head>

<body>

    <form method="post">

        <div class="bottom-margin">
            <label>Первый операнд</label>
            <input type="text" name="first">
        </div>

        <div class="bottom-margin">
            <label>Второй операнд</label>
            <input type="text" name="second">
        </div>

        <div class="bottom-margin">
            <label>Операция</label>
            <input type="submit" name="operation" value="+">
            <input type="submit" name="operation" value="-">
            <input type="submit" name="operation" value="*">
            <input type="submit" name="operation" value="/">
        </div>

    </form>

    <?php

    if (isset($_POST["first"]))
    {
        $a = (float)$_POST["first"];
        $b = (float)$_POST["second"];

        switch ($_POST["operation"])
        {
            case "+": $result = $a + $b; break;
            case "-": $result = $a - $b; break;
            case "*": $result = $a * $b; break;
            case "/":
                if ($b == 0)
                    $result = "∞";
                else
                    $result = $a / $b; 

                break;
        }

        echo "<p>Результат: " . $result . "</p>";
    }

    ?>

    </body>

</html>