<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 20:36
 */

namespace A12\Interfaces\IO;


interface ConfirmInterface
{
    public function read($message = null, $maxLength = 0) : bool;
}