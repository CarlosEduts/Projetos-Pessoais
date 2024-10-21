<?php

function factorial($value)
{
    if (!is_int($value)) {
        return "undefinid";
    }

    if ($value == 0) {
        return 1;
    }

    $result = 1;
    for ($i = 2; $i <= $value; $i++) {
        $result *= $i;
    }

    return $result;
}

echo factorial(10);
