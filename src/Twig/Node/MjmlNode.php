<?php

declare(strict_types=1);


namespace Pimcorecasts\Bundle\MjmlTemplate\Twig\Node;

use Pimcorecasts\Bundle\MjmlTemplate\Twig\MjmlExtension;
use Twig\Compiler;
use Twig\Node\Node;

/**
 * @internal
 */
class MjmlNode extends Node
{
    public function __construct(Node $body, $lineno, $tag = null)
    {
        parent::__construct(['value' => $body], ['name' => $tag], $lineno, $tag);
    } //: __construct

    public function compile(Compiler $compiler): void{
        $compiler->addDebugInfo($this)
            ->write('ob_start();'.PHP_EOL)
            ->subcompile($this->getNode('value'))
            ->write('$content = ob_get_clean();'.PHP_EOL)
            ->write('preg_match("/^\s*/", $content, $matches);'.PHP_EOL)
            ->write('$lines = explode("\n", $content);'.PHP_EOL)
            ->write('$content = preg_replace(\'/^\' . $matches[0]. \'/\', "", $lines);'.PHP_EOL)
            ->write('$content = implode("\n", $content);'.PHP_EOL)
            ->write('echo $this->env->getExtension("'.MjmlExtension::class.'")->getMjml()->render($content);'.PHP_EOL);
    } //: compile
}
