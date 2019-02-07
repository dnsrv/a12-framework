<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 0:12
 */

namespace A12\Modules\IO\Console;


use A12\Interfaces\IO\Console\ConsoleConfirmInterface;

class ConsoleConfirm implements ConsoleConfirmInterface
{
    private $defaultMessage;
    private $prefix;
    private $userOutput;
    private $userInput;
    private $lastInputValue;
    /** @var bool */
    private $doOutput;
    
    public function __construct($doOutput = false, $defaultMessage = 'Confirmation needed', $prefix = null)
    {
        $this->doOutput = $doOutput;
        if (!$doOutput) {
            return null;
        }
    
        $this->userOutput = fopen("PHP://stderr", "w");
        $this->userInput = fopen("PHP://stdin", "r");
    
        $this->prefix = $prefix ?? "C:: ";
        $this->defaultMessage = $defaultMessage;
    }
    
    public function __destruct()
    {
        if (!$this->doOutput) {
            return null;
        }
        fclose($this->userInput);
        fclose($this->userOutput);
    }
    
    /**
     * @param null $message
     * @param int $maxLength
     * @return bool
     */
    public function read($message = null, $maxLength = 0) : bool
    {
        if (!$this->doOutput) {
            return true;
        }
    
        $promt = $this->prefix . ($message ?? $this->defaultMessage) . ' (Y/N)[y]: ';
        
        if ($maxLength > 0) {
            $input = $this->readChar($promt, $maxLength);
        } else {
            $input = $this->readLine($promt);
        }
        
        return $this->isConfirmed($input);
    }
    
    private function readLine($message = null)
    {
        fputs($this->userOutput, $message);
        
        if (($this->lastInputValue = fgets($this->userInput)) == false) {
            return null;
        }
        
        fputs($this->userOutput, $this->lastInputValue);
        return $this->lastInputValue;
    }
    
    private function readChar($message = null, $maxLength = 1)
    {
        readline_callback_handler_install($message, function () {});
        $this->lastInputValue = stream_get_contents($this->userInput, $maxLength);
        
        if (preg_match('/[0-9a-zA-Z]/', $this->lastInputValue)) {
            fputs($this->userOutput, $this->lastInputValue);
        } else {
            fputs($this->userOutput, $this->isConfirmed($this->lastInputValue) ? '+' : '-');
        }
        
        fputs($this->userOutput, PHP_EOL);
        
        readline_callback_handler_remove();
        
        return $this->lastInputValue;
    }
    
    private function isConfirmed($input) : bool
    {
        return !in_array($input, $this->getCancelCommandsArray());
    }
    
    private function getCancelCommandsArray() : array
    {
        return ['0', '-', 'n', 'no', 'н', 'нет'];
    }
    
}