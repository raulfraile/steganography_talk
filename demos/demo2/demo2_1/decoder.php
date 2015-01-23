<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../functions.php';

$image = imagecreatefrompng(__DIR__ . '/output.png');
$message = '';

$width = imagesx($image);
$height = imagesy($image);

$bitPosition = 0;
$byte = 0;
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        $rgb = getRgbPixel($image, $x, $y);

        // red channel
        $byte = setBit($byte, 7 - $bitPosition, getBit($rgb['r'], 0));
        $bitPosition++;
        if (8 === $bitPosition) {
            $bitPosition = 0;
            if (0 === $byte) {
                break 2;
            }

            $message .= chr($byte);
        }

        // green channel
        $byte = setBit($byte, 7 - $bitPosition, getBit($rgb['g'], 0));
        $bitPosition++;
        if (8 === $bitPosition) {
            $bitPosition = 0;
            if (0 === $byte) {
                break 2;
            }

            $message .= chr($byte);
        }

        // blue channel
        $byte = setBit($byte, 7 - $bitPosition, getBit($rgb['b'], 0));
        $bitPosition++;
        if (8 === $bitPosition) {
            $bitPosition = 0;
            if (0 === $byte) {
                break 2;
            }

            $message .= chr($byte);
        }

    }

}

echo $message . PHP_EOL;
