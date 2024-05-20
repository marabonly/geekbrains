<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            font-family: Arial;
            font-size: 24px;
        }
    </style>
</head>

<body>

    <form method="post">

        <input type="text" name="first">

        <select name="operation">
            <option value="+">+</option>
            <option value="-">–</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>

        <input type="text" name="second">

        <input type="submit" value="Рассчитать">

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