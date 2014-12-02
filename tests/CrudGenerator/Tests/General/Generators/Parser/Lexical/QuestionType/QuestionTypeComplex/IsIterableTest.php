<?php
namespace CrudGenerator\Tests\General\Generators\Parser\Lexical\QuestionType\QuestionTypeComplex;

use CrudGenerator\Generators\Parser\Lexical\QuestionType\QuestionTypeComplex;
use CrudGenerator\Generators\Parser\Lexical\Iterator\IteratorValidator;
use CrudGenerator\Generators\Parser\Lexical\Condition\ConditionValidatorFactory;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Utils\PhpStringParserFactory;
use CrudGenerator\DataObject;
use CrudGenerator\Metadata\Sources\MySQL\MetadataDataObjectMySQL;
use CrudGenerator\Metadata\DataObject\MetaDataColumnCollection;
use CrudGenerator\Metadata\DataObject\MetaDataRelationCollection;
use CrudGenerator\Tests\TestCase;

class IsIterableTest extends TestCase
{
    public function testWellParsed()
    {
        $context   = $this->createMock('CrudGenerator\Context\CliContext');

        $sUT = new QuestionTypeComplex($context);

        $questionArray = array(
            'factory' => 'CrudGenerator\Tests\General\Generators\Parser\Lexical\MyFakeQuestionFactory'
        );

        $this->assertFalse($sUT->isIterable($questionArray));
    }
}
