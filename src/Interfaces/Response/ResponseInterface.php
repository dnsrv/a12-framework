<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 13:07
 */

namespace A12\Interfaces\Response;


interface ResponseInterface
{
    public const K_BLOCK = '_block';
    public const K_ID = '_id';
    public const K_CODE = '_code';
    
    public function __construct($data);
    
    public function hasAttribute($key): bool;
    
    public function getAttribute($key);
    
    public function getCode() : int;
    
    public function setAttribute($key, $value) : ResponseInterface;
    
    public function setCode($code) : ResponseInterface;
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function getContent(): array;
}