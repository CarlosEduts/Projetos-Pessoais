<?php

function is_prime($value)
{
    if (!is_int($value) || $value <= 1) {
        return NULL;
    }

    $limit = (int) ($value ** 0.5);

    for ($i = 2; $i <= $limit; $i++) {
        if ($value % $i === 0) {
            return false;
        }
    }
    return true;
}

var_dump(is_prime(30));
