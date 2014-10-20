<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData;

/**
 * Find all MetaDataSource allow in project
 *
 * @author Stéphane Demonchaux
 */
class MetaDataSourceHydratorFactory
{
    /**
     * @return \CrudGenerator\MetaData\MetaDataSourceHydrator
     */
    public static function getInstance()
    {
        return new MetaDataSourceHydrator();
    }
}
