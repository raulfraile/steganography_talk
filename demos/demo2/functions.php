<?php

function getBitInMessage($message, $position)
{
    $char = $message[(int) floor($position / 8)];
    $bitMask = 1 << (7 - ($position % 8));

    if ($char & $bitMask) {
        return 1;
    }

    return 0;
}

function getBit($byte, $position)
{
    return ($byte & pow(2, $position)) >> $position;
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