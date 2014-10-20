<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Finder;

use CrudGenerator\Generators\Finder\GeneratorFinder;
use CrudGenerator\Utils\TranstyperFactory;
use CrudGenerator\Utils\Installer;
use CrudGenerator\Generators\Validator\GeneratorValidatorFactory;

/**
 * Create GeneratorFinder instance
 *
 * @author St  phane Demonchaux
 */
class GeneratorFinderFactory
{
    /**
     * Create GeneratorFinder instance
     *
     * @return GeneratorFinderCache
     */
    public static function getInstance()
    {
        return new GeneratorFinderCache(
            new GeneratorFinder(
                TranstyperFactory::getInstance(),
                GeneratorValidatorFactory::getInstance()
            ),
            Installer::getDirectories()
        );
    }
}
