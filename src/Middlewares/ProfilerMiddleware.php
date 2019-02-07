<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 07.12.18
 * Time: 16:32
 */

namespace A12\Middlewares;


use A12\Interfaces\Middleware\MiddlewareInterface;
use A12\Interfaces\Request\RequestInterface;
use A12\Interfaces\Response\ResponseInterface;

class ProfilerMiddleware implements MiddlewareInterface
{
    
    public function __invoke(RequestInterface $request, $next): ResponseInterface
    {
        $start = microtime(true);
        
        /** @var ResponseInterface $response */
        $response = $next($request);
        
        $response->setAttribute('executingTime', (microtime(true) - $start));
        
        return $response;
    }
}