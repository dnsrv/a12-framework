<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 08.12.18
 * Time: 0:32
 */

namespace A12\Interfaces\FilenameMarker;


use A12\Interfaces\FileSystem\FileWrapperInterface;

interface MarkingRuleInterface
{
    public function __invoke(FileWrapperInterface $file, string $mark);
}