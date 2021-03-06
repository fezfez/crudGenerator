<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Utils;

/**
 * Transtyper factory
 */
class TranstyperFactory
{
    /**
     * @var Transtyper
     */
    private static $instance = null;

    /**
     * @return \CrudGenerator\Utils\Transtyper
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Transtyper();
        }

        return self::$instance;
    }
}
