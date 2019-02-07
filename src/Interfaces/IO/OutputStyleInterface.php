<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 21:00
 */

namespace A12\Interfaces\IO;


interface OutputStyleInterface
{
    public const WHITE              = 'white';
    public const LIGHT_RED          = 'light_red';
    public const BLUE               = 'blue';
    public const LIGHT_GREEN        = 'light_green';
    public const PURPLE             = 'purple';
    public const GREEN              = 'green';
    public const RED                = 'red';
    public const LIGHT_GRAY         = 'light_gray';
    public const LIGHT_BLUE         = 'light_blue';
    public const LIGHT_PURPLE       = 'light_purple';
    public const BLACK              = 'black';
    public const LIGHT_CYAN         = 'light_cyan';
    public const MAGENTA            = 'magenta';
    public const YELLOW             = 'yellow';
    public const DARK_GRAY          = 'dark_gray';
    public const CYAN               = 'cyan';
    public const DEFAULT            = 'default';
    public const BROWN              = 'brown';
    
    public const ERROR              = OutputStyleInterface::LIGHT_RED;
    public const DANGER             = OutputStyleInterface::LIGHT_PURPLE;
    public const SUCCESS            = OutputStyleInterface::LIGHT_GREEN;
    
    public const USER_OUTPUT        = OutputStyleInterface::DEFAULT;
    public const USER_INPUT         = OutputStyleInterface::DEFAULT;
    
    public const PROGRAM_OUTPUT     = OutputStyleInterface::BLUE;
    public const COMMAND_OUTPUT     = OutputStyleInterface::YELLOW;
    public const EXECUTOR_OUTPUT    = OutputStyleInterface::DEFAULT;
    
    public function setOutputColor(
        string $text,
        string $foregroundColor = null,
        string $backgroundColor = null
    ) : string;
}