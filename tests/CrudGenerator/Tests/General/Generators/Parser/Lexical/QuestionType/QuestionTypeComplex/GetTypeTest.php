<?php
namespace CrudGenerator\Tests\General\Generators\Parser\Lexical\QuestionType\QuestionTypeComplex;

use CrudGenerator\Generators\Parser\Lexical\QuestionType\QuestionTypeComplex;
use CrudGenerator\Generators\Parser\Lexical\Iterator\IteratorValidator;
use CrudGenerator\Generators\Parser\Lexical\Condition\ConditionValidatorFactory;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Utils\PhpStringParserFactory;
use CrudGenerator\DataObject;
use CrudGenerator\MetaData\Sources\MySQL\MetadataDataObjectMySQL;
use CrudGenerator\MetaData\DataObject\MetaDataColumnCollection;
use CrudGenerator\MetaData\DataObject\MetaDataRelationCollection;
use CrudGenerator\Tests\TestCase;
use CrudGenerator\Generators\Parser\Lexical\QuestionTypeEnum;

class GetTypeTest extends TestCase
{
    public function testWellParsed()
    {
        $context   = $this->createMock('CrudGenerator\Context\CliContext');

        $sUT = new QuestionTypeComplex($context);

        $this->assertEquals(QuestionTypeEnum::COMPLEX, $sUT->getType());
    }
}