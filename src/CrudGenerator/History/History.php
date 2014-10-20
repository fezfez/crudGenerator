<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\History;

use CrudGenerator\Generators\GeneratorDataObject;

/**
 * History representation
 *
 * @author St  phane Demonchaux
 */
class History
{
    /**
     * @var string Column name
     */
    private $name = null;
    /**
     * @var array
     */
    private $dataObjects = null;

    /**
     * Set Column name
     *
     * @param string $value
     * @return \CrudGenerator\History\History
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }
    /**
     * Set DataObject
     *
     * @param GeneratorDataObject $value
     * @return \CrudGenerator\History\History
     */
    public function addDataObject(GeneratorDataObject $value)
    {
        $this->dataObjects[] = $value;
        return $this;
    }

    /**
     * Get Column name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Get DataObject
     *
     * @return array
     */
    public function getDataObjects()
    {
        return $this->dataObjects;
    }
}
