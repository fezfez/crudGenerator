<?php
namespace CrudGenerator\Tests\General\GeneratorsEmbed\ArchitectGenerator\MetadataToArrayWeb;

use CrudGenerator\GeneratorsEmbed\ArchitectGenerator\Architect;
use CrudGenerator\GeneratorsEmbed\ArchitectGenerator\MetadataToArrayWeb;
use CrudGenerator\Generators\GeneratorDataObject;

class AskTest extends \PHPUnit_Framework_TestCase
{
    public function testOk()
    {
        $DTO = new Architect();
        $DTO->setEntity('TestZf2\Entities\NewsEntity')
        ->setMetadata($this->getMetadata())
        ->setNamespace('namespace')
        ->setGenerateUnitTest(true);

        $sUT = new MetadataToArrayWeb();

        $generator = new GeneratorDataObject();
        $generator->setDTO($DTO);

        $DTO = $sUT->ask($generator);
    }

    private function getMetadata()
    {
        return include __DIR__ . '/../../FakeMetaData.php';
    }
}
