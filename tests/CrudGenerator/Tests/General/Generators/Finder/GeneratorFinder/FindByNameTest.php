<?php
namespace CrudGenerator\Tests\General\Generators\Finder\GeneratorFinder;

use CrudGenerator\Generators\Finder\GeneratorFinder;
use CrudGenerator\Utils\FileManager;
use CrudGenerator\Utils\YamlFactory;

class FindByNameTest extends \PHPUnit_Framework_TestCase
{
    public function testFail()
    {
        $fileManager = new FileManager();

        $suT = new GeneratorFinder($fileManager, YamlFactory::getInstance());

        $this->setExpectedException('InvalidArgumentException');

        $suT->findByName('fail');
    }

    public function testOk()
    {
        $fileManager = new FileManager();

        $suT = new GeneratorFinder($fileManager, YamlFactory::getInstance());

        $this->assertInternalType(
            'string',
            $suT->findByName('ArchitectGenerator')
        );
    }
}
