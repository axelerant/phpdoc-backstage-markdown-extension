<?php

namespace axelerant\PhpDocMarkdown;

use phpDocumentor\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class RegisterExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {

        $container->addDefinitions([
            (new Definition(UrlExtension::class))->addTag('twig.extension'),
        ]);
    }
}
