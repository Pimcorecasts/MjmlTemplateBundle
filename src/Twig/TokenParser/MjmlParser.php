<?php

declare(strict_types=1);


namespace Pimcorecasts\Bundle\MjmlTemplate\Twig\TokenParser;


use Pimcorecasts\Bundle\MjmlTemplate\Twig\Node\MjmlNode;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * @internal
 *
 * The spaceless tag only removes spaces between HTML elements. This removes all newlines in a block and is suited
 * for a simple minification of CSS/JS assets.
 */
class MjmlParser extends AbstractTokenParser
{
    public function parse(Token $token): Node
    {
        $line = $token->getLine();

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse(function (Token $token) {
            return $token->test('endmjml');
        }, true);

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return new MjmlNode($body, $line, $this->getTag());
    } //: parse

    public function getTag(): string
    {
        return 'mjml';
    } //: getTag
}
