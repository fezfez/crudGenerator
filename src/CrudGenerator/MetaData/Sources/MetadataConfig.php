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
 * @author Stéphane Demonchaux
 */
abstract class MetadataConfig implements \JsonSerializable
{
    /**
     * Config description
     *
     * @var string
     */
    protected $definition;

    /**
     * The metaDataDAOFactory full qualified class
     *
     * @var string
     */
    protected $metaDataDAOFactory;

    /**
     * The connector full qualified class
     *
     * @var string
     */
    protected $connector;

    /**
     * The connector full qualified class
     *
     * @var string
     */
    protected $connectorConfig;

    final public function __construct()
    {
        $interface = 'JsonSerializable';

        if (in_array($interface, class_implements($this)) === false) {
            throw new \LogicException(get_class($this) . ' must implements ' . $interface);
        }

        if (class_exists($this->metaDataDAOFactory, true) === false) {
            throw new \LogicException(
                sprintf('The metadataDAOFactory class %s does not exist', $this->metaDataDAOFactory)
            );
        }
    }

    /**
     * Get unique configuration name
     * @return string
     */
    abstract public function getUniqueName();

    public function getConnectors()
    {
        return $this->connectors;
    }

    /**
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @return string
     */
    public function getMetadataDaoFactory()
    {
        return $this->metaDataDAOFactory;
    }

    /**
     * @return string
     */
    public function getConnectorConfig()
    {
        return $this->connectorConfig;
    }

    /**
     * @param string $value
     * @return \CrudGenerator\MetaData\Sources\MetadataConfig
     */
    public function setConnector($value)
    {
        $this->connector = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return \CrudGenerator\MetaData\Sources\MetadataConfig
     */
    public function setConnectorConfig($value)
    {
        $this->connectorConfig = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'uniqueName'         => $this->getUniqueName(),
            'metadataDaoFactory' => $this->getMetadataDaoFactory(),
            'connector'          => $this->connector
        );
    }
}
