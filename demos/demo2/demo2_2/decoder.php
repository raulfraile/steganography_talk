<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../functions.php';

$image = imagecreatefrompng(__DIR__ . '/output.png');
$message = [];

$width = imagesx($image);
$height = imagesy($image);

$bitPosition = 0;
$byte = 0;
$hiddenWidth = null;
$hiddenHeight = null;
$end = false;
for ($y = 0; $y < $height && false === $end; $y++) {

    for ($x = 0; $x < $width && false === $end; $x++) {
        $rgb = getRgbPixel($image, $x, $y);

        // red channel
        $byte = setBit($byte, 7 - $bitPosition, getBit($rgb['r'], 0));
        $bitPosition++;
        if (8 === $bitPosition) {
            $bitPosition = 0;
            $message[] = $byte;
            if (null == $hiddenWidth) {
                $hiddenWidth = $byte;
            } elseif (null == $hiddenHeight) {
                $hiddenHeight = $byte;
            } else {
                // check if finished
                if (count($message) > ((($hiddenWidth * $hiddenHeight) * 3) + 2)) {
                    $end = true;
                }
            }
            $byte = 0;
        }

        // green channel
        $byte = setBit($byte, 7 - $bitPosition, getBit($rgb['g'], 0));
        $bitPosition++;
        if (8 === $bitPosition) {
            $bitPosition = 0;
            $message[] = $byte;
            if (null == $hiddenWidth) {
                $hiddenWidth = $byte;
            } elseif (null == $hiddenHeight) {
                $hiddenHeight = $byte;
            } else {
                // check if finished
                if (count($message) > ((($hiddenWidth * $hiddenHeight) * 3) + 2)) {
                    $end = true;
                }
            }
            $byte = 0;
        }

        // blue channel
        $byte = setBit($byte, 7 - $bitPosition, getBit($rgb['b'], 0));
        $bitPosition++;
        if (8 === $bitPosition) {
            $bitPosition = 0;
            $message[] = $byte;
            if (null == $hiddenWidth) {
                $hiddenWidth = $byte;
            } elseif (null == $hiddenHeight) {
                $hiddenHeight = $byte;
            } else {
                // check if finished
                if (count($message) > ((($hiddenWidth * $hiddenHeight) * 3) + 2)) {
                    $end = true;
                }
            }
            $byte = 0;
        }

    }
}

$width = $message[0];
$height = $message[1];
$hiddenImage = imagecreatetruecolor($width, $height);
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {

        $baseIndex = ($y * ($width * 3)) + (3 * $x) + 2;

        $color = imagecolorexact($hiddenImage, $message[$baseIndex], $message[$baseIndex + 1], $message[$baseIndex + 2]);
        if (-1 === $color) {
            $color = imagecolorallocate($hiddenImage, $message[$baseIndex], $message[$baseIndex + 1], $message[$baseIndex + 2]);
        }

        imagesetpixel($hiddenImage, $x, $y, $color);
    }

}

imagepng($hiddenImage, __DIR__ . '/hidden.png', 0);