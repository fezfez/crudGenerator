<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Metadata\Sources;

use CrudGenerator\Metadata\Driver\DriverConfig;

/**
 * Metadata DAO Simple Factory interface
 *
 * @author Stéphane Demonchaux
 */
interface MetaDataDAOFactoryConfigInterface extends MetaDataDAOFactoryInterface
{
    /**
     * @param  DriverConfig                                         $driverConfig
     * @return \CrudGenerator\Metadata\Sources\MetaDataDAOInterface
     */
    public static function getInstance(DriverConfig $driverConfig);
}
