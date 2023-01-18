<?php
private function getFilesInDirectory($path)
    {
        $exclude = [
            'folders' => ['.cache'],
            'files' => ['.htaccess','index.php']
        ];
        $filter = function($file, $key, $iterator) use ($exclude)
        {
            if($iterator->hasChildren() && !in_array($file->getFilename(), $exclude['folders'])) {
                return true;
            }
            elseif($file->isFile() && !in_array($file->getFilename(), $exclude['files'])) {
                return true;
            }
            return false;
        };
        $rii = new \RecursiveIteratorIterator(
            new \RecursiveCallbackFilterIterator(
                new \RecursiveDirectoryIterator(
                    $path,
                    \RecursiveDirectoryIterator::SKIP_DOTS |
                    \RecursiveDirectoryIterator::UNIX_PATHS |
                    \RecursiveDirectoryIterator::FOLLOW_SYMLINKS
                ),
                $filter
            )
        );
        $files = []; 
        foreach($rii as $file)
        {       
            $files[] = $file->getPathname(); 
        }
        return $files;
    }