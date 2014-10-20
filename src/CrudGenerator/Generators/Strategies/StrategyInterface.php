<?php
/**
  * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Strategies;

/**
 * Base code generator, extends it and implement doGenerate method
 * to make you own Generator
 *
 * @author St  phane Demonchaux
 */
interface StrategyInterface
{
    /**
     * @param array $datas
     * @param string $skeletonDir
     * @param string $pathTemplate
     * @param string $pathTo
     * @return string|null
     */
    public function generateFile(array $datas, $skeletonDir, $pathTemplate, $pathTo);
}
