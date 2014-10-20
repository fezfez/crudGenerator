<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\History;

use CrudGenerator\Utils\FileManager;
use CrudGenerator\History\HistoryCollection;
use CrudGenerator\History\History;
use CrudGenerator\History\HistoryHydrator;
use CrudGenerator\EnvironnementResolver\EnvironnementResolverException;
use CrudGenerator\Generators\GeneratorDataObject;

/**
 * HistoryManager instance
 *
 * @author Stéphane Demonchaux
 */
class HistoryManager
{
    /**
     * @var string History directory path
     */
    const HISTORY_PATH = 'data/crudGenerator/History/';
    /**
     * @var FileManager File manager
     */
    private $fileManager = null;
    /**
     * @var HistoryHydrator
     */
    private $historyHydrator = null;

    /**
     * @param FileManager $fileManager
     * @param HistoryHydrator $historyHydrator
     */
    public function __construct(FileManager $fileManager, HistoryHydrator $historyHydrator)
    {
        $this->fileManager     = $fileManager;
        $this->historyHydrator = $historyHydrator;
    }

    /**
     * Create history
     * @param GeneratorDataObject $dataObject
     */
    public function create(GeneratorDataObject $dataObject)
    {
        if ($this->fileManager->isDir(self::HISTORY_PATH) === false) {
            $this->fileManager->mkdir(self::HISTORY_PATH);
        }

        $dto = $dataObject->getDto();

        if (null === $dto) {
            throw new \InvalidArgumentException('DTO cant be empty');
        }

        $metadata = $dto->getMetaData();

        if (null === $metadata) {
            throw new \InvalidArgumentException('Metadata cant be empty');
        }

        $fileName = $metadata->getName(). '.history.yaml';

        if ($this->fileManager->isFile(self::HISTORY_PATH . $fileName) === true) {
            $this->fileManager->unlink(self::HISTORY_PATH . $fileName);
        }

        $this->fileManager->filePutsContent(
            self::HISTORY_PATH . $fileName,
            $this->historyHydrator->dtoToJson($dataObject)
        );
    }

    /**
     * Retrieve all history
     * @throws EnvironnementResolverException
     * @return HistoryCollection
     */
    public function findAll()
    {
        if ($this->fileManager->isDir(self::HISTORY_PATH) === false) {
            throw new EnvironnementResolverException(
                sprintf(
                    'Unable to locate "%d"',
                    self::HISTORY_PATH
                )
            );
        }

        $historyCollection = new HistoryCollection();

        foreach ($this->fileManager->glob(self::HISTORY_PATH . '*.history.yaml') as $file) {
            $content = $this->fileManager->fileGetContent($file);

            try {
                $historyCollection->append($this->historyHydrator->jsonToDTO($content));
            } catch (InvalidHistoryException $e) {
                continue;
            }
        }

        return $historyCollection;
    }

    /**
     * @param string $historyName
     * @throws HistoryNotFound
     * @return \CrudGenerator\History\History
     */
    public function find($historyName)
    {
        $filePath = self::HISTORY_PATH . $historyName . '.history.yaml';

        if ($this->fileManager->isFile($filePath) === false) {
            throw new HistoryNotFoundException(
                sprintf(
                    'History with name "%d" not found',
                    $historyName
                )
            );
        }

        return $this->historyHydrator->jsonToDTO(
            $this->fileManager->fileGetContent($filePath)
        );
    }
}
