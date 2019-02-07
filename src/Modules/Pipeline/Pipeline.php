<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 07.12.18
 * Time: 15:40
 */

namespace A12\Modules\Pipeline;


use A12\Interfaces\Request\RequestInterface;
use A12\Interfaces\Response\ResponseInterface;

class Pipeline
{
    private $queue;
    
    public function __construct()
    {
        $this->queue = new \SplQueue();
    }
    
    public function __invoke(RequestInterface $request, callable $next) : ResponseInterface
    {
        $delegate = new Next(clone $this->queue, $next);
        return $delegate($request);
    }
    
    public function pipe(callable $middleware): void
    {
        $this->queue->enqueue($middleware);
    }
}