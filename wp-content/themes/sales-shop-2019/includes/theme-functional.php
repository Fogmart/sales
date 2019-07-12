<?php

/**
 * Return url to theme asset file.
 * $file_path - path to file in asset folder
 */
function ss_asset($file_path)
{
    return get_template_directory_uri() . '/assets/' . $file_path;
}

/**
 * Function for autoloading script files, whitout order
 * $folders - folders for scan 
 */
function ss_autoload_scripts(array $folders)
{
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

/**
 * Function for redirecting back to previous page
 */
function ss_return_back()
{
    $backpath = $_SERVER['HTTP_REFERER'];
    wp_safe_redirect($backpath);
    exit;
}

/**
 * Function for redirecting to home
 */
function ss_return_home(){
    $path = site_url();
    wp_safe_redirect($path);
    exit;
}
