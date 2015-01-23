<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpParser\Node;
use igorw\whitespace as w;

class ExtractNodeVisitor extends PhpParser\NodeVisitorAbstract
{

    protected $code = '';

    public function leaveNode(Node $node) {
        $docBlock = $node->getDocComment();
        if ($docBlock instanceof PhpParser\Comment\Doc) {

            $lines = explode("\n", $docBlock->getText());

            foreach ($lines as $line) {
                if ($this->isEmptyLine($line)) {
                    $start = strpos($line, '*');

                    $this->code .= str_replace(chr(11), chr(10), substr($line, $start + 1));
                }
            }
        }
    }

    protected function isEmptyLine($line)
    {
        return '*' === preg_replace('/\s+/', '', $line);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

}

$parser = new PhpParser\Parser(new PhpParser\Lexer\Emulative);
$traverser = new PhpParser\NodeTraverser;

$extractVisitor = new ExtractNodeVisitor();
$traverser->addVisitor($extractVisitor);

$code = file_get_contents(__DIR__ . '/output.php');

try {
    $stmts = $parser->parse($code);

    $stmts = $traverser->traverse($stmts);

    system("stty -icanon");
    w\evaluate(w\parse(str_split($extractVisitor->getCode())));
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}