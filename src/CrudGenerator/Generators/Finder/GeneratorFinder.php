<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Finder;

use CrudGenerator\MetaData\DataObject\MetaDataInterface;
use CrudGenerator\Utils\Transtyper;
use CrudGenerator\Generators\Validator\GeneratorValidator;

/**
 * Find all generator allow in project
 *
 * @author St  phane Demonchaux
 */
class GeneratorFinder implements GeneratorFinderInterface
{
    /**
     * @var Transtyper
     */
    private $transtyper = null;
    /**
     * @var GeneratorValidator
     */
    private $generatorValidator = null;
    /**
     * @var array
     */
    private static $allClasses = null;

    /**
     * Find all generator allow in project
     *
     * @param Transtyper $transtyper
     * @param GeneratorValidator $generatorValidator
     */
    public function __construct(
        Transtyper $transtyper,
        GeneratorValidator $generatorValidator
    ) {
        $this->transtyper         = $transtyper;
        $this->generatorValidator = $generatorValidator;
    }

    /**
     * Find all adapters allow in project
     *
     * @return array
     */
    public function getAllClasses(MetaDataInterface $metadata = null)
    {
        if (self::$allClasses === null) {
            $generators = array();
            $iterator   = new \RegexIterator(
                new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator(getcwd(), \FilesystemIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::LEAVES_ONLY,
                    \RecursiveIteratorIterator::CATCH_GET_CHILD
                ),
                '/^.+\.generator\.json$/i',
                \RecursiveRegexIterator::GET_MATCH
            );

            foreach ($iterator as $file) {
                $fileName = $file[0];
                $process  = $this->transtyper->decode(file_get_contents($fileName));

                try {
                    $this->generatorValidator->isValid($process, $metadata);
                    $generators[$fileName] = $process['name'];
                } catch (\InvalidArgumentException $e) {
                    // Generator no valid
                }
            }

            self::$allClasses = $generators;
        }

        return self::$allClasses;
    }

    /**
     * @param string $name
     * @throws \InvalidArgumentException
     * @return string
     */
    public function findByName($name)
    {
        $generatorCollection = $this->getAllClasses();

        foreach ($generatorCollection as $generatorFile => $generatorName) {
            if ($generatorName === $name) {
                return $generatorFile;
            }
        }

        throw new \InvalidArgumentException(sprintf('Generator name "%s" does not exist', $name));
    }
}
