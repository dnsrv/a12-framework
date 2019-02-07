<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 05.12.18
 * Time: 1:51
 */

namespace A12\Modules\FileMarker;


use A12\Exceptions\ModuleException;
use A12\Interfaces\FilenameMarker\MarkingRuleInterface;
use A12\Interfaces\FileSystem\FileWrapperInterface;
use A12\Modules\FileSystem\FileWrapper;

class FilenameTagger
{
    public const TAG_START_REGEXP = '\(T';
    public const TAG_END_REGEXP = '\)';
    public const TAG_DELIMITER_REGEXP = '\-';
    
    public const TAG_START_STR = '(T';
    public const TAG_END_STR = ')';
    public const TAG_DELIMITER_STR = '-';
    
    private $originalFile;
    private $rulesQueue;
    
    /**
     * FilenameMarker constructor.
     * @param FileWrapperInterface $originalFile
     * @throws ModuleException
     */
    public function __construct(FileWrapperInterface $originalFile)
    {
        $this->originalFile = $originalFile;
        
        if (!$this->originalFile->isFileExists()) {
            throw new ModuleException(
                "File [{$this->originalFile->getFilePath()}] not found"
            );
        }
        
        $this->rulesQueue = new \SplQueue();
    }
    
    /**
     * @param MarkingRuleInterface[]|MarkingRuleInterface
     * @return $this
     */
    public function addRule($rule)
    {
        if (is_array($rule)) {
            foreach ($rule as $r) {
                $this->rulesQueue->enqueue($r);
            }
        } else {
            $this->rulesQueue->enqueue($rule);
        }
        
        return $this;
    }
    
    /**
     * @param string $mark
     * @return bool|FileWrapper
     * @throws ModuleException
     */
    public function getModifiedFileHandler(string $mark)
    {
        $newFilename = $this->process($this->originalFile, $mark);
        
        if ($newFilename === false) {
            return false;
        }
        
        return new FileWrapper(
            $this->originalFile->getParentDir() . '/' . $newFilename
        );
    }
    
    // ------- ------- ------- ------- ------- ------- -------
    
    /**
     * @param FileWrapperInterface $originalFile
     * @param string $mark
     * @return bool
     * @throws ModuleException
     */
    private function process(FileWrapperInterface $originalFile, string $mark)
    {
        if ($this->rulesQueue->isEmpty()) {
            throw new ModuleException("Rules not found");
        }
    
        while (!$this->rulesQueue->isEmpty()) {
            
            /** @var MarkingRuleInterface $currentRule */
            $currentRule = $this->rulesQueue->dequeue();
            
            if (($resultString = $currentRule($originalFile, $mark)) !== false) {
                return $resultString;
            }
        }
    
        return false;
    }
}