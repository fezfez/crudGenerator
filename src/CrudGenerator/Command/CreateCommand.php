<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace CrudGenerator\Command;

use CrudGenerator\History\HistoryManager;
use CrudGenerator\Generators\Questions\Cli\MetaDataSourcesQuestion;
use CrudGenerator\Generators\Questions\Cli\DirectoryQuestion;
use CrudGenerator\Generators\Questions\Cli\MetaDataQuestion;
use CrudGenerator\Generators\Questions\Cli\GeneratorQuestion;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\DataObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputInterface;
use CrudGenerator\Context\CliContext;

/**
 * Generator command
 *
 * @author Stéphane Demonchaux
 */
class CreateCommand extends Command
{
    /**
     * @var DialogHelper
     */
    private $dialog = null;
    /**
     * @var OutputInterface
     */
    private $output = null;
    /**
     * @var HistoryManager
     */
    private $historyManager = null;
    /**
     * @var MetaDataSourcesQuestion
     */
    private $metaDataSourcesQuestion = null;
    /**
     * @var DirectoryQuestion
     */
    private $directoryQuestion = null;
    /**
     * @var MetaDataQuestion
     */
    private $metaDataQuestion = null;
    /**
     * @var GeneratorQuestion
     */
    private $generatorQuestion = null;
    /**
     * @var CliContext
     */
    private $cliContext = null;

    /**
     * @param DialogHelper $dialog
     * @param OutputInterface $output
     * @param HistoryManager $historyManager
     * @param MetaDataSourcesQuestion $metaDataSourcesQuestion
     * @param DirectoryQuestion $directoryQuestion
     * @param MetaDataQuestion $metaDataQuestion
     * @param GeneratorQuestion $generatorQuestion
     */
    public function __construct(
        DialogHelper $dialog,
        OutputInterface $output,
        HistoryManager $historyManager,
        MetaDataSourcesQuestion $metaDataSourcesQuestion,
        DirectoryQuestion $directoryQuestion,
        MetaDataQuestion $metaDataQuestion,
        GeneratorQuestion $generatorQuestion,
    	CliContext $cliContext
    ) {
        parent::__construct('create');
        $this->dialog = $dialog;
        $this->output = $output;
        $this->historyManager = $historyManager;
        $this->metaDataSourcesQuestion = $metaDataSourcesQuestion;
        $this->directoryQuestion = $directoryQuestion;
        $this->metaDataQuestion = $metaDataQuestion;
        $this->generatorQuestion = $generatorQuestion;
        $this->cliContext         = $cliContext;
    }
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName('CodeGenerator:create')
             ->setDescription('Generate code based on metadata');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->create();
    }

    /**
     * @param DataObject $dto
     * @param string $generatorName
     * @throws \RuntimeException
     * @return DataObject
     */
    public function create(DataObject $dto = null, $generatorName = null)
    {
        if (null !== $dto) {
            $adapter    = $this->metaDataSourcesQuestion->ask($dto->getAdapter());
            $metadata   = $this->metaDataQuestion->ask($adapter, $dto->getMetadata());
            $generator  = $this->generatorQuestion->ask($generatorName);
        } else {
            $adapter    = $this->metaDataSourcesQuestion->ask();
            $metadata   = $this->metaDataQuestion->ask($adapter);
            $generator  = $this->generatorQuestion->ask();
        }

        $generatorParser = \CrudGenerator\Generators\Parser\GeneratorParserFactory::getInstance($this->cliContext);

        $generatorDTO = new GeneratorDataObject();
        $generatorDTO->setName($generator);
        $this->directoryQuestion->ask($generatorDTO);
        $generatorDTO = $generatorParser->init($generatorDTO, $metadata);

        $DTO    = $generatorDTO->getDTO();

        $DTO->setEntity($metadata->getName())
                   ->setMetaData($metadata)
                   ->setAdapter($adapter->getName());

        $this->output->writeln("<info>Resume</info>");
        $this->output->writeln('<info>Metadata : ' . $DTO->getEntity(), '*</info>');
        $this->output->writeln('<info>Directory : ' . $DTO->getModule(), '*</info>');
        //$this->output->writeln("<info>Generator : " . $generator->getDefinition(), "*</info>");

        $doI = $this->dialog->askConfirmation(
            $this->output,
            "\n<question>Do you confirm generation (may others question generator ask you) ?</question> "
        );

        if ($doI === true) {
            //$dataObject = $generator->generate($dataObject);
            //$this->historyManager->create($dataObject);

            return $DTO;
        } else {
            throw new \RuntimeException('Command aborted');
        }
    }
}
