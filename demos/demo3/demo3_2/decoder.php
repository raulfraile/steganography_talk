<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/morse.php';

$outputFile = __DIR__ . '/output.php';

$outputFileContents = file_get_contents($outputFile);

if (preg_match('/\s+$/', $outputFileContents, $matches)) {
    $encodedMorse = substr($matches[0], 1);
    $originalMorse = str_replace(
        ["\n", "\t"],
        ['.', '-'],
        $encodedMorse
    );

    $morse = new Morse();
    $morse->synthesize($originalMorse);
    //$morse->synthesize($originalMorse, 'la', 'leeeeeeeeeeeeeee');
}

