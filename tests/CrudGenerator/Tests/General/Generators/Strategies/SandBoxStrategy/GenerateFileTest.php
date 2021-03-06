<?php
namespace CrudGenerator\Tests\General\Generators\Strategies\SandBoxStrategy;

use CrudGenerator\DataObject;
use CrudGenerator\Generators\Strategies\SandBoxStrategy;

class GenerateFileTest extends \PHPUnit_Framework_TestCase
{
    public function testWithGenerate()
    {
        $view = $this->getMockBuilder('CrudGenerator\View\View')
        ->disableOriginalConstructor()
        ->getMock();

        $context =  $this->getMockBuilder('CrudGenerator\Context\CliContext')
        ->disableOriginalConstructor()
        ->getMock();

        $templateResult = 'MyResults';
        $dataObject     = new DataObject();
        $skeletonDir    = 'MySkeletonDir';
        $pathTemplate   = 'myPathTemplate';
        $pathTo         = 'MyPathTo';

        $view->expects($this->exactly(2))
        ->method('render')
        ->with(
            $this->equalTo($skeletonDir),
            $this->equalTo($pathTemplate),
            $this->equalTo(
                array(
                    'dataObject' => $dataObject,
                )
            )
        )
        ->will($this->returnValue($templateResult));

        $context->expects($this->exactly(2))
        ->method('confirm')
        ->will($this->onConsecutiveCalls($this->returnValue(true), $this->returnValue(false)));

        $sUT = new SandBoxStrategy($view, $context);

        $sUT->generateFile(array('dataObject' => $dataObject), $skeletonDir, $pathTemplate, $pathTo);
    }
}
