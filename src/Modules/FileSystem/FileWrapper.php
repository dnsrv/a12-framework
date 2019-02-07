<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 4:35
 */

namespace A12\Modules\FileSystem;


use A12\Interfaces\FileSystem\FileWrapperInterface;

class FileWrapper implements FileWrapperInterface
{
    private $filePath;
    private $fileDir;
    private $filename;
    
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
    
    public function getFilename() : string
    {
        return $this->filename = basename($this->filePath);
    }
    
    public function getFilePath() : string
    {
        return $this->getParentDir() . '/' . $this->getFilename();
    }
    
    public function getParentDir() : string
    {
        return $this->fileDir = dirname($this->filePath);
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function isFileExists() : bool
    {
        return file_exists($this->getFilePath());
    }
    
    public function isFile() : bool
    {
        return is_file($this->getFilePath());
    }
    
    public function isDir() : bool
    {
        return is_dir($this->getFilePath());
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    public function isWritable() : bool
    {
        return is_writable($this->getFilePath());
    }
}