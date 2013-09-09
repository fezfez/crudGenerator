<?php
namespace CrudGenerator\Tests\General\Generators\Strategies\SandBoxStrategy;

use CrudGenerator\View\ViewFactory;
use CrudGenerator\Utils\FileManager;
use CrudGenerator\FileConflict\FileConflictManagerFactory;
use CrudGenerator\Generators\Strategies\SandBoxStrategy;
use CrudGenerator\Generators\ArchitectGenerator\Architect;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;

class GenerateFileTest extends \PHPUnit_Framework_TestCase
{
    public function testWithGenerate()
    {
        $view = $this->getMockBuilder('CrudGenerator\View\View')
        ->disableOriginalConstructor()
        ->getMock();
        $output =  $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
        ->disableOriginalConstructor()
        ->getMock();
        $dialog =  $this->getMockBuilder('Symfony\Component\Console\Helper\DialogHelper')
        ->disableOriginalConstructor()
        ->getMock();

        $templateResult = 'MyResults';
        $dataObject     = new Architect();
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
                    'dir'        => $skeletonDir,
                    'dataObject' => $dataObject,
                )
            )
        )
        ->will($this->returnValue($templateResult));

        $dialog->expects($this->exactly(2))
        ->method('askConfirmation')
        ->will($this->onConsecutiveCalls($this->returnValue(true), $this->returnValue(false)));

        $sUT = new SandBoxStrategy($view, $output, $dialog);

        $sUT->generateFile($dataObject, $skeletonDir, $pathTemplate, $pathTo);
    }
}