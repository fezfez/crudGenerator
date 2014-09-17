<?php
namespace CrudGenerator\Tests\General\History\HistoryHydrator;

use CrudGenerator\History\HistoryHydrator;
use CrudGenerator\DataObject;
use CrudGenerator\MetaData\DataObject\MetaDataColumnCollection;
use CrudGenerator\MetaData\DataObject\MetaDataRelationCollection;
use CrudGenerator\MetaData\Sources\Doctrine2\MetadataDataObjectDoctrine2;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\MetaData\MetaDataSource;
use CrudGenerator\MetaData\Sources\MySQL\MySQLConfig;

class DtoToJsonTest extends \PHPUnit_Framework_TestCase
{
    public function testWithInvalidHistory()
    {
        $stubMetadataSourceQuestion = $this->getMockBuilder(
            'CrudGenerator\Generators\Questions\Web\MetaDataSourcesConfiguredQuestion'
        )
        ->disableOriginalConstructor()
        ->getMock();

        $stubMetadataSource = $this->getMockBuilder('CrudGenerator\Generators\Questions\Web\MetaDataQuestion')
        ->disableOriginalConstructor()
        ->getMock();

        $sUT = new HistoryHydrator($stubMetadataSourceQuestion, $stubMetadataSource);

        $dataObject = new DataObject();
        $generator  = new GeneratorDataObject();

        $generator->setDTO($dataObject);
        $this->setExpectedException('CrudGenerator\History\InvalidHistoryException');

        $sUT->dtoToJson($generator);
    }

    public function testOk()
    {
        $stubMetadataSourceQuestion = $this->getMockBuilder(
            'CrudGenerator\Generators\Questions\Web\MetaDataSourcesConfiguredQuestion'
        )
        ->disableOriginalConstructor()
        ->getMock();

        $stubMetadataSource = $this->getMockBuilder('CrudGenerator\Generators\Questions\Web\MetaDataQuestion')
        ->disableOriginalConstructor()
        ->getMock();

        $sUT = new HistoryHydrator($stubMetadataSourceQuestion, $stubMetadataSource);

        $source = new MetaDataSource();
        $source->setConfig(new MySQLConfig())
        ->setMetaDataDAO("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAO")
        ->setMetaDataDAOFactory("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAOFactory");

        $metaData = new MetadataDataObjectDoctrine2(
            new MetaDataColumnCollection(),
            new MetaDataRelationCollection()
        );
        $metaData->setName('MyName');

        $dataObject = new DataObject();
        $dataObject->setMetadata($metaData);

        $generator = new GeneratorDataObject();
        $generator->setDTO($dataObject)
                  ->setMetadataSource($source);

        $this->assertInternalType('string', $sUT->dtoToJson($generator));
    }

    public function testBoth()
    {
        $stubMetadataSourceQuestion = $this->getMockBuilder(
            'CrudGenerator\Generators\Questions\Web\MetaDataSourcesConfiguredQuestion'
        )
        ->disableOriginalConstructor()
        ->getMock();

        $stubMetadataSource = $this->getMockBuilder('CrudGenerator\Generators\Questions\Web\MetaDataQuestion')
        ->disableOriginalConstructor()
        ->getMock();

        $sUT = new HistoryHydrator($stubMetadataSourceQuestion, $stubMetadataSource);

        $metaData = new MetadataDataObjectDoctrine2(
            new MetaDataColumnCollection(),
            new MetaDataRelationCollection()
        );
        $metaData->setName('MyName');

        $source = new MetaDataSource();
        $source->setConfig(new MySQLConfig())
               ->setMetaDataDAO("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAO")
               ->setMetaDataDAOFactory("CrudGenerator\MetaData\Sources\MySQL\MySQLMetaDataDAOFactory");

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
                  ->setDTO($dataObject);

        $yaml = $sUT->dtoToJson($generator);
        $sUT->jsonToDto($yaml);
    }
}
