<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 2:28
 */

namespace A12\Middlewares;


use A12\Interfaces\IO\UserOutputInterface;
use A12\Interfaces\Middleware\MiddlewareInterface;
use A12\Interfaces\Request\RequestInterface;
use A12\Interfaces\Response\ResponseInterface;

class DelayFlagMiddleware implements MiddlewareInterface
{
    public const FLAG_DELAY = 'delay';
    private $output;
    
    public function __construct(UserOutputInterface $output)
    {
        $this->output = $output;
    }
    
    public function __invoke(RequestInterface $request, $next) : ResponseInterface
    {
        if ($request->getArg(static::FLAG_DELAY, false)) {
            $sleep = (int) $request->getAttribute(static::FLAG_DELAY);
            if ($sleep >= 0) {
                $this->output->writeLine(
                    "Delay module [{$request->getAttribute(RequestInterface::KEY_ID)}] - {$sleep} sec"
                );
                
                sleep($sleep);
            }
        }
        
        return $next($request);
    }
}