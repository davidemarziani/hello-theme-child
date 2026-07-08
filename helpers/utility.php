<?php

if (!defined('ABSPATH')) {
    exit;
}

/****************************************
 * Aggiunge il supporto per i file SVG nell'upload di WordPress
 */

function htc_add_svg_support($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'htc_add_svg_support');




