<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Parser\Lexical;

use Garoevans\PhpEnum\Enum;

class QuestionTypeEnum extends Enum
{
    /**
     * @var string
     */
    const __default = self::SIMPLE;
    /**
     * @var string
     */
    const SIMPLE = 'simple';
    /**
     * @var string
     */
    const DIRECTORY = 'directory';
    /**
     * @var string
     */
    const COMPLEX = 'complex';
    /**
     * @var string
     */
    const ITERATOR = 'askCollection';
    /**
     * @var string
     */
    const ITERATOR_WITH_PREDEFINED_RESPONSE = 'askCollectionOverIterator';
}
