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
namespace CrudGenerator\Generators\Parser;

use CrudGenerator\Utils\FileManager;
use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Context\WebContext;
use CrudGenerator\Context\CliContext;
use CrudGenerator\Generators\Parser\Lexical\DirectoriesParser;
use CrudGenerator\Generators\Parser\Lexical\FileParser;
use CrudGenerator\Generators\Parser\Lexical\TemplateVariableParser;
use CrudGenerator\Generators\Parser\Lexical\Cli\AskQuestionParser;
use CrudGenerator\Generators\Parser\Lexical\Web\QuestionParser;
use CrudGenerator\Generators\Parser\Lexical\Web\QuestionResponseParser;
use CrudGenerator\Generators\Parser\Lexical\Condition\DependencyCondition;
use CrudGenerator\Generators\Parser\Lexical\Condition\EnvironnementCondition;
use CrudGenerator\Generators\Questions\DirectoryQuestionFactory;

class ParserCollectionFactory
{
    /**
     * @param ContextInterface $context
     * @return ParserCollection
     */
    public static function getInstance(ContextInterface $context)
    {
        $fileManager           = new FileManager();
        $collection            = new ParserCollection();
        $environnemetCondition = new EnvironnementCondition($fileManager);
        $dependencyCondition   = new DependencyCondition();
        $directoryQuestion     = DirectoryQuestionFactory::getInstance($context);

        if ($context instanceof WebContext) {
            $collection->addPreParse(new QuestionResponseParser())
                       ->addPostParse(new QuestionParser($context, $directoryQuestion, $dependencyCondition));
        } elseif ($context instanceof CliContext) {
            $collection->addPreParse(
                new AskQuestionParser($context, $directoryQuestion)
            );
        } else {
            throw new \InvalidArgumentException("Context not allowed");
        }

        $collection->addPostParse(new TemplateVariableParser($fileManager, $environnemetCondition, $dependencyCondition))
                   ->addPostParse(new DirectoriesParser())
                   ->addPostParse(new FileParser($fileManager, $dependencyCondition, $environnemetCondition));

        return $collection;
    }
}
