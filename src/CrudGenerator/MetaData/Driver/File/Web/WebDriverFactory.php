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

use CrudGenerator\Utils\FileManager;
use CrudGenerator\MetaData\Driver\DriverConfig;
use CrudGenerator\MetaData\Driver\Driver;
use CrudGenerator\MetaData\Driver\DriverFactoryInterface;

class WebDriverFactory implements DriverFactoryInterface
{
    /**
     * @return \CrudGenerator\MetaData\Driver\File\Web\WebDriver
     */
    public static function getInstance()
    {
        return new WebDriver(new FileManager());
    }

    /**
     * @return \CrudGenerator\MetaData\Driver\Driver
     */
    public static function getDescription()
    {
        $config = new DriverConfig('Web');
        $config->addQuestion('Url', 'configUrl');
        $config->setDriver(__CLASS__);

        $dataObject = new Driver();
        $dataObject->setConfig($config)
                   ->setDefinition('Web connector')
                   ->setUniqueName('Web');

        return $dataObject;
    }
}
