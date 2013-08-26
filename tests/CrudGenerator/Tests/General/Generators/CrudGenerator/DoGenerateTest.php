<?php
namespace CrudGenerator\Tests\General\Generators\CrudGenerator;

use CrudGenerator\View\ViewFactory;
use CrudGenerator\FileManager;
use CrudGenerator\Generators\GeneriqueQuestions;
use CrudGenerator\Diff\DiffPHP;
use CrudGenerator\Generators\CrudGenerator\CrudGenerator;
use CrudGenerator\Generators\CrudGenerator\Crud;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Helper\DialogHelper;

use CrudGenerator\MetaData\Doctrine2\Doctrine2MetaDataDAO;
use CrudGenerator\EnvironnementResolver\ZendFramework2Environnement;

class DoGenerateTest extends \PHPUnit_Framework_TestCase
{
    public function testType()
    {
        $stubDialog = $this->getMock('\Symfony\Component\Console\Helper\DialogHelper');
        $stubDialog->expects($this->any())
                   ->method('askAndValidate')
                   ->will($this->returnValue(__DIR__));

        $stubDialog->expects($this->any())
                   ->method('ask')
                   ->will($this->returnValue('y'));

        $stubOutput =  $this->getMockBuilder('Symfony\Component\Console\Output\ConsoleOutput')
                            ->disableOriginalConstructor()
                            ->getMock();
        $stubOutput->expects($this->any())
                   ->method('writeln')
                   ->will($this->returnValue(''));

        $stubFileManager = $this->getMock('\CrudGenerator\FileManager');
        $stubFileManager->expects($this->any())
                        ->method('mkdir')
                        ->will($this->returnValue(true));
        $stubFileManager->expects($this->any())
                        ->method('filePutsContent')
                        ->will($this->returnValue(true));

        $view              = ViewFactory::getInstance();
        $generiqueQuestion = new GeneriqueQuestions($stubDialog, $stubOutput, new FileManager());
        $diffPHP           = new DiffPHP();


        $metadata = new Crud();
        $metadata->setEntity('TestZf2\Entities\NewsEntity')
                 ->setMetadata($this->getMetadata());

        $sUT = new CrudGenerator(
            $view,
            $stubOutput,
            $stubFileManager,
            $stubDialog,
            $generiqueQuestion,
            $diffPHP
        );
        $sUT->generate($metadata);
    }

    private function getMetadata()
    {
        $stubFileManager = $this->getMock('\CrudGenerator\FileManager');
        $stubFileManager->expects($this->any())
                        ->method('fileExists')
                        ->will($this->returnValue(true));

        $stubFileManager->expects($this->any())
                        ->method('includeFile')
                        ->will($this->returnValue(include __DIR__ . '/../../../ZF2/config/application.config.php'));

        $sm = ZendFramework2Environnement::getDependence($stubFileManager);
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $suT = new Doctrine2MetaDataDAO($em);

        return $suT->getMetadataFor('TestZf2\Entities\NewsEntity');
    }
}