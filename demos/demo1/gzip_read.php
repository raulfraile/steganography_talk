<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$url = 'http://steganography.local/demos/demo1/gzip.php';

$opts = array(
    'http'=>array(
        'method' => 'GET',
        'header' => "Accept-Encoding:gzip, deflate\r\n"
    )
);

$context = stream_context_create($opts);

$contents = file_get_contents($url, FILE_BINARY, $context);

list($id, $cm, $flags, $mtime, $xfl, $os) = array_values(unpack('nid/C1cm/C1flags/Vmtime/C1xfl/C1os', $contents));

if ($flags & 0x08) {
    // extract message
    list($message) = array_values(unpack('Z*message', substr($contents, 10)));

    echo $message . PHP_EOL;
}
