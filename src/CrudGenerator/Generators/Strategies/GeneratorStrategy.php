<?php
/**
  * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Generators\Strategies;

use CrudGenerator\View\View;

/**
 * Base code generator, extends it and implement doGenerate method
 * to make you own Generator
 *
 * @author Stéphane Demonchaux
 */
class GeneratorStrategy implements StrategyInterface
{
    /**
     * @var View View manager
     */
    private $view = null;

    /**
     * Base code generator
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /* (non-PHPdoc)
     * @see CrudGenerator\Generators\Strategies.StrategyInterface::generateFile()
     */
    public function generateFile(array $datas, $skeletonDir, $pathTemplate, $target)
    {
        return $this->view->render(
            $skeletonDir,
            $pathTemplate,
            $datas
        );
    }
}
