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
