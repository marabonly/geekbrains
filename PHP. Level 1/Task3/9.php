<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>
    <?php

    /*
4. Объявить массив, индексами которого являются буквы русского языка,
а значениями – соответствующие латинские буквосочетания (‘а’=> ’a’, ‘б’ => ‘b’, ‘в’ => ‘v’, ‘г’ => ‘g’, …, ‘э’ => ‘e’, ‘ю’ => ‘yu’, ‘я’ => ‘ya’).
Написать функцию транслитерации строк.
*/

    function transliterate($string)
    {
        $array = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ъ' => '\'',
            'ы' => 'y',
            'ь' => '\'',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya'
        ];

        $output = '';

        for ($i = 0; $i < mb_strlen($string); $i++) {
            $input_char = mb_substr($string, $i, 1);
            $lowercase_char = mb_strtolower($input_char);

            if ($lowercase_char === $input_char)
                $isInputCapitalLetter = false;
            else
                $isInputCapitalLetter = true;

            if (array_key_exists($lowercase_char, $array)) {
                $result_char = $array[$lowercase_char];
                if ($isInputCapitalLetter === true) $result_char = strtoupper($result_char);
                $output .= $result_char;
            } else {
                $output .= $input_char;
            }
        }

        return str_replace(' ', '_', $output);
    }

    $input = 'GeekBrains — российская компания в сфере онлайн-образования, основанная в 2010 году. Образовательная платформа GeekBrains предлагает курсы по информационным технологиям, программированию, аналитике, тестированию, маркетингу, управлению и дизайну. С 2016 года входит в состав VK.';
    echo '<h2>Исходный текст:</h2>' . $input . '<br>';
    echo '<h2>Транслитерация:</h2>' . transliterate($input);
    ?>

</body>

</html>