<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

$originalFile = __DIR__ . '/original.php';
$hiddenFile = __DIR__ . '/fibonacci.ws';

$originalFileContents = file_get_contents($originalFile);
$hiddenFileContents = file_get_contents($hiddenFile);

// cleanup trailing whitespaces
$originalFileContents = preg_replace('/\s*$/', '', $originalFileContents);

$output = <<<CODE
$originalFileContents
$hiddenFileContents
CODE;

file_put_contents(__DIR__ . '/output.php', $output);