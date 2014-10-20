<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData\Sources;

/**
 * Metadata DAO Simple Factory interface
 *
 * @author Stéphane Demonchaux
 */
interface MetaDataDAOSimpleFactoryInterface extends MetaDataDAOFactoryInterface
{
    /**
     * @return \CrudGenerator\MetaData\Sources\MetaDataDAOInterface
     */
    public static function getInstance();
}
