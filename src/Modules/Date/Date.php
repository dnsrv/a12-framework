<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 17:25
 */

namespace A12\Modules\Date;


use A12\Modules\Config\CFG;

final class Date
{
    public static function getDateTimeString($format = null) : string
    {
        return date($format ?? "\Dymd\THi");
    }
    
    public static function getTimestamp()
    {
        return time();
    }
}