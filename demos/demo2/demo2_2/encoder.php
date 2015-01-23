<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/morse.php';

$morse = new Morse();
$tokens = $morse->tokenize('hello');

$message = '';


ldd();
$message = bindec($morse->translate('hello', '0', '1', 0, 0));

$message = array_values(unpack('C*char', $message . "\0"));
$messagePosition = 0;
$messageBitLength = count($message) * 8;

$image = imagecreatefrompng(__DIR__ . '/monalisa_7.png');
$width = imagesx($image);
$height = imagesy($image);

for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {

        $rgb = getRgbPixel($image, $x, $y);

        if ($messagePosition < $messageBitLength) {
            // red channel
            $rgb['r'] = setBit($rgb['r'], 0, getBit($message, $messagePosition));
            $messagePosition++;

            if ($messagePosition < $messageBitLength) {
                // green channel
                $rgb['g'] = setBit($rgb['g'], 0, getBit($message, $messagePosition));
                $messagePosition++;

                if ($messagePosition < $messageBitLength) {
                    // blue channel
                    $rgb['b'] = setBit($rgb['b'], 0, getBit($message, $messagePosition));
                    $messagePosition++;
                }
            }
        }

        $color = imagecolorallocate($image, $rgb['r'], $rgb['g'], $rgb['b']);
        //$color = imagecolorallocate($image, 255,255,255);
        imagesetpixel($image, $x, $y, $color);
        imagecolordeallocate($image, $color);

        if ($messagePosition >= $messageBitLength) {
            break 2;
        }
    }
}

imagepng($image, __DIR__ . '/output.png');

