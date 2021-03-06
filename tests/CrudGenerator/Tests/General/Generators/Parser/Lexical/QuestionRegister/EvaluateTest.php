<?php
namespace CrudGenerator\Tests\General\Generators\Parser\Lexical\QuestionRegister;

use CrudGenerator\DataObject;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Generators\Parser\Lexical\QuestionAnalyser;
use CrudGenerator\Generators\Parser\Lexical\QuestionRegister;
use CrudGenerator\Generators\Parser\Lexical\QuestionType\QuestionTypeCollectionFactory;
use CrudGenerator\Tests\TestCase;

class EvaluateTest extends TestCase
{
    public function testWithEmptyQuestion()
    {
        $conditionValidator     = $this->_('CrudGenerator\Generators\Parser\Lexical\Condition\ConditionValidator');
        $context                = $this->_('CrudGenerator\Context\CliContext');
        $phpParser              = $this->_('CrudGenerator\Utils\PhpStringParser');
        $questionTypeCollection = QuestionTypeCollectionFactory::getInstance($context);
        $questionAnalyser       = new QuestionAnalyser();

        $sUT = new QuestionRegister($context, $conditionValidator, $questionTypeCollection, $questionAnalyser);

        $generator = new GeneratorDataObject();
        $generator->setDto(new DataObject());

        $process = array(
            'questions' => array(
                'toto',
            ),
        );

        $this->setExpectedException('CrudGenerator\Generators\Parser\Lexical\MalformedGeneratorException');

        $sUT->evaluate($process, $phpParser, $generator, true);
    }

    public function testMalformedQuestion()
    {
        $conditionValidator     = $this->_('CrudGenerator\Generators\Parser\Lexical\Condition\ConditionValidator');
        $context                = $this->_('CrudGenerator\Context\CliContext');
        $phpParser              = $this->_('CrudGenerator\Utils\PhpStringParser');
        $questionTypeCollection = QuestionTypeCollectionFactory::getInstance($context);
        $questionAnalyser       = new QuestionAnalyser();

        $sUT = new QuestionRegister($context, $conditionValidator, $questionTypeCollection, $questionAnalyser);

        $generator = new GeneratorDataObject();
        $generator->setDto(new DataObject());

        $process = array(
            'questions' => array(
                'MyQuestion' => 'myQuestionValue',
            ),
        );

        $this->setExpectedException('CrudGenerator\Generators\Parser\Lexical\MalformedGeneratorException');

        $sUT->evaluate($process, $phpParser, $generator, true);
    }

    public function testWithConditionNotAllow()
    {
        $conditionValidator     = $this->_('CrudGenerator\Generators\Parser\Lexical\Condition\ConditionValidator');
        $context                = $this->_('CrudGenerator\Context\CliContext');
        $phpParser              = $this->_('CrudGenerator\Utils\PhpStringParser');
        $questionTypeCollection = QuestionTypeCollectionFactory::getInstance($context);
        $questionAnalyser       = new QuestionAnalyser();

        $sUT = new QuestionRegister($context, $conditionValidator, $questionTypeCollection, $questionAnalyser);

        $generator = new GeneratorDataObject();
        $generator->setDto(new DataObject());

        $process = array(
            'questions' => array(
                'MyQuestion' => array('myQuestionValue'),
            ),
        );

        $conditionValidatorExpects = $conditionValidator->expects($this->once());
        $conditionValidatorExpects->method('isValid');
        $conditionValidatorExpects->willReturn(false);

        $generator = $sUT->evaluate($process, $phpParser, $generator, true);

        $this->assertEquals(array(), $generator->getDto()->getStore());
    }
}
