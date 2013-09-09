<?php
namespace CrudGenerator\Tests\General\ConfigManager\ConfigMetadata\Manager\YamlConfigMetadata;

use CrudGenerator\ConfigManager\ConfigMetadata\ManagerFactory;
use CrudGenerator\Generators\ArchitectGenerator\Architect;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testManagerOk()
    {
        chdir(__DIR__ .'/../../../Data/');

        $manager = ManagerFactory::getInstance('Sample.yml');

        $this->assertInstanceOf(
            'CrudGenerator\Generators\ArchitectGenerator\Architect',
            $manager->writeAbstractOptions('CrudGenerator\Generators\ArchitectGenerator\ArchitectGenerator', new Architect())
        );
    }
}