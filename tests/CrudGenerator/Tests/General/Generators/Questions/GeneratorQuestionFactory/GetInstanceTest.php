<?php
namespace CrudGenerator\Tests\General\Command\Questions\GeneratorQuestion;

use CrudGenerator\Generators\Questions\GeneratorQuestionFactory;
use CrudGenerator\Context\CliContext;
use CrudGenerator\Context\WebContext;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceCli()
    {
        $ConsoleOutputStub =  $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
        ->disableOriginalConstructor()
        ->getMock();

        $dialog = $this->getMockBuilder('Symfony\Component\Console\Helper\DialogHelper')
        ->disableOriginalConstructor()
        ->getMock();

        $context = new CliContext($dialog, $ConsoleOutputStub);

        $this->assertInstanceOf(
            'CrudGenerator\Generators\Questions\Cli\GeneratorQuestion',
            GeneratorQuestionFactory::getInstance($context)
        );
    }

    public function testInstanceWeb()
    {
        $app =  $this->getMockBuilder('Silex\Application')
        ->disableOriginalConstructor()
        ->getMock();

        $context = new WebContext($app);

        $this->assertInstanceOf(
            'CrudGenerator\Generators\Questions\Web\GeneratorQuestion',
            GeneratorQuestionFactory::getInstance($context)
        );
    }

    public function testFailContext()
    {
    	$context =  $this->getMockForAbstractClass('CrudGenerator\Context\ContextInterface');

    	$this->setExpectedException('InvalidArgumentException');

    	GeneratorQuestionFactory::getInstance($context);
    }
}