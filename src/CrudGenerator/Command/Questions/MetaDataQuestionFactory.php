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
namespace CrudGenerator\Command\Questions;

use CrudGenerator\MetaData\Config\MetaDataConfigReaderFactory;
use CrudGenerator\MetaData\MetaDataSourceFactory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;

class MetaDataQuestionFactory
{
    /**
     * @param OutputInterface $output
     * @param DialogHelper $dialog
     * @return \CrudGenerator\Command\Questions\MetaDataQuestion
     */
    public static function getInstance(DialogHelper $dialog, OutputInterface $output)
    {
        $metaDataConfigReader  = MetaDataConfigReaderFactory::getInstance($output, $dialog);
        $metadataSourceFactory = new MetaDataSourceFactory();

        return new MetaDataQuestion($metaDataConfigReader, $metadataSourceFactory, $output, $dialog);
    }
}
