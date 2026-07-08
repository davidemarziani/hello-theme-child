<?php

if (!defined('ABSPATH')) {
    exit;
}

/****************************************
 * HTC - Including php code
 */

$roots_includes = [
    '/helpers/debug.php',
    '/helpers/utility.php',
    '/includes/pages/10-homepage.php',
];

foreach ($roots_includes as $file) {
    $file_path = get_stylesheet_directory() . $file;

    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        trigger_error("Impossibile leggere il file `$file` per l'inclusione!", E_USER_ERROR);
    }
}

