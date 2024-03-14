<?php

namespace Pimcorecasts\Bundle\MjmlTemplate\Twig;


use Pimcorecasts\Bundle\MjmlTemplate\Twig\TokenParser\MjmlParser;
use Qferrer\Mjml\RendererInterface;
use Twig\Extension\AbstractExtension;

class MjmlExtension extends AbstractExtension
{
    /**
     * @param RendererInterface $mjml
     */
    public function __construct(protected RendererInterface $mjml)
    {
    }

    public function getTokenParsers(  ): array
    {
        return [
            new MjmlParser()
        ];
    }

    public function getMjml(): RendererInterface
    {
        return $this->mjml;
    }

}
