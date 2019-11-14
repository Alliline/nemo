<?php
/**
 * Параметры, языковой пакет скрипта
 *
 * @author Alliline <inline-webb@yandex.ru>
 */

namespace ExportBase;

class Engine
{
    public static $config = [];
    public static $lang = [];

    /**
     * Загрузка конфигурации и языкового пакета
     */
    public static function load()
    {
        self::$config = include_once ROOT_DIR . '/data/config.php';
        self::$lang = include_once ROOT_DIR . '/data/lang.lng';
    }
}