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
namespace CrudGenerator\Generators\Questions;

use CrudGenerator\MetaData\Config\MetaDataConfigReaderFactory;
use CrudGenerator\MetaData\Config\MetaDataConfigReaderFormFactory;
use CrudGenerator\MetaData\MetaDataSourceFactory;
use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Context\CliContext;
use CrudGenerator\Context\WebContext;

class MetaDataQuestionFactory
{
    /**
     * @param ContextInterface $context
     * @throws \InvalidArgumentException
     * @return \CrudGenerator\Generators\Questions\Cli\MetaDataQuestion|\CrudGenerator\Generators\Questions\Web\MetaDataQuestion
     */
    public static function getInstance(ContextInterface $context)
    {
        $metadataSourceFactory = new MetaDataSourceFactory();

        if ($context instanceof CliContext) {
        	$metaDataConfigReader  = MetaDataConfigReaderFactory::getInstance($context->getOutput(), $context->getDialogHelper());
        	return new Cli\MetaDataQuestion($metaDataConfigReader, $metadataSourceFactory, $context->getOutput(), $context->getDialogHelper());
        } elseif ($context instanceof WebContext) {
        	$metaDataConfigReader = MetaDataConfigReaderFormFactory::getInstance($context->getApplication());
        	return new Web\MetaDataQuestion($metaDataConfigReader, $metadataSourceFactory);
        } else {
        	throw new \InvalidArgumentException('Invalid context given');
        }
    }
}