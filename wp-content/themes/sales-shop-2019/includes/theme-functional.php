<?php
/**
 * Return url to theme asset file.
 * $file_path - path to file in asset folder
 */
function ss_asset($file_path){
    return get_template_directory_uri().'/assets/'.$file_path;
}

/**
 * Function for autoloading script files, whitout order
 * $folders - folders for scan 
 */
function ss_autoload_scripts(array $folders){
    $except = array('.', '..');

    foreach ($folders as $one) {
        $files = scandir($one);
        foreach ($files as $item) {
            if (!in_array($item, $except)) {
                require_once($one . '/' . $item);
            }
        }
    }
}