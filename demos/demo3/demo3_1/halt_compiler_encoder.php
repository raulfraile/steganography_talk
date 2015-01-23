<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

$originalFile = __DIR__ . '/original.php';
$hiddenFile = __DIR__ . '/hidden.php';

$originalFileContents = file_get_contents($originalFile);
$hiddenFileContents = file_get_contents($hiddenFile);

$padding = str_repeat("\n", 200);

$output = <<<CODE
$originalFileContents
$padding
if (\$argc > 1 && 'hidden' == \$argv[1]) {
\$fp = fopen(__FILE__, 'r');
fseek(\$fp, __COMPILER_HALT_OFFSET__);
eval(stream_get_contents(\$fp));
}
__halt_compiler();
$hiddenFileContents
CODE;

file_put_contents(__DIR__ . '/output.php', $output);