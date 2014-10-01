<?php
namespace CrudGenerator\Tests\General\MetaData\Sources\MySQL\MySQLMetaDataDAO;

use CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAOFactory;
use CrudGenerator\MetaData\Driver\Web\WebDriverFactory;
use CrudGenerator\MetaData\Driver\Pdo\PdoDriverFactory;

/**
 * @requires extension pdo_mysql
 */
class GetMetadataForTest extends \PHPUnit_Framework_TestCase
{
    public function testTypecc()
    {
        $config = include __DIR__ . '/../Config.php';

        $suT = MySQLMetaDataDAOFactory::getInstance(PdoDriverFactory::getInstance(), $config);

        $this->assertInstanceOf(
            'CrudGenerator\MetaData\Sources\MySQL\MetadataDataObjectMySQL',
            $suT->getMetadataFor('messages')
        );
    }
}
