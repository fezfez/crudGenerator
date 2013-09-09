<?php
namespace CrudGenerator\Tests\General\View\Helpers\TemplateDatabaseConnectorStrategies\PDOStrategy;

use CrudGenerator\View\Helpers\TemplateDatabaseConnectorStrategies\PDOStrategy;
use CrudGenerator\MetaData\Sources\PDO\MetadataDataObjectPDO;
use CrudGenerator\MetaData\DataObject\MetaDataColumn;
use CrudGenerator\MetaData\DataObject\MetaDataColumnCollection;
use CrudGenerator\MetaData\DataObject\MetaDataRelationColumn;
use CrudGenerator\MetaData\DataObject\MetaDataRelationCollection;
use CrudGenerator\Generators\ArchitectGenerator\Architect;

class GeneralTest extends \PHPUnit_Framework_TestCase
{
    public function testTypedzdzaz()
    {
        $crudDataObject = new Architect();
        $dataObject = new MetadataDataObjectPDO(
            new MetaDataColumnCollection(),
            new MetaDataRelationCollection()
        );

        $dataObject->setName('Myname');

        $column = new MetaDataColumn();
        $column->setName('Myname')
               ->setPrimaryKey(true);

        $dataObject->appendColumn($column);

        $column = new MetaDataColumn();
        $column->setName('MyColumn')
               ->setPrimaryKey(false);

        $dataObject->appendColumn($column);

        $crudDataObject->setMetadata($dataObject);

        $sUT = new PDOStrategy;

        $this->assertInternalType(
            'string',
            $sUT->getClassName()
        );

        $this->assertInternalType(
            'string',
            $sUT->getCreateInstance()
        );

        $this->assertInternalType(
            'string',
            $sUT->getFullClass()
        );

        $this->assertInternalType(
            'string',
            $sUT->getModifyQuery()
        );

        $this->assertInternalType(
            'string',
            $sUT->getPersistQuery($crudDataObject)
        );

        $this->assertInternalType(
            'string',
            $sUT->getQueryFindAll($crudDataObject)
        );

        $this->assertInternalType(
            'string',
            $sUT->getQueryFindOneBy($crudDataObject)
        );

        $this->assertInternalType(
            'string',
            $sUT->getRemoveQuery()
        );

        $this->assertInternalType(
            'string',
            $sUT->getVariableName()
        );
    }
}