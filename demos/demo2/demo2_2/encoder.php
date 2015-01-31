<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../functions.php';

$hiddenImage = imagecreatefrompng($argv[2]);
$width = imagesx($hiddenImage);
$height = imagesy($hiddenImage);
$message = [ $width, $height ];
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        $rgb = getRgbPixel($hiddenImage, $x, $y);

        $message[] = $rgb['r'];
        $message[] = $rgb['g'];
        $message[] = $rgb['b'];
    }
}

$image = imagecreatefrompng($argv[1]);

//$message = array_values(unpack('C*char', $message));
$messagePosition = 0;
$messageBitLength = count($message) * 8;

$width = imagesx($image);
$height = imagesy($image);
$p = 0;
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {

        $rgb = getRgbPixel($image, $x, $y);

        if ($messagePosition < $messageBitLength) {
            // red channel
            $rgb['r'] = setBit($rgb['r'], 0, getBitInMessage($message, $messagePosition));
            $messagePosition++;

            if ($messagePosition < $messageBitLength) {
                // green channel
                $rgb['g'] = setBit($rgb['g'], 0, getBitInMessage($message, $messagePosition));
                $messagePosition++;

                if ($messagePosition < $messageBitLength) {
                    // blue channel
                    $rgb['b'] = setBit($rgb['b'], 0, getBitInMessage($message, $messagePosition));
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

imagepng($image, __DIR__ . '/output.png', 0);

