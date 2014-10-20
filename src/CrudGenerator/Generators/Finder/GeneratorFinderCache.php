<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Finder;

use CrudGenerator\MetaData\DataObject\MetaDataInterface;

/**
 * Find all generator allow in project
 *
 * @author Stéphane Demonchaux
 */
class GeneratorFinderCache implements GeneratorFinderInterface
{
    /**
     * @var GeneratorFinder
     */
    private $generatorFinder = null;
    /**
     * @var array
     */
    private $directories = null;
    /**
     * @var boolean
     */
    private $noCache = null;

    /**
     * @param GeneratorFinder $generatorFinder
     * @param array $directories
     * @param boolean $noCache
     */
    public function __construct(GeneratorFinder $generatorFinder, array $directories, $noCache = false)
    {
        $this->generatorFinder = $generatorFinder;
        $this->directories     = $directories;
        $this->noCache         = $noCache;
    }

    /**
     * Find all adapters allow in project
     *
     * @return array
     */
    public function getAllClasses(MetaDataInterface $metadata = null)
    {
        $cacheFilename  = $this->directories['Cache'] . DIRECTORY_SEPARATOR;
        $cacheFilename .= md5('genrator_getAllClasses' . ($metadata !== null) ? get_class($metadata) : '');

        if (is_file($cacheFilename) === true && $this->noCache === false) {
            $data = unserialize(file_get_contents($cacheFilename));
        } else {
            $data = $this->generatorFinder->getAllClasses($metadata);
            file_put_contents($cacheFilename, serialize($data));
        }

        return $data;
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
