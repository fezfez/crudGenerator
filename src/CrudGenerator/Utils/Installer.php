<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) St  phane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CrudGenerator\Utils;

/**
 * Installer
 *
 * @author St  phane Demonchaux
 */
class Installer
{
    /**
     * @var string
     */
    const CACHE_PATH = 'data/crudGenerator/cache/';

    /**
     * @return array
     */
    public static function getDirectories()
    {
        $directoriestoCreate = array(
            'Cache'   => self::CACHE_PATH,
            'History' => \CrudGenerator\History\HistoryManager::HISTORY_PATH,
            'Config'  => \CrudGenerator\MetaData\Config\MetaDataConfigDAO::PATH
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
