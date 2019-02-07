<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 0:00
 */

namespace A12\Modules\IO\Console;


use A12\Interfaces\IO\Console\ConsoleUserOutputInterface;
use A12\Interfaces\IO\OutputStyleInterface;

class ConsoleUserOutput implements ConsoleUserOutputInterface
{
    private $styleResolver;
    private $output;
    private $prefix;
    private $isPrefixed = false;
    private $lastOutput;
    /** @var bool */
    private $doOutput;
    
    public function __construct($doOutput = true, $prefix = null)
    {
        $this->doOutput = $doOutput;
        if (!$this->doOutput) {return null;}
    
        $this->output = fopen("PHP://stderr", "w");
        $this->prefix = $prefix ?? "O:: ";
    }
    
    public function __destruct()
    {
        if ($this->doOutput) {fclose($this->output);}
    }
    
    public function write($data, $fontColor = null)
    {
        if (!$this->doOutput) {return null;}
        
        $data = ($this->isPrefixed === false ? $this->prefix : '') .
            $this->getOutputStyleResolver()->setOutputColor($this->parseData($data), $fontColor);
        
        fputs($this->output, $data);
        $this->isPrefixed = true;
    }
    
    public function writeLine($data, $fontColor = null)
    {
        if (!$this->doOutput) {return null;}
        
        fputs(
            $this->output,
            $this->prefix . $this->getOutputStyleResolver()->setOutputColor(
                $this->parseData($data),
                $fontColor
            ) . PHP_EOL
        );
        $this->isPrefixed = false;
    }
    
    public function getLastOutputValue()
    {
        return $this->lastOutput;
    }
    
    public function getOutputStyleResolver(): OutputStyleInterface
    {
        if (is_null($this->styleResolver)) {
            $this->styleResolver = new ConsoleStyle();
        }
        return $this->styleResolver;
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    private function parseData($data)
    {
        if (is_array($data)) {
            $output = print_r($data, true);
        } else {
            $output = $data;
        }
        return $this->lastOutput = $output;
    }
}