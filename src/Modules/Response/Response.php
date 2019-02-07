<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 13:04
 */

namespace A12\Modules\Response;


use A12\Interfaces\Response\ResponseInterface;

class Response implements ResponseInterface
{
    private $data = [];
    private $code;
    
    public function __construct($data, int $code = 0)
    {
        $this->data = $data;
        $this->code = $code;
    }
    
    public function hasAttribute($key): bool
    {
        return array_key_exists($key, $this->data);
    }
    
    public function getAttribute($key)
    {
        return $this->data[$key] ?? null;
    }
    
    public function setAttribute($key, $value) : ResponseInterface
    {
        $this->data[$key] = $value;
        return $this;
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function getCode(): int
    {
        return $this->code;
    }
    
    public function setCode($code) : ResponseInterface
    {
        $this->code = $code;
        return $this;
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function getContent(): array
    {
        return $this->data;
    }
}