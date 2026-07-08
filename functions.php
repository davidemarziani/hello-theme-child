<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('HELLO_THEME_CHILD_VERSION', '1.0.0');

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


//-----------------------------------------------------------------------------------
// LIVE RELOAD CODE
//-----------------------------------------------------------------------------------
function htc_live_reload()
{
    // Percorso assoluto e URL del tema (child o principale)
    $theme_dir = get_stylesheet_directory();
    $theme_url = get_stylesheet_directory_uri();

    // Cerca TUTTI i file .css in modo ricorsivo
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme_dir));
    $css_files = [];
    foreach ($iterator as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'css') {
            $path = str_replace('\\', '/', $file->getPathname());
            $css_files[] = str_replace($theme_dir, $theme_url, $path);
        }
    }

?>
    <script>
        (function() {
            const cssFiles = <?php echo json_encode($css_files, JSON_UNESCAPED_SLASHES); ?>;
            const lastModifiedMap = {};

            async function checkCssUpdate() {
                for (const file of cssFiles) {
                    try {
                        const res = await fetch(file, {
                            method: "HEAD",
                            cache: "no-cache"
                        });
                        const newModified = res.headers.get("last-modified");
                        if (lastModifiedMap[file] && newModified !== lastModifiedMap[file]) {
                            console.log("Aggiornamento CSS rilevato:", file);
                            reloadCssFile(file);
                        }
                        lastModifiedMap[file] = newModified;
                    } catch (err) {
                        console.warn("Errore controllo CSS:", file, err);
                    }
                }
            }

            // Ricarica SOLO il CSS modificato
            function reloadCssFile(fileUrl) {
                const links = [...document.querySelectorAll('link[rel="stylesheet"]')];
                const match = links.find(l => l.href.includes(fileUrl.replace(/^https?:\/\/[^\/]+/, '')));
                if (match) {
                    const newLink = match.cloneNode();
                    newLink.href = fileUrl + '?v=' + Date.now(); // bust cache
                    newLink.onload = () => match.remove();
                    match.parentNode.insertBefore(newLink, match.nextSibling);
                    console.log("CSS ricaricato:", fileUrl);
                } else {
                    console.log("Nessun <link> trovato per:", fileUrl);
                }
            }

            setInterval(checkCssUpdate, 500);
        })();
    </script>
<?php
}
add_action('wp_footer', 'htc_live_reload', 99);

