<?php

use CrudGenerator\Metadata\DataObject\MetaDataColumn;
use CrudGenerator\Metadata\DataObject\MetaDataColumnCollection;
use CrudGenerator\Metadata\DataObject\MetaDataRelationCollection;
use CrudGenerator\Metadata\DataObject\MetaDataRelationColumn;
use CrudGenerator\Metadata\Sources\Doctrine2\MetadataDataObjectDoctrine2;

$metadata = new MetadataDataObjectDoctrine2(
    new MetaDataColumnCollection(),
    new MetaDataRelationCollection()
);

$metadata->setName('toto');

$column = new MetaDataColumn();
$column->setName('id')
->setNullable(true)
->setType('integer')
->setLength('100')
->setPrimaryKey(true);

$metadata->appendColumn($column);

$column = new MetaDataColumn();
$column->setName('tetze')
->setNullable(true)
->setType('integer')
->setLength('100');

$metadata->appendColumn($column);

$column = new MetaDataColumn();
$column->setName('myDate')
->setNullable(true)
->setType('date')
->setLength('100');

$metadata->appendColumn($column);

$column = new MetaDataColumn();
$column->setName('name')
->setNullable(true)
->setType('text')
->setLength('100');

$metadata->appendColumn($column);

$relation = new MetaDataRelationColumn();
$relation->setAssociationType('oneToMany')
         ->setFieldName('adresse')
         ->setFullName('test')
         ->setMetadata(clone $metadata);

$metadata->appendRelation($relation);

return $metadata;
