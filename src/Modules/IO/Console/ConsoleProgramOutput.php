<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 19:52
 */

namespace A12\Modules\IO\Console;


use A12\Interfaces\IO\Console\ConsoleProgramOutputInterface;
use A12\Interfaces\IO\OutputStyleInterface;

class ConsoleProgramOutput implements ConsoleProgramOutputInterface
{
    private $output;
    private $prefix;
    private $lastOutputValue;
    private $styleResolver;
    private $isPrefixed = false;
    private $doOutput;
    
    public function __construct($doOutput = true)
    {
        $this->doOutput = $doOutput;
        if (!$this->doOutput) {return null;}
    
        $this->output = fopen("PHP://stdout", "w");
        $this->prefix = "X:: ";
    }
    
    public function __destruct()
    {
        if (!$this->doOutput) {return null;}
    
        fclose($this->output);
    }
    
    public function write($data, $fontColor = null)
    {
        if (!$this->doOutput) {return null;}
    
        fputs(
            $this->output,
            ($this->isPrefixed === false ? $this->prefix : '')
            . $this->getOutputStyleResolver()->setOutputColor(
                $this->parseData($data),
                $fontColor
            )
        );
        $this->isPrefixed = true;
    }
    
    public function writeLine($data, $fontColor = OutputStyleInterface::PROGRAM_OUTPUT)
    {
        if (!$this->doOutput) {return null;}
    
        fputs(
            $this->output,
            $this->prefix
            . $this->getOutputStyleResolver()->setOutputColor(
                $this->parseData($data),
                $fontColor
            )
            . PHP_EOL
        );
        $this->isPrefixed = false;
    }
    
    public function getLastOutputValue()
    {
        return $this->lastOutputValue;
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
        return $this->lastOutputValue = $output;
    }
}