<?php
    
    if (isset($_GET['file'])) {
        $file = "files/" . $_GET['file'];
        
        if(is_file($file)){
            //unlink($file);
            unlink(realpath($file));
        }
        else if(is_dir($file)){
            $dir = $file;
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
                RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }

        /*$path_parts = pathinfo($_GET['file']);
        if($path_parts['dirname'] != ''){
            header('Location: ../index.php?route=' . $path_parts['dirname'] . '/');
            exit;
        }*/
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;