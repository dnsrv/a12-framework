<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 17:05
 */

namespace A12\Modules\IO\Console;


use A12\Interfaces\IO\OutputStyleInterface;

class ConsoleStyle implements OutputStyleInterface
{
    private $foregroundColors = array();
    private $backgroundColors = array();
    
    public function __construct()
    {
        $this->foregroundColors[OutputStyleInterface::BLACK] = '0;30';
        $this->foregroundColors[OutputStyleInterface::DARK_GRAY] = '1;30';
        $this->foregroundColors[OutputStyleInterface::BLUE] = '0;34';
        $this->foregroundColors[OutputStyleInterface::LIGHT_BLUE] = '1;34';
        $this->foregroundColors[OutputStyleInterface::GREEN] = '0;32';
        $this->foregroundColors[OutputStyleInterface::LIGHT_GREEN] = '1;32';
        $this->foregroundColors[OutputStyleInterface::CYAN] = '0;36';
        $this->foregroundColors[OutputStyleInterface::LIGHT_CYAN] = '1;36';
        $this->foregroundColors[OutputStyleInterface::RED] = '0;31';
        $this->foregroundColors[OutputStyleInterface::LIGHT_RED] = '1;31';
        $this->foregroundColors[OutputStyleInterface::PURPLE] = '0;35';
        $this->foregroundColors[OutputStyleInterface::LIGHT_PURPLE] = '1;35';
        $this->foregroundColors[OutputStyleInterface::BROWN] = '0;33';
        $this->foregroundColors[OutputStyleInterface::YELLOW] = '1;33';
        $this->foregroundColors[OutputStyleInterface::LIGHT_GRAY] = '0;37';
        $this->foregroundColors[OutputStyleInterface::WHITE] = '1;37';
        
        $this->backgroundColors[OutputStyleInterface::BLACK] = '40';
        $this->backgroundColors[OutputStyleInterface::RED] = '41';
        $this->backgroundColors[OutputStyleInterface::GREEN] = '42';
        $this->backgroundColors[OutputStyleInterface::YELLOW] = '43';
        $this->backgroundColors[OutputStyleInterface::BLUE] = '44';
        $this->backgroundColors[OutputStyleInterface::MAGENTA] = '45';
        $this->backgroundColors[OutputStyleInterface::CYAN] = '46';
        $this->backgroundColors[OutputStyleInterface::LIGHT_GRAY] = '47';
    }
    
    public function setOutputColor(
        string $string,
        string $foregroundColor = null,
        string $backgroundColor = null): string
    {
        $colored_string = "";
        
        if ($foregroundColor !== OutputStyleInterface::DEFAULT) {
            if (isset($this->foregroundColors[$foregroundColor])) {
                $colored_string .= "\033[" . $this->foregroundColors[$foregroundColor] . "m";
            }
        }
    
        if ($foregroundColor !== OutputStyleInterface::DEFAULT) {
            if (isset($this->backgroundColors[$backgroundColor])) {
                $colored_string .= "\033[" . $this->backgroundColors[$backgroundColor] . "m";
            }
        }
        
        $colored_string .= $string . "\033[0m";
        
        return $colored_string;
    }
    
    public function getForegroundColors()
    {
        return array_keys($this->foregroundColors);
    }
    
    public function getBackgroundColors()
    {
        return array_keys($this->backgroundColors);
    }
}