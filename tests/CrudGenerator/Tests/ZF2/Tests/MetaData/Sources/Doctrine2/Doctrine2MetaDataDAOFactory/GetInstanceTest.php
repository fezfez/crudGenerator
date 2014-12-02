<?php
namespace CrudGenerator\Tests\ZF2\Tests\MetaData\Sources\Doctrine2\Doctrine2MetaDataDAOFactory;

use CrudGenerator\MetaData\Sources\Doctrine2\Doctrine2MetaDataDAOFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testOk()
    {
         chdir(__DIR__ . '/../../../');

         $this->assertInstanceOf(
            'CrudGenerator\MetaData\Sources\Doctrine2\Doctrine2MetaDataDAO',
             Doctrine2MetaDataDAOFactory::getInstance()
        );
    }
}