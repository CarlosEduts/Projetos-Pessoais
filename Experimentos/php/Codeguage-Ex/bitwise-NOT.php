<?php

function not($value)
{
    for ($i = 0; $i < strlen($value); $i++) {
        if ($value[$i] == '1') {
            $value[$i] = '0';
        } else {
            $value[$i] = '1';
        }
    }

    return $value;
}

var_dump(not('1010'));
var_dump(not('11110'));
