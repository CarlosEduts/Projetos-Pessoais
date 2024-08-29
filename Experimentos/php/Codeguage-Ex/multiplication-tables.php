<?php

$num = rand(1, 100);

echo "Multiplication table for " . $num . ":";
for ($i = 1; $i <= 12; $i++) {
    echo "\n" . $num . " x " . $i . " = " . $num * $i;
}

echo "\n";
