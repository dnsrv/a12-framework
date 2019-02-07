<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 20:52
 */

namespace A12\Middlewares;


use A12\Interfaces\IO\UserOutputInterface;
use A12\Interfaces\Middleware\MiddlewareInterface;
use A12\Interfaces\Request\RequestInterface;
use A12\Interfaces\Response\ResponseInterface;

class ForceFlagMiddleware implements MiddlewareInterface
{
    private $output;
    
    public function __construct(UserOutputInterface $output)
    {
        $this->output = $output;
    }
    
    public function __invoke(RequestInterface $request, $next) : ResponseInterface
    {
        $force = $request->cliArgs()->getOpt(RequestInterface::FLAG_FORCE_EXECUTING, false);
        
        if ($force) {
            $this->output->writeLine(
                '"Force" executing module ['. $request->getAttribute(RequestInterface::KEY_ID) . ']'
            );
        }
        
        $response = $next($request);
        
        /** @var ResponseInterface $response */
        $response->setAttribute(RequestInterface::FLAG_FORCE_EXECUTING, $force);
        
        return $response;
    }
}