<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/morse.php';

$originalFile = __DIR__ . '/original.php';
$message = 'sms';

$originalFileContents = file_get_contents($originalFile);

// cleanup trailing whitespaces
$originalFileContents = preg_replace('/\s*$/', '', $originalFileContents);

$morse = new Morse();
$morseMessage = $morse->translate($message);

$morseMessage = str_replace(
    ['.', '-'],
    ["\n", "\t"],
    $morseMessage
);

$output = <<<CODE
$originalFileContents
$morseMessage
CODE;

file_put_contents(__DIR__ . '/output.php', $output);