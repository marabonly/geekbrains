<?php

$a = 1;
$b = 2;

echo '$a = ' . $a;
echo '<br>';
echo '$b = ' . $b;
echo '<br>';

$a = [ $a , $b ];
$b = $a[0];
$a = $a[1];

echo '<br>';
echo '$a = ' . $a;
echo '<br>';
echo '$b = ' . $b;
echo '<br>';