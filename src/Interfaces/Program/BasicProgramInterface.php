<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 4:08
 */

namespace A12\Interfaces\Program;


use A12\Interfaces\Middleware\MiddlewareInterface;
use A12\Interfaces\Response\ResponseInterface;

interface BasicProgramInterface
{
    /** @return ResponseInterface */
    public function main();
    
    /** @return MiddlewareInterface[] */
    public function middleware();
}