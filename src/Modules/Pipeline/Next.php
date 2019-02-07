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

class Next
{
    /**
     * @var \SplQueue
     */
    private $queue;
    /**
     * @var callable
     */
    private $default;
    
    public function __construct(\SplQueue $queue, callable $default)
    {
    
        $this->queue = $queue;
        $this->default = $default;
    }
    
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        if ($this->queue->isEmpty()) {
            return ($this->default)($request);
        }
        
        $current = $this->queue->dequeue();
        
        return $current($request, function (RequestInterface $request){
            return $this($request);
        });
    }
}