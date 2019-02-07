<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 07.12.18
 * Time: 23:02
 */

namespace A12\Interfaces\FileSystem;


interface FileWrapperInterface
{
    public function getFilename() : string;
    public function getFilePath() : string;
    public function getParentDir() : string;
    // ------- ------- ------- ------- ------- ------- -------
    public function isFileExists() : bool;
    public function isFile() : bool;
    public function isDir() : bool;
    // ------- ------- ------- ------- ------- ------- -------
    public function isWritable() : bool;
}