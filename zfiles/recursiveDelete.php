<?php

function deleteItem($itemPath, $currentUserName)
{
    $ownerData = posix_getpwuid(fileowner($itemPath));
    
    if ($ownerData['name'] != $currentUserName) {
        alert("Owner of the file [{$itemPath}] is [{$ownerData['name']}]");
        alert("Need to change owner to [{$currentUserName}]");
        exec("sudo chown -R {$currentUserName}:{$currentUserName} " .
            str_replace(' ', "\ ", $itemPath));
    }
    
    if (!is_dir($itemPath)) {
        unlink($itemPath);
        return null;
    }
    
    $objects = scandir($itemPath);
    
    foreach ($objects as $object) {
        
        if ($object != "." && $object != "..") {
            
            $filePath = $itemPath . DIRECTORY_SEPARATOR . $object;
            
            if (filetype($filePath) == "dir") {
                deleteItem($filePath, $currentUserName);
            } else {
                unlink($filePath);
            }
        }
    }
    
    reset($objects);
    return rmdir($itemPath);
}