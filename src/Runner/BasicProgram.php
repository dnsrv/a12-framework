<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 4:08
 */

namespace A12\Runner;


use A12\Interfaces\Program\BasicProgramInterface;

abstract class BasicProgram implements BasicProgramInterface
{
    public function middleware()
    {
        return [];
    }
}