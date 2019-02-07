<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 0:38
 */

namespace A12\Modules\Request;


use Garden\Cli\Args;
use A12\Interfaces\Request\RequestInterface;

class Request implements RequestInterface
{
    private $data = [];
    private $cliArgs;
    
    public function __construct($data, Args $cliArgs)
    {
        $this->data = $data;
        $this->cliArgs = $cliArgs;
    }
    
    public function hasAttribute($key): bool
    {
        return array_key_exists($key, $this->data);
    }
    
    public function getAttribute($key)
    {
        return $this->data[$key] ?? null;
    }
    
    public function setAttribute($key, $value) : RequestInterface
    {
        $this->data[$key] = $value;
        return $this;
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function cliArgs() : Args
    {
        return $this->cliArgs;
    }
    
    public function getCommand()
    {
        return $this->cliArgs->getCommand();
    }
    
    public function getArg($index, $default = null)
    {
        return $this->cliArgs->getArg($index, $default);
    }
    
    public function getOpt($index, $default = null)
    {
        return $this->cliArgs->getOpt($index, $default);
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function isForceMode()
    {
        if ($this->isSilentMode()) {
            return true;
        }
        
        return (bool) $this->getOpt(RequestInterface::FLAG_FORCE_EXECUTING);
    }
    
    public function isSilentMode()
    {
        return (bool) $this->getOpt(RequestInterface::FLAG_SILENT_EXECUTING);
    }
    
    public function isVerboseMode()
    {
        if ($this->isSilentMode()) {
            return false;
        }
        
        return (bool) $this->getOpt(RequestInterface::FLAG_VERBOSE_EXECUTING);
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function dump(): array
    {
        return [
            'data' => $this->data,
            'cli' => $this->cliArgs,
        ];
    }
}