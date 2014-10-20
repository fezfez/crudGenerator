<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData\Sources;

use CrudGenerator\MetaData\Driver\DriverConfig;

/**
 * Metadata DAO cache
 *
 * @author St  phane Demonchaux
 */
class MetaDataDAOCache implements MetaDataDAOInterface
{
    /**
     * @var MetaDataDAOInterface
     */
    private $metadataDAO = null;
    /**
     * @var array
     */
    private $directories = null;
    /**
     * @var DriverConfig
     */
    private $config = null;
    /**
     * @var boolean
     */
    private $noCache = null;

    /**
     * @param MetaDataDAOInterface $metadataDAO
     * @param array $directories
     * @param DriverConfig $config
     * @param boolean $noCache
     */
    public function __construct(
        MetaDataDAOInterface $metadataDAO,
        array $directories,
        DriverConfig $config = null,
        $noCache = false
    ) {
        $this->metadataDAO = $metadataDAO;
        $this->directories = $directories;
        $this->config      = $config;
        $this->noCache     = $noCache;
    }
    /**
     * Get all metadata from the concrete metadata DAO
     *
     * @return \CrudGenerator\MetaData\DataObject\MetaDataCollection
     */
    public function getAllMetadata()
    {
        $configName     = ($this->config !== null) ? $this->config->getUniqueName() : '';
        $cacheFilename  = $this->directories['Cache'] . DIRECTORY_SEPARATOR;
        $cacheFilename .= md5('all_metadata' . get_class($this->metadataDAO) . $configName);

        if (is_file($cacheFilename) === true && $this->noCache === false) {
            $data = unserialize(file_get_contents($cacheFilename));
        } else {
            $data = $this->metadataDAO->getAllMetadata();
            file_put_contents($cacheFilename, serialize($data));
        }

        return $data;
    }

    /**
     * Get particularie metadata from the concrete metadata DAO
     *
     * @param string $entityName
     * @return \CrudGenerator\MetaData\DataObject\MetaData
     */
    public function getMetadataFor($entityName, array $parentName = array())
    {
        $configName     = ($this->config !== null) ? $this->config->getUniqueName() : '';
        $cacheFilename  = $this->directories['Cache'] . DIRECTORY_SEPARATOR;
        $cacheFilename .= md5('metadata' . $entityName . get_class($this->metadataDAO) . $configName);

        if (is_file($cacheFilename) === true && $this->noCache === false) {
            $data = unserialize(file_get_contents($cacheFilename));
        } else {
            $data = $this->metadataDAO->getMetadataFor($entityName, $parentName);
            file_put_contents($cacheFilename, serialize($data));
        }

        return $data;
    }
}
