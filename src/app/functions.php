<?php
namespace App;

function hello() {
    return 'Hey, man~';
}

function generate_code($length = 4) {
    $min = pow(10 , ($length - 1));
    $max = pow(10, $length) - 1;
    return rand($min, $max);
}

