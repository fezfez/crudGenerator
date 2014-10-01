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
namespace CrudGenerator\MetaData\Driver\Web;

use CrudGenerator\MetaData\Config\ConfigException;
use CrudGenerator\Utils\FileManager;
use CrudGenerator\MetaData\Driver\DriverInterface;
use CrudGenerator\MetaData\Driver\DriverConfig;

/**
 * Json configuration for Json Metadata adapter
 *
 * @author Stéphane Demonchaux
 */
class WebDriver implements DriverInterface
{
    /**
     * @var FileManager
     */
    private $fileManager = null;

    /**
     * Constructor.
     * @param FileManager $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * @param ConnectorConfig $config
     * @throws ConfigException
     */
    public function getConnection(DriverConfig $config)
    {
        try {
            return $this->fileManager->fileGetContent($config->getResponse('configUrl'));
        } catch (\RuntimeException $e) {
            throw new ConfigException($e->getMessage());
        }
    }

    /* (non-PHPdoc)
     * @see \CrudGenerator\MetaData\Sources\MetaDataConnectorInterface::getDefinition()
     */
    public function getUniqueName(DriverConfig $config)
    {
        return $config->getResponse('configUrl');
    }
}