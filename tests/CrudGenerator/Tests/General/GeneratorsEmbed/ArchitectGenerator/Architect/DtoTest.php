<?php
namespace CrudGenerator\Tests\General\Generators\ArchitectGenerator\Architect;

use CrudGenerator\GeneratorsEmbed\ArchitectGenerator\Architect;

class DtoTest extends \PHPUnit_Framework_TestCase
{
    public function testType()
    {
        $sUT = new Architect();

        $sUT->setAttributeName('attribute', 'value')
        ->setGenerateUnitTest(true)
        ->setModelName('ModelName')
        ->setNamespace('MyNamespace');

        $this->assertEquals(array('attribute' => 'value'), $sUT->getAttributeName());
        $this->assertEquals('value', $sUT->getAttributeName('attribute'));
        $this->assertEquals(null, $sUT->getAttributeName('attddzribute'));
        $this->assertEquals(true, $sUT->getGenerateUnitTest());
        $this->assertEquals('ModelName', $sUT->getModelName());
        $this->assertEquals('MyNamespace', $sUT->getNamespace());
    }
}
