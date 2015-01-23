<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$message = 'attack!';
$html = '<h1>hello world</h1>';

$gzip = gzencode($html);

list($id, $cm, $flags, $mtime, $xfl, $os) = array_values(unpack('nid/C1cm/C1flags/Vmtime/C1xfl/C1os', $gzip));

// set FNAME
$flags = $flags | 0x08;

// unset FHCRC
$flags = $flags & ~0x02;

// generate
$gzip[3] = pack('C', $flags);
$gzip = substr($gzip, 0, 10) . $message . "\0" . substr($gzip, 10);

header('Content-Encoding: gzip');
header('Content-Type: text/html');

echo $gzip;