<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 08.12.18
 * Time: 0:16
 */

namespace A12\Modules\FileMarker\Rules;


use A12\Interfaces\FilenameMarker\MarkingRuleInterface;
use A12\Interfaces\FileSystem\FileWrapperInterface;
use A12\Modules\FileMarker\FilenameTagger;

class WithoutDotRule implements MarkingRuleInterface
{
    public function __invoke(FileWrapperInterface $file, string $mark)
    {
        $fileName = $file->getFilename();
    
        # if fileName does NOT has DOT
        if (strpos($fileName, '.') === false) {
            return $fileName .
                "-" .
                FilenameTagger::TAG_START_STR .
                FilenameTagger::TAG_DELIMITER_STR .
                $mark .
                FilenameTagger::TAG_END_STR;
        }
        
        return false;
    }
}