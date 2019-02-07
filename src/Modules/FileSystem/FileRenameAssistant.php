<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 1:54
 */

namespace A12\Modules\FileSystem;


use A12\Exceptions\ModuleException;
use A12\Interfaces\FileSystem\FileWrapperInterface;

class FileRenameAssistant
{
    private $originalFileHandler;
    private $modifiedFileHandler;
    
    public function __construct(FileWrapperInterface $originalFileHandler, FileWrapperInterface $modifiedFileHandler)
    {
        $this->originalFileHandler = $originalFileHandler;
        $this->modifiedFileHandler = $modifiedFileHandler;
    }
    
    /**
     * @param bool $test
     * @return bool
     * @throws ModuleException
     */
    public function process($test = false) : bool
    {
        if ($test === true) {
            echo "Test: Renaming [{$this->originalFileHandler->getFilePath()}] to [{$this->modifiedFileHandler->getFilename()}]" . PHP_EOL;
            return true;
        }
    
        
        if (!$this->originalFileHandler->isFileExists()) {
            throw new ModuleException("File [{$this->originalFileHandler->getFilePath()}] not found");
        }
        
    
        if (rename($this->originalFileHandler->getFilePath(), $this->modifiedFileHandler->getFilePath())) {
            return true;
        } else {
            return false;
        }
    }
}