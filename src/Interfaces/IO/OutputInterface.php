<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 08.12.18
 * Time: 19:00
 */

namespace A12\Interfaces\IO;


interface OutputInterface
{
    public function write($data, $fontColor = null);
    public function writeLine($data, $fontColor = null);
    //public function clear();
    // ------- ------- ------- ------- ------- ------- -------
    public function getLastOutputValue();
    public function getOutputStyleResolver() : OutputStyleInterface;
}