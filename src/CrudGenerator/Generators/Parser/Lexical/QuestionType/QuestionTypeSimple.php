<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Parser\Lexical\QuestionType;

use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Utils\PhpStringParser;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Generators\Parser\Lexical\QuestionTypeEnum;
use CrudGenerator\Context\SimpleQuestion;

class QuestionTypeSimple implements QuestionTypeInterface
{
    /**
     * @var ContextInterface
     */
    private $context = null;

    /**
     * @param ContextInterface $context
     */
    public function __construct(ContextInterface $context)
    {
        $this->context = $context;
    }

    /* (non-PHPdoc)
     * @see \CrudGenerator\Generators\Parser\Lexical\QuestionType\QuestionTypeInterface::evaluateQuestion()
     */
    public function evaluateQuestion(
        array $questionRaw,
        PhpStringParser $parser,
        GeneratorDataObject $generator
    ) {
        $question = new SimpleQuestion($questionRaw['text'], 'set' . ucfirst($questionRaw['dtoAttribute']));
        $question->setDefaultResponse(
            (isset($questionRaw['defaultResponse']) === true) ? $parser->parse($questionRaw['defaultResponse']) : null
        );
        $question->setRequired($questionRaw['required']);
        $question->setHelpMessage($questionRaw['helpMessage']);
        $question->setResponseType($questionRaw['responseType']);

        $response = $this->context->ask($question);

        if ($response !== null) {
            $questionName = $question['setter'];

            $generator->getDto()->$questionName($response);
        }

        return $generator;
    }

    /* (non-PHPdoc)
     * @see \CrudGenerator\Generators\Parser\Lexical\QuestionType\QuestionTypeInterface::getType()
     */
    public function getType()
    {
        return QuestionTypeEnum::SIMPLE;
    }

    /* (non-PHPdoc)
     * @see \CrudGenerator\Generators\Parser\Lexical\QuestionType\QuestionTypeInterface::isIterable()
     */
    public function isIterable(array $question)
    {
        return false;
    }
}
