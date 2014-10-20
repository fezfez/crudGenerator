<?php
/**
 * This file is part of the Code Genrator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Backbone;

use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Generators\Questions\MetadataSource\MetadataSourceQuestion;
use CrudGenerator\MetaData\Config\MetaDataConfigDAO;
use CrudGenerator\MetaData\Config\ConfigException;
use CrudGenerator\Generators\ResponseExpectedException;

class CreateSourceBackbone
{
    /**
     * @var MetadataSourceQuestion
     */
    private $metadataSourceQuestion = null;
    /**
     * @var MetaDataConfigDAO
     */
    private $metadataConfigDAO = null;
    /**
     * @var ContextInterface
     */
    private $context = null;

    /**
     * Constructor.
     *
     * @param MetadataSourceQuestion $metadataSourceQuestion
     * @param MetaDataConfigDAO $metaDataConfigDAO
     * @param ContextInterface $context
     */
    public function __construct(
        MetadataSourceQuestion $metadataSourceQuestion,
        MetaDataConfigDAO $metaDataConfigDAO,
        ContextInterface $context
    ) {
        $this->metadataSourceQuestion = $metadataSourceQuestion;
        $this->metadataConfigDAO      = $metaDataConfigDAO;
        $this->context                = $context;
    }

    /**
     * @throws ResponseExpectedException
     */
    public function run()
    {
        $source = $this->metadataSourceQuestion->ask();
        try {
            $this->metadataConfigDAO->save($source);
            $this->context->log('New source created', 'valid');
        } catch (ConfigException $e) {
            $this->context->log($e->getMessage(), 'error');
            throw new ResponseExpectedException("Response expected");
        }
    }
}
