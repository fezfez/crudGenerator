<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData\DataObject;

use CrudGenerator\MetaData\DataObject\MetaDataColumn;
use CrudGenerator\MetaData\DataObject\MetaDataColumnCollection;
use CrudGenerator\MetaData\DataObject\MetaDataRelationColumn;
use CrudGenerator\MetaData\DataObject\MetaDataRelationCollection;

/**
 * Base representation metadata for template generation
 *
 * @author St  phane Demonchaux
 */
abstract class MetaData implements \JsonSerializable, MetaDataInterface
{
    /**
     * @var MetaDataColumnCollection Column collection
     */
    private $columnCollection = null;
    /**
     * @var MetaDataRelationCollection Relation collection
     */
    private $relationCollection = null;
    /**
     * @var string Name
     */
    private $name = null;

    /**
     * Base representation metadata for template generation
     * @param MetaDataColumnCollection $columnCollection
     * @param MetaDataRelationCollection $relationCollection
     */
    public function __construct(
        MetaDataColumnCollection $columnCollection,
        MetaDataRelationCollection $relationCollection
    ) {
        $this->columnCollection   = $columnCollection;
        $this->relationCollection = $relationCollection;
    }
    /**
     * Append column dataobject
     * @param MetaDataColumn $value
     */
    public function appendColumn(MetaDataColumn $value)
    {
        $this->columnCollection->offsetSet($value->getName(), $value);
    }
    /**
     * Append relation dataobject
     * @param MetaDataRelationColumn $value
     */
    public function appendRelation(MetaDataRelationColumn $value)
    {
        $this->relationCollection->offsetSet($value->getFullName(), $value);
    }
    /**
     * Set name
     * @param string $value
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getColumn($name)
    {
        return $this->columnCollection->offsetGet($name);
    }
    /**
     * @param string $name
     * @return mixed
     */
    public function getRelation($name)
    {
        return $this->relationCollection->offsetGet($name);
    }
    /**
     * Get column collection
     * @return MetaDataColumnCollection
     */
    public function getColumnCollection($withoutIdentifier = false)
    {
        if ($withoutIdentifier === true) {
            $tmpColumnCollection = new MetaDataColumnCollection();

            foreach ($this->columnCollection as $column) {
                $isPk = $column->isPrimaryKey();
                if ($isPk === false) {
                    $tmpColumnCollection->append($column);
                }
            }

            return $tmpColumnCollection;
        } else {
            return $this->columnCollection;
        }
    }
    /**
     * Get relation collection
     * @return MetaDataRelationCollection
     */
    public function getRelationCollection()
    {
        return $this->relationCollection;
    }
    /**
     * Get identifier
     * @return array
     */
    public function getIdentifier()
    {
        $tmpColumnCollection = array();

        foreach ($this->columnCollection as $column) {
            $isPk = $column->isPrimaryKey();
            if ($isPk === true) {
                $tmpColumnCollection[] = $column;
            }
        }

        return $tmpColumnCollection;
    }
    /**
     * Get name
     * @return string
     */
    public function getName($ucfirst = false)
    {
        $name = $this->name;

        if (strrchr($name, '\\') !== false) {
            $name = str_replace('\\', '', strrchr($name, '\\'));
        }
        $name = $this->camelCase($name);
        if (true === $ucfirst) {
            return ucfirst($name);
        } else {
            return $name;
        }
    }

    /**
     * @param string $value
     */
    private function camelCase($value)
    {
        return preg_replace_callback(
            '/_(\w)/',
            function (array $matches) {
                return ucfirst($matches[1]);
            },
            $value
        );
    }

    public function getOriginalName()
    {
        return $this->name;
    }

    /* (non-PHPdoc)
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return array(
            'id'    => $this->getOriginalName(),
            'label' => $this->getOriginalName(),
            'name'  => $this->getOriginalName()
        );
    }
}
