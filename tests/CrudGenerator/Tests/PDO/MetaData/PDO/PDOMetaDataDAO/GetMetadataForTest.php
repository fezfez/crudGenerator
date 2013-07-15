<?php
namespace CrudGenerator\Tests\PDO\MetaData\PDO\PDOMetaDataDAO;

use CrudGenerator\MetaData\PDO\PDOMetaDataDAOFactory;
use CrudGenerator\MetaData\PDO\PDOConfig;

class GetMetadataForTest extends \PHPUnit_Framework_TestCase
{
    public function testType()
    {
        $pdoConfig = new PDOConfig();
        $pdoConfig->setDatabaseName('sqlite2::database:sqlite2')
                  ->setType('sqlite2')
                  ->setPassword(null)
                  ->setUser(null)
                  ->setPort(null)
                  ->setHost(null);

        $suT = PDOMetaDataDAOFactory::getInstance($pdoConfig);

        $this->assertInstanceOf(
            'CrudGenerator\MetaData\PDO\MetadataDataObjectPDO',
            $suT->getMetadataFor('messages')
        );
    }
}
