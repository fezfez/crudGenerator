<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Parser\Lexical\Condition;

use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Utils\PhpStringParser;

class ConditionValidator
{
    /**
     * @var array
     */
    private $conditionCollection = null;

    /**
     * @param array $conditionCollection
     */
    public function __construct(array $conditionCollection)
    {
        $this->conditionCollection = $conditionCollection;
    }

    /* (non-PHPdoc)
     * @see \CrudGenerator\Generators\Parser\Lexical\ParserInterface::evaluate()
     */
    public function isValid(
        array $node,
        GeneratorDataObject $generator,
        PhpStringParser $phpStringParser
    ) {
        $isValid = true;

        if (isset($node[ConditionInterface::CONDITION]) === true) {
            $condition = $node[ConditionInterface::CONDITION];

            foreach ($this->conditionCollection as $conditionChecker) {
                if (isset($condition[$conditionChecker::NAME]) === true) {
                    if ($conditionChecker->isValid(
                        $condition[$conditionChecker::NAME],
                        $generator,
                        $phpStringParser
                    ) === false) {
                        $isValid = false;
                    }
                }
            }
        }

        return $isValid;
    }
}
