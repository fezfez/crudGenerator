<?php
namespace CrudGenerator\Tests\General\GeneratorsEmbed\FormGenerator\Parse;

use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Generators\Parser\GeneratorParserFactory;
use CrudGenerator\Context\WebContext;
use CrudGenerator\Generators\Parser\ParserCollectionFactory;
use CrudGenerator\Generators\Strategies\GeneratorStrategyFactory;

class AnalyseTest extends \PHPUnit_Framework_TestCase
{
    public function testOkfezfez()
    {
    	$app = $this->getMockBuilder('Silex\Application')
		->disableOriginalConstructor()
		->getMock();

		$context = new WebContext($app);

		$generator = new GeneratorDataObject();
		$generator->setName('FormGenerator');

        $generatorParser = GeneratorParserFactory::getInstance($context);

        $generator = $generatorParser->init($generator, $this->getMetadata());

        $fileGenerator = GeneratorStrategyFactory::getInstance($context);

        foreach ($generator->getFiles() as $file) {
        	$this->assertInternalType(
				'string',
	             $fileGenerator->generateFile(
	                 $generator->getTemplateVariables(),
	                 $file['skeletonPath'],
	                 $file['name'],
	                 $file['fileName']
	             )
        	);
        }
    }

    private function getMetadata()
    {
        return include __DIR__ . '/../../FakeMetaData.php';
    }
}