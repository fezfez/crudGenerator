<?php
/**
  * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Parser;

use CrudGenerator\Context\ContextInterface;

/**
 * Find all generator allow in project
 *
 * @author St  phane Demonchaux
 */
class GeneratorParserProxyFactory
{
    /**
     * @param ContextInterface $context
     * @return GeneratorParserProxy
     */
    public static function getInstance(ContextInterface $context)
    {
        return new GeneratorParserProxy($context);
    }
}
