<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 0:07
 */

namespace A12\Modules\IO\Console;


use A12\Interfaces\IO\Console\ConsoleInputInterface;

class ConsoleInput implements ConsoleInputInterface
{
    private $defaultMessage;
    private $prefix;
    
    private $userInput;
    private $userOutput;
    
    private $lastInputValue;
    /**
     * @var bool
     */
    private $doInput;
    
    public function __construct($doInput = true, $defaultMessage = 'Enter value', $prefix = null)
    {
        $this->doInput = $doInput;
        if (!$doInput) {
            return null;
        }
        $this->userOutput = fopen("PHP://stderr", "w");
        $this->userInput = fopen("PHP://stdin", "r");
        $this->prefix = $prefix ?? "I:: ";
        $this->defaultMessage = $defaultMessage;
    }
    
    public function __destruct()
    {
        if (!$this->doInput) {
            return null;
        }
        fclose($this->userInput);
        fclose($this->userOutput);
    }
    
    public function readLine($message = null, $row = false)
    {
        if (!$this->doInput) {
            return null;
        }
        fputs(
            $this->userOutput,
            $this->prefix .
            ($message ?? $this->defaultMessage) . ': '
        );
        
        $input = fgets($this->userInput);
        
        if ($input == false) {
            return null;
        }
    
        if ($row) {
            return $this->lastInputValue = $input;
        }
        
        return $this->lastInputValue = addslashes(trim($input));
    }
    
    public function readChar($message = null)
    {
        if (!$this->doInput) {
            return null;
        }
        $promt = $this->prefix . ($message ?? $this->defaultMessage) . ': ';
        readline_callback_handler_install($promt, function () {});
        $this->lastInputValue = stream_get_contents($this->userInput, 1);
        
        readline_callback_handler_remove();
    
        fputs(
            $this->userOutput,
            $this->lastInputValue . PHP_EOL
        );
    
        return $this->lastInputValue;
    }
    
    public function getLastInputValue()
    {
        return $this->lastInputValue;
    }
}