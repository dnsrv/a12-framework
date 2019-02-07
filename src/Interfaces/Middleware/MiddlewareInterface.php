<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 20:52
 */

namespace A12\Interfaces\Middleware;


use A12\Interfaces\Request\RequestInterface;
use A12\Interfaces\Response\ResponseInterface;

interface MiddlewareInterface
{
    public function __invoke(RequestInterface $request, $next) : ResponseInterface;
}