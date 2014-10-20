<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Backbone;

use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Generators\Search\GeneratorSearchFactory;
use CrudGenerator\Generators\Installer\GeneratorInstallerProxyFactory;
use CrudGenerator\Generators\Detail\GeneratorDetailFactory;

class SearchGeneratorBackboneFactory
{
    public static function getInstance(ContextInterface $context)
    {
        return new SearchGeneratorBackbone(
            GeneratorSearchFactory::getInstance($context),
            GeneratorInstallerProxyFactory::getInstance($context),
            GeneratorDetailFactory::getInstance($context),
            $context
        );
    }
}
