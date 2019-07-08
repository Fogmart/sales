<?php
/**
 * Return url to theme asset file.
 * $file_path - path to file in asset folder
 */
function ss_asset($file_path){
    return get_template_directory_uri().'/assets/'.$file_path;
}

