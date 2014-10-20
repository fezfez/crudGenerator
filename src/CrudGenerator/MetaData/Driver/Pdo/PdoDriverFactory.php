<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\MetaData\Driver\Pdo;

use CrudGenerator\MetaData\Driver\DriverConfig;
use CrudGenerator\MetaData\Driver\Driver;
use CrudGenerator\MetaData\Driver\DriverFactoryInterface;

class PdoDriverFactory implements DriverFactoryInterface
{
    /**
     * @return \CrudGenerator\MetaData\Driver\Pdo\PdoDriver
     */
    public static function getInstance()
    {
        return new PdoDriver();
    }

    /**
     * @return \CrudGenerator\MetaData\Driver\Driver
     */
    public static function getDescription()
    {
        $config = new DriverConfig('Web');
        $config->addQuestion('Database Name', 'configDatabaseName');
        $config->addQuestion('Host', 'configHost');
        $config->addQuestion('User', 'configUser');
        $config->addQuestion('Password', 'configPassword');
        $config->addQuestion('Port', 'configPort');

        $dataObject = new Driver();
        $dataObject->setDefinition('Pdo connector')
                   ->setConfig($config)
                   ->setUniqueName('PDO');

        return $dataObject;
    }
}
