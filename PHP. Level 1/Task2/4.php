<?php

/*
4. Реализовать функцию с тремя параметрами:
function mathOperation($arg1, $arg2, $operation),
где $arg1, $arg2 – значения аргументов, $operation – строка с названием операции.

В зависимости от переданного значения операции выполнить одну из арифметических операций (использовать функции из пункта 3) и вернуть полученное значение (использовать switch).
*/

function mathOperation($arg1, $arg2, $operation)
{
    switch ($operation) {
        case '+':
            return add($arg1, $arg2);
        case '-':
            return subtract($arg1, $arg2);
        case '*':
            return multiply($arg1, $arg2);
        case '/':
            return divide($arg1, $arg2);
        default:
            die('Wrong operation');
    }
}

function add($a, $b)
{
    return $a + $b;
}

function subtract($a, $b)
{
    return $a - $b;
}

function multiply($a, $b)
{
    return $a * $b;
}

function divide($a, $b)
{
    if ($b === 0)
        die('Division by zero is prohibited');
    else
        return $a / $b;
}
