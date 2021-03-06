<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Command;

use Symfony\Component\Console\Application;

/**
 * Generator command
 *
 * @author Stéphane Demonchaux
 */
class CreateCommandFactory
{
    /**
     * @return \CrudGenerator\Command\CreateCommand
     */
    public static function getInstance(Application $application)
    {
        return new CreateCommand($application);
    }
}
