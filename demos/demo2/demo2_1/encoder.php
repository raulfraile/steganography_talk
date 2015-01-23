<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../functions.php';

$image = imagecreatefrompng(__DIR__ . '/monalisa_7.png');
$message = <<<TEXT
The Three Laws of Robotics (often shortened to The Three Laws or Three Laws, also known as Asimov's Laws) are a set of rules devised by the science fiction author Isaac Asimov. The rules were introduced in his 1942 short story "Runaround", although they had been foreshadowed in a few earlier stories. The Three Laws are:
1. A robot may not injure a human being or, through inaction, allow a human being to come to harm.
2. A robot must obey the orders given it by human beings, except where such orders would conflict with the First Law.
3. A robot must protect its own existence as long as such protection does not conflict with the First or Second Law.
TEXT;


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

imagepng($image, __DIR__ . '/output.png');

