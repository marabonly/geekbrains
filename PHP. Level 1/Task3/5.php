﻿<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>
    <?php

    /*
5. Написать функцию, которая заменяет в строке пробелы на подчеркивания и возвращает видоизмененную строчку.
*/

    function replace_spaces($string)
    {
        return str_replace(' ', '_', $string);
    }

    $input = 'GeekBrains — российская компания в сфере онлайн-образования, основанная в 2010 году. Образовательная платформа GeekBrains предлагает курсы по информационным технологиям, программированию, аналитике, тестированию, маркетингу, управлению и дизайну. С 2016 года входит в состав VK.';
    echo '<h2>Исходный текст:</h2>' . $input . '<br>';
    echo '<h2>Транслитерация:</h2>' . replace_spaces($input);
    ?>

</body>

</html>