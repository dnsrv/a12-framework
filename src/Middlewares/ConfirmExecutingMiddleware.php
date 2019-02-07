<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 21:33
 */

namespace A12\Middlewares;


use A12\Exceptions\ShutDownException;
use A12\Interfaces\IO\ConfirmInterface;
use A12\Interfaces\IO\UserOutputInterface;
use A12\Interfaces\Middleware\MiddlewareInterface;
use A12\Interfaces\Request\RequestInterface;
use A12\Interfaces\Response\ResponseInterface;

class ConfirmExecutingMiddleware implements MiddlewareInterface
{
    private $confirm;
    private $output;
    
    public function __construct(
        UserOutputInterface $output,
        ConfirmInterface $confirmInput
    )
    {
        $this->confirm = $confirmInput;
        $this->output = $output;
    }
    
    public function __invoke(RequestInterface $request, $next) : ResponseInterface
    {
        if ($request->getOpt(RequestInterface::FLAG_SILENT_EXECUTING)) {
            return $next($request);
        }
        
        if (!$request->getOpt(RequestInterface::FLAG_CONFIRM_EXECUTING)) {
            return $next($request);
        }
        
        $input = $this->confirm->read(
            "Execute this module? [{$request->getAttribute(RequestInterface::KEY_ID)}] ",
            1
        );
    
        if ($input === false) {
            throw new ShutDownException('Executing aborted.');
        }
        
        /** @var ResponseInterface $response */
        $response = $next($request);
        $response->setAttribute('confirmedExecution', true);
    
        return $response;
    }
}