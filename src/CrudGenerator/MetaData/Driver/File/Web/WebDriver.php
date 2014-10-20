<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData\Driver\File\Web;

use CrudGenerator\MetaData\Config\ConfigException;
use CrudGenerator\Utils\FileManager;
use CrudGenerator\MetaData\Driver\DriverConfig;
use CrudGenerator\MetaData\Driver\File\FileDriverInterface;
use CrudGenerator\MetaData\Driver\DriverInterface;

/**
 * Json configuration for Json Metadata adapter
 *
 * @author Stéphane Demonchaux
 */
class WebDriver implements FileDriverInterface, DriverInterface
{
    /**
     * @var FileManager
     */
    private $fileManager = null;

    /**
     * Constructor.
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * @throws ConfigException
     * @return string
     */
    public function getFile(DriverConfig $driverConfig)
    {
        try {
            return $this->fileManager->fileGetContent($driverConfig->getResponse('configUrl'));
        } catch (\RuntimeException $e) {
            throw new ConfigException($e->getMessage());
        }
    }

    public function isValid(DriverConfig $driverConfig)
    {
        $this->getFile($driverConfig);
        return true;
    }

    /* (non-PHPdoc)
     * @see \CrudGenerator\MetaData\Sources\MetaDataConnectorInterface::getDefinition()
     */
    public function getUniqueName(DriverConfig $config)
    {
        return $config->getResponse('configUrl');
    }
}
