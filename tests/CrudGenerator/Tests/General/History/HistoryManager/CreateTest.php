<?php
namespace CrudGenerator\Tests\General\History\HistoryManager;

use CrudGenerator\History\HistoryManager;
use CrudGenerator\FileManager;
use CrudGenerator\Generators\GeneratorFinderFactory;
use CrudGenerator\Generators\ArchitectGenerator\Architect;

class CreateTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        // wakeup classes
        $generatorFinder = GeneratorFinderFactory::getInstance();
        $generatorFinder->getAllClasses();

        $stubFileManager = $this->getMock('\CrudGenerator\FileManager');
        $stubFileManager->expects($this->once())
                        ->method('isDir')
                        ->will($this->returnValue(false));
        $stubFileManager->expects($this->once())
                        ->method('mkdir')
                        ->will($this->returnValue(true));
        $stubFileManager->expects($this->once())
                        ->method('isFile')
                        ->will($this->returnValue(true));
        $stubFileManager->expects($this->once())
                        ->method('unlink')
                        ->will($this->returnValue(true));
        $stubFileManager->expects($this->once())
                        ->method('filePutsContent')
                        ->will($this->returnValue(true));

        $sUT = new HistoryManager($stubFileManager);

        $dataObject = new Architect();
        $dataObject->setEntity('toto');

        $sUT->create($dataObject);
    }
}