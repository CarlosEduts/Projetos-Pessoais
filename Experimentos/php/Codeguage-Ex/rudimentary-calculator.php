<?php

do {
    echo "x: ";
    $x = (int) fgets(STDIN);

    echo "y: ";
    $y = (int) fgets(STDIN);

    echo "Operation: ";
    $operation = rtrim(fgets(STDIN));

    echo "\n";

    if ($operation == "a")
        echo $x, " + ", $y, " = ", $x + $y;

    elseif ($operation == "s")
        echo $x, " - ", $y, " = ", $x - $y;

    elseif ($operation == "m")
        echo $x, " * ", $y, " = ", $x * $y;

    elseif ($operation == "d")
        echo $x, " / ", $y, " = ", $x / $y;

    elseif ($operation == 'r')
        echo $x, ' % ',  $y, ' = ', $x % $y;

    elseif ($operation == 'e')
        echo $x, ' ** ', $y, ' = ', $x ** $y;

    echo "\n";

    echo "Restart? ";
    $restart = rtrim(fgets(STDIN));
    echo "\n";
} while ($restart == "y");
