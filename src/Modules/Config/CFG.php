<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 0:29
 */

namespace A12\Modules\Config;


use A12\Exceptions\ModuleException;

final class CFG
{
    private static $vars;
    
    public static function get($key)
    {
        self::loadConfig();
        
        if (array_key_exists($key, static::$vars)) {
            return static::$vars[$key];
        }
    
        echo self::errorKeyNotFound($key);
        return null;
    }
    
    private static function loadConfig() : void
    {
        if (is_null(static::$vars)) {
            static::$vars = include(dirname(__DIR__, 2) . '/config/vars.php');
        }
    }
    
    private static function errorKeyNotFound($key) : string
    {
        return "Config key [{$key}] not found" . PHP_EOL;
    }
}