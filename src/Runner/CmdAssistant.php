<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 16:16
 */

namespace A12\Runner;


use A12\Interfaces\IO\OutputStyleInterface;
use A12\Interfaces\IO\UserOutputInterface;
use A12\Modules\IO\Console\ConsoleStyle;

class CmdAssistant
{
    private $outputInterface;
    private $colorizer;
    
    public function __construct(UserOutputInterface $outputInterface)
    {
        $this->outputInterface = $outputInterface;
        $this->colorizer = new ConsoleStyle();
    }
    
    public function exec(string $command, &$exitCode = null)
    {
        $out = null;
        
        $this->outputInterface->writeLine(
            "Executing command [{$command }]",
            OutputStyleInterface::COMMAND_OUTPUT
        );
        
        exec($command ,$out, $exitCode);
        $this->output($out, OutputStyleInterface::COMMAND_OUTPUT);
        return $out;
    }
    
    private function output(&$out, $color = OutputStyleInterface::COMMAND_OUTPUT)
    {
        $text = null;
        
        if (is_array($out)) {
            $text = $this->resolveArray($out);
        }
    
        if (is_null($text)) {
            return;
        }
        
        $this->outputInterface->writeLine($text, $color);
    }
    
    private function resolveArray($arr)
    {
        if (empty($arr)) {
            return null;
        }
        
        $out = '';
        
        if ($this->isAssocArray($arr)) {
            foreach ($arr as $k=>$v) {
                $out .= $k . '=>' . $v . PHP_EOL;
            }
        } else {
            $out = implode(PHP_EOL, $arr);
        }
        
        return $out;
    }
    
    private function isAssocArray(array $arr)
    {
        if ([] === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}