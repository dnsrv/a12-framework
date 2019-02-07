<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 22:09
 */

namespace A12\Modules\Request;


use A12\Interfaces\Request\RequestInterface;

abstract class RequestFactory
{
    public static function get($data = []): RequestInterface
    {
        return new Request(self::parseData($data));
    }
    
    public static function getTestRequest(): RequestInterface
    {
        // TODO: Implement getTestRequest() method.
    }
    
    private static function parseData($data)
    {
        if (is_string($data)) {
            $data = explode(RequestInterface::ARG_PAIR_DELIMITER, $data);
        }
    
        $attributes = [];
    
        foreach ($data as $item) {
        
            $parts = explode(RequestInterface::ARG_VALUE_DELIMITER, $item);
            
            if (count($parts) == 2) {
                $attributes[$parts[0]] = $parts[1];
            } else {
                $attributes[$item] = true;
            }
        }
        
        return $attributes;
    }
}