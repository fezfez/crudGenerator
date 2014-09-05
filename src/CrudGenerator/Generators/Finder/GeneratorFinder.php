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
namespace CrudGenerator\Generators\Finder;

use CrudGenerator\Utils\FileManager;
use CrudGenerator\Utils\Yaml;
use CrudGenerator\MetaData\DataObject\MetaDataInterface;
use CrudGenerator\Generators\GeneratorCompatibilityChecker;

/**
 * Find all generator allow in project
 *
 * @author Stéphane Demonchaux
 */
class GeneratorFinder implements GeneratorFinderInterface
{
    /**
     * @var FileManager File manager
     */
    private $fileManager = null;
    /**
     * @var Yaml Yaml parser
     */
    private $yaml = null;
    /**
     * @var GeneratorCompatibilityChecker
     */
    private $compatibilityChecker = null;
    /**
     * @var array
     */
    private static $allClasses = null;

    /**
     * Find all generator allow in project
     *
     * @param FileManager $fileManager
     * @param Yaml $yaml
     */
    public function __construct(FileManager $fileManager, Yaml $yaml, GeneratorCompatibilityChecker $compatibilityChecker)
    {
        $this->fileManager          = $fileManager;
        $this->yaml                 = $yaml;
        $this->compatibilityChecker = $compatibilityChecker;
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
            $iterator = new \RegexIterator(
                new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator(getcwd(), \FilesystemIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::LEAVES_ONLY
                ),
                '/^.+\.generator\.json$/i',
                \RecursiveRegexIterator::GET_MATCH
            );

            foreach ($iterator as $file) {
                $process              = json_decode(file_get_contents($file[0]), true);
                if ($metadata !== null) {
                    try {
                        $this->compatibilityChecker->metadataAllowedInGenerator($metadata, $process);
                        $generators[$file[0]] = $process['name'];
                    } catch (\InvalidArgumentException $e) {
                        // Metdata not allowed with this generator
                    }
                } else {
                    $generators[$file[0]] = $process['name'];
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
