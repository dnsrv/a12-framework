<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 10.12.18
 * Time: 4:05
 */

namespace A12\Modules\Request;


use A12\Interfaces\Request\RequestInterface;

class requestWrapper
{
    /**
     * @var RequestInterface
     */
    private $request;
    
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    
    public function getOpt($key, $default = null)
    {
    
    }
    
    // get cliArgs from requests array
    // etc
    
    // isSilentMode
    // isForceMode
}