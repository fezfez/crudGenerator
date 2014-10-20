<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData\Driver;

/**
 * Metadata connector interface
 *
 * @author Stéphane Demonchaux
 */
interface DriverFactoryInterface
{
    /**
     * @throws ConfigException
     */
    public static function getInstance();

    /**
     * @return Driver
     */
    public static function getDescription();
}
