<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData;

use CrudGenerator\MetaData\MetaDataSource;

/**
 * Find all MetaDataSource allow in project
 *
 * @author St  phane Demonchaux
 */
class MetaDataSourceHydrator
{
    /**
     * Build a MetaDataSourceDataobject with all his dependencies
     *
     * @param string $adapterClassName
     * @return MetaDataSource
     */
    public function adapterNameToMetaDataSource($adapterClassName)
    {
        /* @var $metaDataSource CrudGenerator\MetaData\MetaDataSource */
        $metaDataSource = $adapterClassName::getDescription();
        $adapterClassName::checkDependencies($metaDataSource);

        return $metaDataSource;
    }
}
