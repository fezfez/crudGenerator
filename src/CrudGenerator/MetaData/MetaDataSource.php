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

use CrudGenerator\MetaData\Sources\MetaDataConfigInterface;
use CrudGenerator\MetaData\Driver\DriverConfig;
use CrudGenerator\MetaData\Driver\Driver;

/**
 * Adapter representation
 * @author Stéphane Demonchaux
 */
class MetaDataSource implements \JsonSerializable
{
    /**
     * @var string name of adapater
     */
    private $metaDataDAO = null;
    /**
     * @var string name of adapater
     */
    private $metaDataDAOFactory = null;
    /**
     * @var string true if dependencies of adapater are complete
     */
    private $falseDependencies = null;
    /**
     * @var string adapter definition
     */
    private $definition = null;
    /**
     * @var DriverConfig Driver configuration
     */
    private $config = null;
    /**
     * Collection of connector
     *
     * @var array
     */
    private $driversDescription = array();
    /**
     * Unique name
     *
     * @var string
     */
    private $uniqueName = null;

    /**
     * Set name
     * @param string $value
     * @return \CrudGenerator\MetaData\MetaDataSource
     */
    public function setMetadataDao($value)
    {
        $this->metaDataDAO = $value;
        return $this;
    }
    /**
     * @param string $value
     * @return \CrudGenerator\MetaData\MetaDataSource
     */
    public function setMetadataDaoFactory($value)
    {
        $this->metaDataDAOFactory = $value;
        return $this;
    }
    /**
     * Set definition
     * @param string $value
     * @return \CrudGenerator\MetaData\MetaDataSource
     */
    public function setDefinition($value)
    {
        $this->definition = $value;
        return $this;
    }
    /**
     * Set false dependencie
     * @param string $value
     * @return \CrudGenerator\MetaData\MetaDataSource
     */
    public function setFalseDependencie($value)
    {
        $this->falseDependencies = $value;
        return $this;
    }
    /**
     * Set config
     * @param DriverConfig $value
     * @return \CrudGenerator\MetaData\MetaDataSource
     */
    public function setConfig(DriverConfig $value)
    {
        $this->config = $value;
        return $this;
    }
    /**
     * @param Driver $value
     * @return \CrudGenerator\MetaData\MetaDataSource
     */
    public function addDriverDescription(Driver $value)
    {
        $this->driversDescription[] = $value;
        return $this;
    }
    /**
     * Set unique name
     * @param string $value
     * @return \CrudGenerator\MetaData\MetaDataSource
     */
    public function setUniqueName($value)
    {
        $this->uniqueName = $value;
        return $this;
    }

    /**
     * Get MetadataDAO class as string
     * @return string
     */
    public function getMetadataDao()
    {
        return $this->metaDataDAO;
    }
    /**
     * Get MetadataDAOFactory class as string
     * @return string
     */
    public function getMetadataDaoFactory()
    {
        return $this->metaDataDAOFactory;
    }
    /**
     * Get definition
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }
    /**
     * Get false dependencies
     * @return string
     */
    public function getFalseDependencies()
    {
        return $this->falseDependencies;
    }
    /**
     * Get config
     *
     * @return \CrudGenerator\MetaData\Driver\DriverConfig
     */
    public function getConfig()
    {
        return $this->config;
    }
    /**
     * @return string
     */
    public function getUniqueName()
    {
        if ($this->config === null) {
            return $this->definition;
        } else {
            return $this->config->getUniqueName();
        }
    }

    /**
     * GetConnectorsFactory
     * @return array
     */
    public function getDriversDescription()
    {
        return $this->driversDescription;
    }
    /**
     * @return boolean
     */
    public function isUniqueDriver()
    {
        return (count($this->driversDescription) === 1) ? true : false;
    }

    public function jsonSerialize()
    {
        return array(
            'config'             => $this->config,
            'definition'         => $this->definition,
            'metaDataDAO'        => $this->metaDataDAO,
            'metaDataDAOFactory' => $this->metaDataDAOFactory,
            'falseDependencies'  => $this->falseDependencies,
            'uniqueName'         => $this->getUniqueName()
        );
    }
}
