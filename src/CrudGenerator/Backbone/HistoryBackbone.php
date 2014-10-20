<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Backbone;

use CrudGenerator\Generators\Questions\History\HistoryQuestion;
use CrudGenerator\History\EmptyHistoryException;
use CrudGenerator\Context\ContextInterface;

class HistoryBackbone
{
    /**
     * @var HistoryQuestion
     */
    private $historyQuestion = null;
    /**
     * @var ContextInterface
     */
    private $context = null;

    /**
     * @param HistoryQuestion $historyQuestion
     * @param ContextInterface $context
     */
    public function __construct(HistoryQuestion $historyQuestion, ContextInterface $context)
    {
        $this->historyQuestion = $historyQuestion;
        $this->context         = $context;
    }

    public function run()
    {
        try {
            $this->context->publishGenerator($this->historyQuestion->ask());
        } catch (EmptyHistoryException $e) {
            $this->context->log("Generation history empty", "history_empty");
        }
    }
}
