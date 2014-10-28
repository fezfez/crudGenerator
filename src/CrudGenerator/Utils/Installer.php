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

use CrudGenerator\History\HistoryManager;
use CrudGenerator\MetaData\Config\MetaDataConfigDAO;

/**
 * Installer
 *
 * @author Stéphane Demonchaux
 */
class Installer
{
    const BASE_PATH = 'data/crudGenerator/';
    /**
     * @var string
     */
    const CACHE_PATH = 'cache/';

    /**
     * @return array
     */
    public static function getDirectories()
    {
        $directoriestoCreate = array(
            'Cache'   => self::BASE_PATH . self::CACHE_PATH,
            'History' => self::BASE_PATH . HistoryManager::HISTORY_PATH,
            'Config'  => self::BASE_PATH . MetaDataConfigDAO::SOURCE_PATH
        );

        return $directoriestoCreate;
    }

    /**
     * @throws \RuntimeException
     */
    public static function install()
    {
        $directoriestoCreate = self::getDirectories();

        foreach ($directoriestoCreate as $directoryName => $directoryPath) {
            if (is_dir($directoryPath) !== true) {
                mkdir($directoryPath, 0777, true);
            }
            if (is_writable($directoryPath) !== true) {
                throw new \RuntimeException(
                    sprintf(
                        '%s directory "%s" is not writable',
                        $directoryName,
                        $directoryPath
                    )
                );
            }
        }
    }
}
