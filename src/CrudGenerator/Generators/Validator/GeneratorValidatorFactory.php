<?php
/**
  * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Validator;

use JsonSchema\Uri\UriRetriever;
use JsonSchema\Validator;
use JsonSchema\Constraints\Constraint;

/**
 *
 * @author St  phane Demonchaux
 */
class GeneratorValidatorFactory
{
    /**
     * @return \CrudGenerator\Generators\Validator\GeneratorValidator
     */
    public static function getInstance()
    {
        $retriever = new UriRetriever();
        $schema    = $retriever->retrieve('file://' . realpath(__DIR__ . '/ressources/generator-schema.json'));

        return new GeneratorValidator($schema, new Validator(Constraint::CHECK_MODE_TYPE_CAST));
    }
}
