<?php
namespace CrudGenerator\Tests\General\Command\Questions\HistoryQuestionFactory;

use CrudGenerator\Generators\Questions\HistoryQuestionFactory;
use CrudGenerator\Context\CliContext;
use CrudGenerator\Context\WebContext;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $ConsoleOutputStub =  $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
        ->disableOriginalConstructor()
        ->getMock();

        $dialog = $this->getMockBuilder('Symfony\Component\Console\Helper\DialogHelper')
        ->disableOriginalConstructor()
        ->getMock();

        $context = new CliContext($dialog, $ConsoleOutputStub);

        $this->assertInstanceOf(
            'CrudGenerator\Generators\Questions\Cli\HistoryQuestion',
            HistoryQuestionFactory::getInstance($context)
        );
    }

    public function testFailInstanceWeb()
    {
        $app =  $this->getMockBuilder('Silex\Application')
        ->disableOriginalConstructor()
        ->getMock();

        $context = new WebContext($app);

        $this->setExpectedException('InvalidArgumentException');
        HistoryQuestionFactory::getInstance($context);
    }
}