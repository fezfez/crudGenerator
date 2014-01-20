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
namespace CrudGenerator\Generators;

use CrudGenerator\DataObject;

/**
 * Find all generator allow in project
 *
 * @author Stéphane Demonchaux
 */

class GeneratorDataObject implements \JsonSerializable
{
    /**
     * @var DataObject
     */
    private $dto = null;
    /**
     * @var string
     */
    private $name = null;
    /**
     * @var string
     */
    private $path = null;
    /**
     * @var array
     */
    private $questions = array();
    /**
     * @var array
     */
    private $files = array();
    /**
     * @var array
     */
    private $directories = array();
    /**
     * @var array
     */
    private $templateVariable = array();

    /**
     * @param DataObject $name
     * @return \CrudGenerator\Generators\Generator
     */
    public function setDTO(DataObject $value)
    {
        $this->dto = $value;
        return $this;
    }
    /**
     * @param string $name
     * @return \CrudGenerator\Generators\Generator
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @param string $name
     * @return \CrudGenerator\Generators\Generator
     */
    public function setPath($name)
    {
        $this->path = $name;
        return $this;
    }
    /**
     * @param string $name
     * @return \CrudGenerator\Generators\Generator
     */
    public function addQuestion(array $question)
    {
        $this->questions[] = $question;
        return $this;
    }
    /**
     * @param string $name
     * @return \CrudGenerator\Generators\Generator
     */
    public function addFile($skeletonPath, $name, $value)
    {
        $this->files[$value] = array(
                'skeletonPath' => $skeletonPath,
                'fileName' => $value,
                'name' => $name
        );
        return $this;
    }
    /**
     * @param string $name
     * @return \CrudGenerator\Generators\Generator
     */
    public function addDirectories($name, $value)
    {
        $this->directories[$name] = $value;
        return $this;
    }
    /**
     * @param string $name
     * @return \CrudGenerator\Generators\Generator
     */
    public function addTemplateVariable($name, $value)
    {
        $this->templateVariable[$name] = $value;
        return $this;
    }
    /**
     * @return DataObject
     */
    public function getDTO()
    {
        return $this->dto;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * @return array
     */
    public function getQuestion()
    {
        return $this->questions;
    }
    /**
     * @return array
     */
    public function getFiles()
    {
    	sort($this->files);
        return $this->files;
    }
    /**
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }
    /**
     * @return array
     */
    public function getTemplateVariables()
    {
        return $this->templateVariable;
    }

    public function jsonSerialize()
    {
        return array(
            'templateVariable' => $this->templateVariable,
            'files' => $this->getFiles(),
            'directories' => $this->directories,
            'name' => $this->name,
            'questions' => $this->questions
        );
    }
}