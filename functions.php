<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('HELLO_THEME_CHILD_VERSION', wp_get_theme(get_stylesheet())->get('Version'));

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function htc_scripts_styles()
{

    wp_enqueue_style(
        'htc-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        HELLO_THEME_CHILD_VERSION
    );
}
add_action('wp_enqueue_scripts', 'htc_scripts_styles', 20);

// ----------------------------------------------------------------------------------
// Loads and centralizes all frontend asset management (CSS/JS) for the child theme
// ----------------------------------------------------------------------------------
require_once get_stylesheet_directory() . '/includes/setup/enqueue-assets.php';

// ----------------------------------------------------------------------------------
// Includes and initializes supporting PHP files
// ----------------------------------------------------------------------------------
require_once get_stylesheet_directory() . '/includes/setup/include-php.php';

// ----------------------------------------------------------------------------------
// Loads all the custom components
// ----------------------------------------------------------------------------------
require_once get_stylesheet_directory() . '/includes/setup/components-loader.php';

// ----------------------------------------------------------------------------------
// Development tools (e.g. CSS live reload)
// ----------------------------------------------------------------------------------
require_once get_stylesheet_directory() . '/includes/setup/dev-tools.php';

