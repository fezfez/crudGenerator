<?php
namespace CrudGenerator\Tests\General\Generators\Parser\Lexical\QuestionType\QuestionTypeComplex;

use CrudGenerator\DataObject;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Generators\Parser\Lexical\QuestionType\QuestionTypeComplex;
use CrudGenerator\Metadata\DataObject\MetaDataColumnCollection;
use CrudGenerator\Metadata\DataObject\MetaDataRelationCollection;
use CrudGenerator\Metadata\Sources\MySQL\MetadataDataObjectMySQL;
use CrudGenerator\Tests\TestCase;

class EvaluateQuestionTest extends TestCase
{
    public function testWellParsed()
    {
        $context   = $this->createMock('CrudGenerator\Context\CliContext');
        $phpParser = $this->createMock('CrudGenerator\Utils\PhpStringParser');
        $generator = new GeneratorDataObject();

        $sUT = new QuestionTypeComplex($context);

        $questionArray = array(
            'factory' => 'CrudGenerator\Tests\General\Generators\Parser\Lexical\MyFakeQuestionFactory',
        );

        $dto       = new DataObject();
        $metadata  = new MetadataDataObjectMySQL(new MetaDataColumnCollection(), new MetaDataRelationCollection());

        $dto->setMetadata($metadata);
        $generator->setDto($dto);

        $this->assertInstanceOf(
            'CrudGenerator\Generators\GeneratorDataObject',
            $sUT->evaluateQuestion($questionArray, $phpParser, $generator)
        );
    }

    public function testFactoryNoSet()
    {
        $sUT = new QuestionTypeComplex($this->createMock('CrudGenerator\Context\CliContext'));

        $this->setExpectedException('Exception');

        $sUT->evaluateQuestion(
            array(),
            $this->createMock('CrudGenerator\Utils\PhpStringParser'),
            new GeneratorDataObject()
        );
    }

    public function testFactoryNotString()
    {
        $sUT = new QuestionTypeComplex($this->createMock('CrudGenerator\Context\CliContext'));

        $this->setExpectedException('Exception');

        $sUT->evaluateQuestion(
            array('factory' => array()),
            $this->createMock('CrudGenerator\Utils\PhpStringParser'),
            new GeneratorDataObject()
        );
    }

    public function testFactoryClassDoesNotExist()
    {
        $sUT = new QuestionTypeComplex($this->createMock('CrudGenerator\Context\CliContext'));

        $this->setExpectedException('Exception');

        $sUT->evaluateQuestion(
            array('factory' => 'MyClass'),
            $this->createMock('CrudGenerator\Utils\PhpStringParser'),
            new GeneratorDataObject()
        );
    }

    public function testFactoryWrongImplementation()
    {
        $sUT = new QuestionTypeComplex($this->createMock('CrudGenerator\Context\CliContext'));

        $this->setExpectedException('Exception');

        $sUT->evaluateQuestion(
            array('factory' => __CLASS__),
            $this->createMock('CrudGenerator\Utils\PhpStringParser'),
            new GeneratorDataObject()
        );
    }

    public function testFactoryReturnNotWellImplementation()
    {
        $sUT = new QuestionTypeComplex($this->createMock('CrudGenerator\Context\CliContext'));

        $this->setExpectedException('Exception');

        $sUT->evaluateQuestion(
            array('factory' => 'CrudGenerator\Tests\General\Generators\Parser\Lexical\MyFakeQuestionNotWellConfiguredFactory'),
            $this->createMock('CrudGenerator\Utils\PhpStringParser'),
            new GeneratorDataObject()
        );
    }

    public function testFactoryReturnNotObject()
    {
        $sUT = new QuestionTypeComplex($this->createMock('CrudGenerator\Context\CliContext'));

        $this->setExpectedException('Exception');

        $sUT->evaluateQuestion(
            array('factory' => 'CrudGenerator\Tests\General\Generators\Parser\Lexical\MyFakeQuestionReturnBoolFactory'),
            $this->createMock('CrudGenerator\Utils\PhpStringParser'),
            new GeneratorDataObject()
        );
    }
}
