<?php

/**
 * HTC - Components loader
 * This file is responsible for loading all the components of the theme.
 * Each component should be placed in the `components` folder and should have a PHP file with the same name as the component.
 * For example, if you have a component called `my-component`, you should create a folder called `my-component` 
 * inside the `components` folder and inside that folder you should create a file called `my-component.php` 
 * where you will write the code for that component.
 * Then, you need to add the name of the component to the `htc_register_components` function to load it.
 */
function htc_register_components()
{
    return [
        'marquee-text' => [
            'css_deps' => [],
            'js_deps'   => ['htc-gsap'],
            'in_footer' => true,
        ],
    ];
}

/**
 * HTC - Enqueue component styles and scripts
 * This function is responsible for enqueuing the styles and scripts of the components.
 */
function htc_enqueue_components_assets()
{
    $components = htc_register_components();

    foreach ($components as $component => $config) {

        $base_uri  = get_stylesheet_directory_uri() . "/components/{$component}/{$component}";
        $base_path = get_stylesheet_directory() . "/components/{$component}/{$component}";

        // CSS
        if (file_exists($base_path . '.css')) {
            wp_enqueue_style(
                "htc-{$component}",
                $base_uri . '.css',
                $config['css_deps'] ?? [],
                filemtime($base_path . '.css')
            );
        }

        // JS
        if (file_exists($base_path . '.js')) {
            wp_enqueue_script(
                "htc-{$component}",
                $base_uri . '.js',
                $config['js_deps'] ?? [],
                filemtime($base_path . '.js'),
                $config['in_footer'] ?? true
            );
        }
    }
}

add_action('wp_enqueue_scripts', 'htc_enqueue_components_assets', 99);

/**
 * HTC - Load components
 * This function is responsible for loading all the components registered in the `htc_register_components` function. 
 * It will loop through the registered components and include their respective PHP files.
 */
function htc_load_components()
{
    $components = htc_register_components();

    foreach ($components as $component => $config) {

        $file = get_stylesheet_directory() . "/components/{$component}/{$component}.php";

        if (file_exists($file)) {
            require_once $file;
        }
        // else {
        //     if (defined('WP_DEBUG') && WP_DEBUG) {
        //         trigger_error("Impossibile leggere il file `$file` per l'inclusione!", E_USER_WARNING);
        //     }
        // }
    }
}
add_action('after_setup_theme', 'htc_load_components');
