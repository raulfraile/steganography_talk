<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../functions.php';

function getDistribution($imagePath)
{
    $image = imagecreatefrompng($imagePath);

    $width = imagesx($image);
    $height = imagesy($image);

    $stats = [
        0 => 0,
        1 => 0
    ];

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = getRgbPixel($image, $x, $y);

            $stats[getBit($rgb['r'], 0)]++;
            $stats[getBit($rgb['g'], 0)]++;
            $stats[getBit($rgb['b'], 0)]++;
        }
    }

    // percent
    $total = ($width * $height) * 3;
    $stats[0] = ($stats[0] * 100) / $total;
    $stats[1] = ($stats[1] * 100) / $total;

    return $stats;
}

var_dump(getDistribution(__DIR__ . '/monalisa_7.png'), getDistribution(__DIR__ . '/output.png'));
