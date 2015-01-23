<?php

class Morse
{

    const LETTER_SEPARATOR = ' ';
    const WORD_SEPARATOR = '    ';

    public $map = [
        'a' => ".-",
        'b' => "-..",
        'c' => "-.-.",
        'd' => "-..",
        'e' => ".",
        'f' => "..-.",
        'g' => "--.",
        'h' => "....",
        'i' => "..",
        'j' => ".---",
        'k' => "-.-",
        'l' => ".-..",
        'm' => "--",
        'n' => "-.",
        'o' => "---",
        'p' => ".--.",
        'q' => "--.-",
        'r' => ".-.",
        's' => "...",
        't' => "-",
        'u' => "..-",
        'v' => "...-",
        'w' => ".--",
        'x' => "-..-",
        'y' => "-.--",
        'z' => "--..",
        ' ' => self::WORD_SEPARATOR
    ];

    public function translate($message) {
        $output = [];
        for ($i = 0, $len = strlen($message); $i < $len; $i++) {
            $output[] = $this->map[$message[$i]];
        }

        return implode(' ', $output);
    }

    public function recover($morseMessage)
    {
        $message = '';
        $words = explode(self::WORD_SEPARATOR, $morseMessage);
        foreach ($words as $word) {
            $letters = explode(self::LETTER_SEPARATOR, $word);
            foreach ($letters as $letter) {
                $message .= array_search($letter, $this->map);
            }
        }

        return $message;
    }

    public function synthesize($morseMessage, $dot = 'pe', $dash = 'peeeeeeeeee')
    {
        $message = str_replace(
            [self::LETTER_SEPARATOR, '.', '-'],
            [', ', $dot . ' ', $dash . ' '],
            $morseMessage
        );

        $cmd = 'say -r 250 -v "Zarvox" "' . $message . '"';

        exec($cmd);
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