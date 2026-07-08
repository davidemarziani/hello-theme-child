<?php

if (!defined('ABSPATH')) {
    exit;
}

/****************************************
 * HTC - Adding custom Externals, css and js
 */
function htc_enqueue_additional_styles_scripts()
{
    $live_reload_active = true;
    $ver = $live_reload_active ? time() : null;

    $externals = [
        //[
        // 'handle' => 'kursor', // Unique handle for the external script
        // 'url'    => 'https://cdn.jsdelivr.net/npm/kursor@0.0.14/dist/kursor.js', // URL of the external script
        // 'deps'   => [], // Dependencies (if any)
        // 'in_footer' => false // Load script in footer (true) or header (false)
        //],
    ];

    // Enqueue external scripts
    foreach ($externals as $external) {
        $handle    = $external['handle'];
        $url       = $external['url'];
        $deps      = isset($external['deps']) ? $external['deps'] : [];
        $in_footer = isset($external['in_footer']) ? $external['in_footer'] : false;

        wp_enqueue_script($handle, $url, $deps, $ver, $in_footer);
    }

    $styles = [

        [
            'handle' => '00-main', // Unique handle for the style
            'path' => '/assets/css/00-main.css', // PATH of the style
            'deps' => [] // Dependencies (if any)
        ],
        [
            'handle' => '10-homepage',
            'path' => '/assets/css/10-homepage.css',
            'deps' => []
        ],
        // Add more styles here
    ];

    $scripts = [
        [
            'handle' => '00-main', // Unique handle for the script
            'path' => '/assets/js/00-main.js', // PATH of the script
            'deps' => [], // Dependencies (if any es. 'jquery')
            'in_footer' => true // Load script in footer (true) or header (false)
        ],
        // Add more scripts here
    ];

    foreach ($styles as $style) {
        $handle = 'htc-' . $style['handle'];
        $path = get_stylesheet_directory_uri() . $style['path'];
        $deps = isset($style['deps']) ? $style['deps'] : [];

        wp_enqueue_style($handle, $path, $deps, $ver);
    }

    foreach ($scripts as $script) {
        $handle = 'htc-' . $script['handle'];
        $path = get_stylesheet_directory_uri() . $script['path'];
        $deps = isset($script['deps']) ? $script['deps'] : [];
        $in_footer = isset($script['in_footer']) ? $script['in_footer'] : false;

        wp_enqueue_script($handle, $path, $deps, $ver, $in_footer);
    }
}
add_action('wp_enqueue_scripts', 'htc_enqueue_additional_styles_scripts', 99);

/****************************************
 * HTC - Enqueue GSAP and its plugins
 * Enqueues the GSAP library and its plugins.
 */
function htc_enqueue_gsap_scripts()
{
    // The core GSAP library
    wp_enqueue_script('htc-gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/gsap.min.js', array(), false, true);
    // ScrollTrigger - with gsap.js passed as a dependency
    wp_enqueue_script('htc-gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/ScrollTrigger.min.js', array('htc-gsap'), false, true);
}
add_action('wp_enqueue_scripts', 'htc_enqueue_gsap_scripts');
