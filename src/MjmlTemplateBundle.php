<?php
/**
 *
 * Date: 21.10.2021
 * Time: 10:35
 *
 */
namespace Pimcorecasts\Bundle\MjmlTemplate;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class MjmlTemplateBundle extends AbstractPimcoreBundle
{
    public function getJsPaths(): array
    {
        return [
        ];
    }

    public function getEditmodeJsPaths(): array
    {
        return [
        ];
    }

    public function getCssPaths(): array
    {
        return [
        ];
    }

    public function getEditmodeCssPaths(): array
    {
        return [
        ];
    }

    public function getVersion(): string
    {
        return \Composer\InstalledVersions::getVersion('pimcorecasts/mjml-template-bundle');
    }

    public function getDescription(): string
    {
        return 'N8n Manager Bundle';
    }
}
