<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 08.12.18
 * Time: 0:12
 */

namespace A12\Modules\FileMarker\Rules;


use A12\Interfaces\FilenameMarker\MarkingRuleInterface;
use A12\Interfaces\FileSystem\FileWrapperInterface;

class HasPatternRule implements MarkingRuleInterface
{
    /** @var string */
    private $pattern;
    
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }
    
    public function __invoke(FileWrapperInterface $file, string $mark)
    {
        $fileName = $file->getFilename();
        $pattern = '/' . trim($this->pattern, '/') . '/';
        
//        var_dump([
//            $fileName,
//            $pattern,
//            $mark,
//            preg_match($pattern, $fileName)
//        ]);
        
        
        if (preg_match($pattern, $fileName)) {
            return preg_replace($pattern, $mark, $fileName);
        }
    }
}