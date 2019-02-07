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

class HasExtensionRule implements MarkingRuleInterface
{
    /** @var string */
    private $extension;
    
    public function __construct(string $extension)
    {
        $this->extension = $extension;
    }
    
    public function __invoke(FileWrapperInterface $file, string $mark)
    {
        $fileName = $file->getFilename();
    
        if (strpos($fileName, '.') === false) {
            return false;
        }
    
        // ------- ------- -------
    
        # if fileName has DOT
        $parts = explode('.', $fileName);
        
        $newFilename = array_shift($parts);
    
        if ($parts[0] === $this->extension) {
            // if fileName is .local domain
            $newFilename .= "." . array_shift($parts);
        }
    
        $newFilename .= "." . $mark;
    
        if (count($parts) > 0) {
            $newFilename .= "." . implode('.', $parts);
        }
    
        return $newFilename;
    }
}