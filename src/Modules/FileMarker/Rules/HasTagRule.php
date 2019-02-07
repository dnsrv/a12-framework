<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 08.12.18
 * Time: 0:44
 */

namespace A12\Modules\FileMarker\Rules;


use A12\Interfaces\FilenameMarker\MarkingRuleInterface;
use A12\Interfaces\FileSystem\FileWrapperInterface;
use A12\Modules\FileMarker\FilenameTagger;

class HasTagRule implements MarkingRuleInterface
{
    /** @var string */
    private $pattern;
    
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }
    
    public function __invoke(FileWrapperInterface $file, string $mark)
    {
        $fileName = addslashes($file->getFilename());
        $mark = addslashes($mark);
        
        $tagPattern = '/(' .
            FilenameTagger::TAG_START_REGEXP .
            FilenameTagger::TAG_DELIMITER_REGEXP .
            '[^' . FilenameTagger::TAG_END_REGEXP . ']*' .
            FilenameTagger::TAG_END_REGEXP .
            ')/i';
        
        if (preg_match($tagPattern, $fileName, $matches)) {
            
            if (strpos($matches[1], $mark)) {
                return $fileName;
            }
            
            if (preg_match('/' . trim($this->pattern, '/') . '/i', $matches[1])) {
    
                $tag = preg_replace('/' . trim($this->pattern, '/') . '/i', $mark, $matches[1]);
                
            } else {
                $tag =
                    rtrim($matches[1], FilenameTagger::TAG_END_STR) .
                    FilenameTagger::TAG_DELIMITER_STR .
                    $mark .
                    FilenameTagger::TAG_END_STR;
            }
    
            // ------- ------- -------
    
            return preg_replace($tagPattern, $tag, $fileName);
        }
        
        return false;
    }
}