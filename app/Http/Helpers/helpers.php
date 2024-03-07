<?php

function sanitizeNumber($number)
{
    $number = str_replace(',', '', $number);
    if (str_ends_with($number, '.')) {
        $number = substr($number, 0, -1);
    }

    return $number;
}
