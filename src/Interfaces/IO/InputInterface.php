<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 16:42
 */

namespace A12\Interfaces\IO;


interface InputInterface
{
    public function readLine($message = null);
    public function readChar($message = null);
    public function getLastInputValue();
}