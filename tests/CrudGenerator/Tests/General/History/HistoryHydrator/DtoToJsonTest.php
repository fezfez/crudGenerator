<?php
namespace CrudGenerator\Tests\General\History\HistoryHydrator;

use CrudGenerator\History\HistoryHydrator;
use CrudGenerator\DataObject;
use CrudGenerator\MetaData\DataObject\MetaDataColumnCollection;
use CrudGenerator\MetaData\DataObject\MetaDataRelationCollection;
use CrudGenerator\MetaData\Sources\Doctrine2\MetadataDataObjectDoctrine2;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\MetaData\MetaDataSource;
use CrudGenerator\MetaData\Driver\DriverConfig;
use KeepUpdate\ArrayValidatorFactory;
use CrudGenerator\MetaData\Driver\File\Web\WebDriverFactory;
use CrudGenerator\Tests\TestCase;

class DtoToJsonTest extends TestCase
{
    public function testWithInvalidHistory()
    {
        $stubMetadataSourceQuestion = $this->createMock(
            'CrudGenerator\Generators\Questions\MetadataSourceConfigured\MetadataSourceConfiguredQuestion'
        );

        $stubMetadataSource = $this->createMock('CrudGenerator\Generators\Questions\Metadata\MetadataQuestion');

        $sUT = new HistoryHydrator($stubMetadataSourceQuestion, $stubMetadataSource, ArrayValidatorFactory::getInstance());

        $dataObject = new DataObject();
        $generator  = new GeneratorDataObject();

        $generator->setDto($dataObject);
        $this->setExpectedException('CrudGenerator\History\InvalidHistoryException');

        $sUT->dtoToJson($generator);
    }

    public function testOk()
    {
        $stubMetadataSourceQuestion = $this->createMock(
            'CrudGenerator\Generators\Questions\MetadataSourceConfigured\MetadataSourceConfiguredQuestion'
        );

        $stubMetadataSource = $this->createMock('CrudGenerator\Generators\Questions\Metadata\MetadataQuestion');

        $sUT = new HistoryHydrator(
            $stubMetadataSourceQuestion,
            $stubMetadataSource,
            ArrayValidatorFactory::getInstance()
        );

        $driverConfig = new DriverConfig("test");
        $driverConfig->setMetadataDaoFactory("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAOFactory")
                     ->setDriver('CrudGenerator\MetaData\Driver\File\Web\WebDriverFactory');

        $source = new MetaDataSource();

        $source->setConfig($driverConfig)
               ->setMetadataDao("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAO")
               ->setMetadataDaoFactory("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAOFactory");

        $metaData = new MetadataDataObjectDoctrine2(
            new MetaDataColumnCollection(),
            new MetaDataRelationCollection()
        );
        $metaData->setName('MyName');

        $dataObject = new DataObject();
        $dataObject->setMetadata($metaData);

        $generator = new GeneratorDataObject();
        $generator->setDto($dataObject)
                  ->setMetadataSource($source);

        $this->assertInternalType('string', $sUT->dtoToJson($generator));
    }

    public function testBoth()
    {
        $stubMetadataSourceQuestion = $this->createMock(
            'CrudGenerator\Generators\Questions\MetadataSourceConfigured\MetadataSourceConfiguredQuestion'
        );

        $stubMetadataSource = $this->createMock('CrudGenerator\Generators\Questions\Metadata\MetadataQuestion');

        $sUT = new HistoryHydrator($stubMetadataSourceQuestion, $stubMetadataSource, ArrayValidatorFactory::getInstance());

        $metaData = new MetadataDataObjectDoctrine2(
            new MetaDataColumnCollection(),
            new MetaDataRelationCollection()
        );
        $metaData->setName('MyName');

        $driverConfig = new DriverConfig("test");
        $driverConfig->setMetadataDaoFactory("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAOFactory")
                     ->setDriver('CrudGenerator\MetaData\Driver\File\Web\WebDriverFactory');

        $source = new MetaDataSource();
        $source->setConfig($driverConfig)
               ->setMetadataDao("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAO")
               ->setMetadataDaoFactory("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAOFactory");

        $stubMetadataSourceQuestion->expects($this->once())
        ->method('ask')
        ->will($this->returnValue($source));

        $stubMetadataSource->expects($this->once())
        ->method('ask')
        ->with($source)
        ->will($this->returnValue($metaData));

        $dataObject = new DataObject();
        $dataObject->setMetadata($metaData);

        $generator = new GeneratorDataObject();
        $generator->setMetadataSource($source)
                  ->setDto($dataObject);

        $yaml = $sUT->dtoToJson($generator);
        $sUT->jsonToDto($yaml);
    }
}
