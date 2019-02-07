<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 09.12.18
 * Time: 6:10
 */

namespace A12\Modules\Response;


use A12\Interfaces\Response\ResponseInterface;

class TestResponse implements ResponseInterface
{
    
    public function __construct($data)
    {
        parent::__construct($data);
    }
    
    public function hasAttribute($key): bool
    {
        // TODO: Implement hasAttribute() method.
    }
    
    public function getAttribute($key)
    {
        // TODO: Implement getAttribute() method.
    }
    
    public function getCode(): int
    {
        // TODO: Implement getCode() method.
    }
    
    public function setAttribute($key, $value): ResponseInterface
    {
        // TODO: Implement setAttribute() method.
    }
    
    public function setCode($code): ResponseInterface
    {
        // TODO: Implement setCode() method.
    }
    
    public function getContent(): array
    {
        // TODO: Implement getContent() method.
    }
}