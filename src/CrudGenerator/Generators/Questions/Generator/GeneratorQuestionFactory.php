<?php
/**
  * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Questions\Generator;

use CrudGenerator\Generators\Finder\GeneratorFinderFactory;
use CrudGenerator\Context\ContextInterface;

class GeneratorQuestionFactory
{
    /**
     * @param ContextInterface $context
     * @return \CrudGenerator\Generators\Questions\Generator\GeneratorQuestion
     */
    public static function getInstance(ContextInterface $context)
    {
        $generatorFinder = GeneratorFinderFactory::getInstance();

        return new GeneratorQuestion($generatorFinder, $context);
    }
}
