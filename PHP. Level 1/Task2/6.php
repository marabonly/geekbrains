<?php

/*
6. *С помощью рекурсии организовать функцию возведения числа в степень. Формат: function power($val, $pow), где $val – заданное число, $pow – степень.
*/

function power($val, $pow)
{
    if ($pow != floor($pow)) die('Float power is not implemented');

    if ($pow < 0)
        return 1 / power($val, abs($pow));
    elseif ($pow === 0)
        return 1;
    else
        return $val * power($val, $pow - 1);
}
