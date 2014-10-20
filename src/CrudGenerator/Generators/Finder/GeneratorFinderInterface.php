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

use CrudGenerator\MetaData\DataObject\MetaDataInterface;

/**
 * Find all generator allow in project
 *
 * @author St  phane Demonchaux
 */
interface GeneratorFinderInterface
{
    /**
     * Find all adapters allow in project
     *
     * @return array
     */
    public function getAllClasses(MetaDataInterface $metadata = null);

    /**
     * @param string $name
     * @throws \InvalidArgumentException
     * @return string
     */
    public function findByName($name);
}
