<?php

namespace Piccolo\Templating\Engine\PHP;

use Piccolo\Module\AbstractModule;
use Piccolo\Templating\TemplateEngine;
use Piccolo\DependencyInjection\DependencyInjectionContainer;
use Piccolo\Templating\TemplatingModule;

/**
 * This module registers the `PHPTemplateEngine` class as a template engine provider with the Templating module.
 * This can be used by invoking the `TemplateRenderingChain` class.
 *
 * @see https://github.com/opsbears/piccolo-templating
 *
 * @package Templating
 */
class PHPTemplatingModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    public function getModuleKey() : string
    {
        return 'php-templating';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredModules() : array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function loadConfiguration(array &$moduleConfig, array &$globalConfig)
    {
        parent::loadConfiguration($moduleConfig, $globalConfig);
        if (! isset($globalConfig['templating']['engines'])) {
            $globalConfig['templating']['engines'] = [];
        }
        $globalConfig['templating']['engines'][] = PHPTemplateEngine::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureDependencyInjection(DependencyInjectionContainer $dic, array $moduleConfig,
                                                 array $globalConfig)
    {
        $dic->alias(TemplateEngine::class, PHPTemplateEngine::class);
    }
}
