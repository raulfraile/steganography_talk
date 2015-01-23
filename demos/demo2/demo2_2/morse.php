<?php

class Morse
{
    public $map = [
        'a' => ". -",
        'b' => "- . .",
        'c' => "- . - .",
        'd' => "- . .",
        'e' => ".",
        'f' => ". . - .",
        'g' => "- - .",
        'h' => ". . . .",
        'i' => ". .",
        'j' => ". - - -",
        'k' => "- . -",
        'l' => ". - . .",
        'm' => "- -",
        'n' => "- .",
        'o' => "- - -",
        'p' => ". - - .",
        'q' => "- - . -",
        'r' => ". - .",
        's' => ". . .",
        't' => "-",
        'u' => ". . -",
        'v' => ". . . -",
        'w' => ". - -",
        'x' => "- . . -",
        'y' => "- . - -",
        'z' => "- - . .",
        ' ' => "\t"
    ];

    public function translate($message)
    {
        $tokens = [];
        for ($i = 0, $len = strlen($message); $i < $len; $i++) {
            $tokens[] = explode(' ', $this->map[$message[$i]]);
        }

        return $tokens;
    }

    public function toBinary($message, $charSeparator = 0b)
    {
        $result = $this->translate2($message, '0', '1');
    }

    public function translate2($message, $dot = '.', $dash = '-', $charSpaces = 1, $wordSpaces = 4) {
        $output = [];
        $charSpacesString = str_repeat(' ', $charSpaces);
        $wordSpacesString = str_repeat(' ', $wordSpaces);
        for ($i = 0, $len = strlen($message); $i < $len; $i++) {
            $output[] = $this->map[$message[$i]];
        }

        $output = implode("\t", $output);

        return str_replace(['.', '-', ' ', "\t"], [$dot, $dash, $charSpacesString, $wordSpacesString], $output);
    }
}
/*
function synthesize($message, $dot = 'pe', $dash = 'peeeeeeeeee')
{

    $letters = [
        'a' => "$dot $dash",
        'b' => "$dash $dot $dot",
        'c' => "$dash $dot $dash $dot",
        'd' => "$dash $dot $dot",
        'e' => "$dot",
        'f' => "$dot $dot $dash $dot",
        'g' => "$dash $dash $dot",
        'h' => "$dot $dot $dot $dot",
        'i' => "$dot $dot",
        'j' => "$dot $dash $dash $dash",
        'k' => "$dash $dot $dash",
        'l' => "$dot $dash $dot $dot",
        'm' => "$dash $dash",
        'n' => "$dash $dot",
        'o' => "$dash $dash $dash",
        'p' => "$dot $dash $dash $dot",
        'q' => "$dash $dash $dot $dash",
        'r' => "$dot $dash $dot",
        's' => "$dot $dot $dot",
        't' => "$dash",
        'u' => "$dot $dot $dash",
        'v' => "$dot $dot $dot $dash",
        'w' => "$dot $dash $dash",
        'x' => "$dash $dot $dot $dash",
        'y' => "$dash $dot $dash $dash",
        'z' => "$dash $dash $dot $dot"
    ];

    $output = [];
    for ($i = 0, $len = strlen($message); $i < $len; $i++) {
        $output[] = $letters[$message[$i]];
    }

    return implode('. ', $output);
}

$message = synthesize($argv[1]);


$cmd = 'say -r 250 -v "Zarvox" ' . $message;

exec($cmd);*/