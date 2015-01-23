<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

function getBit($message, $position)
{
    $char = $message[(int) floor($position / 8)];
    $bitMask = 1 << (7 - ($position % 8));

    if ($char & $bitMask) {
        return 1;
    }

    return 0;
}

function setBit($byte, $position, $value)
{
    if (1 === $value) {
        $byte |= 1 << $position;
    } else {
        $byte &= ~(1 << $position);
    }

    return $byte;
}

function getRgbPixel($image, $x, $y) {
    $rgb = imagecolorat($image, $x, $y);

    return [
        'r' => ($rgb >> 16) & 0xFF,
        'g' => ($rgb >> 8) & 0xFF,
        'b' => $rgb & 0xFF
    ];
}

$image = imagecreatefrompng(__DIR__ . '/monalisa.png');
$message = 'hello world';

$message = file_get_contents(__FILE__);

$message = array_values(unpack('C*char', $message . "\0"));
$messagePosition = 0;
$messageBitLength = count($message) * 8;

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

