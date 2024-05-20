<?php

/*
7. *Написать функцию, которая вычисляет текущее время и возвращает его в формате с правильными склонениями, например:
22 часа 15 минут
21 час 43 минуты
*/

function getCurrentTime()
{
    date_default_timezone_set('UTC');

    $hours = date("H");
    $minutes = date("i");

    $time = $hours . ' ';

    if (($hours % 100 >= 10) && ($hours % 100 <= 20))
        $time .= 'часов';
    elseif ($hours % 10 == 1)
        $time .= 'час';
    elseif (($hours % 10 >= 2) && ($hours % 10 <= 4))
        $time .= 'часа';
    else
        $time .= 'часов';

    $time .= ' ' . $minutes . ' ';

    if (($minutes % 100 >= 10) && ($minutes % 100 <= 20))
        $time .= 'минут';
    elseif ($minutes % 10 == 1)
        $time .= 'минута';
    elseif (($minutes % 10 >= 2) && ($minutes % 10 <= 4))
        $time .= 'минуты';
    else
        $time .= 'минут';

    return $time;
}

echo getCurrentTime();
