<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\View;

use CrudGenerator\View\ViewRendererException;
use CrudGenerator\EnvironnementNotDefinedException;

/**
 * Template renderer
 *
 * @author St  phane Demonchaux <demonchaux.stephane@gmail.com>
 */
class ViewRenderer
{
    /**
     * @var array
     */
    private $helpers = null;

    /**
     * @param unknown_type $helpers
     */
    public function __construct(array $helpers)
    {
        $this->helpers = $helpers;
    }

    /**
     * Interprete the file
     *
     * @param string $path
     * @param string $templateName
     * @throws Exception
     * @return string
     */
    public function render($path, $templateName)
    {
        try {
            ob_start();
            include $path . $templateName;
            $content = ob_get_clean();
        } catch(EnvironnementNotDefinedException $e) {
            ob_end_clean();
            throw new ViewRendererException($e->getMessage());
        } catch (\Exception $ex) {
            ob_end_clean();
            throw new ViewRendererException(
                'In : "' . realpath($path . $templateName) . '" ' . $ex->getMessage() . ' Line ' . $ex->getLine()
            );
        }

        return $content;
    }

    /**
     * Interprete the file
     *
     * @param string $path
     * @throws Exception
     * @return string
     */
    public function renderFile($path)
    {
        try {
            ob_start();
            include $path;
            $content = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw new ViewRendererException(
                'In : "' . realpath($path) . '" ' . $ex->getMessage() . ' Line ' . $ex->getLine()
            );
        }

        return $content;
    }

    /**
     * @param string $name
     * @throws ViewRendererException
     */
    public function getHelper($name)
    {
        $name = $name . 'Factory';
        if (isset($this->helpers[$name]) === true) {
            $className = $this->helpers[$name];
            return $className::getInstance();
        } else {
            throw new ViewRendererException(
                'Helper ' . $name . ' does not exist'
            );
        }
    }
}
