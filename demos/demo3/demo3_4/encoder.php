<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpParser\Node;

abstract class BaseNodeVisitor extends PhpParser\NodeVisitorAbstract
{
    protected function isEmptyLine($line)
    {
        return '*' === preg_replace('/\s+/', '', $line);
    }
}

class StatsNodeVisitor extends BaseNodeVisitor
{
    protected $lines = 0;

    public function leaveNode(Node $node) {
        $docBlock = $node->getDocComment();
        if ($docBlock instanceof PhpParser\Comment\Doc) {
            $this->lines += $this->countEmptyLines($docBlock->getText());
        }
    }

    protected function countEmptyLines($comment)
    {
        $emptyLines = 0;
        foreach (explode("\n", $comment) as $line) {
            if ($this->isEmptyLine($line)) {
                $emptyLines++;
            }
        }

        return $emptyLines;
    }

    public function getLines()
    {
        return $this->lines;
    }
}

class EmbedNodeVisitor extends BaseNodeVisitor
{
    protected $parts;

    protected $position;

    public function __construct($lines, $code)
    {
        $this->parts = str_split($code, ceil(strlen($code) / $lines));
        $this->position = 0;
    }

    public function leaveNode(Node $node) {
        $docBlock = $node->getDocComment();
        if ($docBlock instanceof PhpParser\Comment\Doc) {
            $docBlock->setText($this->replaceEmptyLinesOfComment($docBlock->getText()));
        }
    }

    protected function replaceEmptyLinesOfComment($comment)
    {
        $lines = explode("\n", $comment);
        foreach ($lines as $key => $line) {
            if ($this->isEmptyLine($line)) {
                $start = strpos($line, '*');
                $lines[$key] = substr($line, 0, $start + 1) . $this->getNextBlock();
            }
        }

        return implode("\n", $lines);
    }

    protected function getNextBlock()
    {
        if ($this->position >= count($this->parts)) {
            return '';
        }

        $block = $this->parts[$this->position];
        $this->position++;

        return str_replace("\n", chr(11), $block);
    }

}

$originalFile = __DIR__ . '/original.php';
$hiddenFile = __DIR__ . '/hello_world.ws';

$parser = new PhpParser\Parser(new PhpParser\Lexer\Emulative);
$traverser = new PhpParser\NodeTraverser;
$prettyPrinter = new PhpParser\PrettyPrinter\Standard;

$statsVisitor = new StatsNodeVisitor();
$traverser->addVisitor($statsVisitor);

$originalFileContents = file_get_contents($originalFile);
$hiddenFileContents = file_get_contents($hiddenFile);

try {
    $stmts = $parser->parse($originalFileContents);

    // gather statistics
    $stmts = $traverser->traverse($stmts);

    // transform
    $traverser->removeVisitor($statsVisitor);
    $embedVisitor = new EmbedNodeVisitor($statsVisitor->getLines(), $hiddenFileContents);
    $traverser->addVisitor($embedVisitor);
    $stmts = $traverser->traverse($stmts);

    $originalFileContents = $prettyPrinter->prettyPrintFile($stmts);

    file_put_contents(__DIR__ . '/output.php', $originalFileContents);
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}