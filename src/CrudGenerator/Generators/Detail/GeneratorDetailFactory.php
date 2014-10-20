<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Detail;

use CrudGenerator\Context\ContextInterface;
use Github\Client;

/**
 *
 * @author St  phane Demonchaux
 */
class GeneratorDetailFactory
{
    /**
     * @param ContextInterface $context
     * @return GeneratorDetail
     */
    public static function getInstance(ContextInterface $context)
    {
        return new GeneratorDetail(
            new Client()
        );
    }
}
