<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * HTC - Live reload
 * Polls all theme CSS files during development and hot-swaps them in the
 * page when a change is detected, without a full reload.
 * Only runs when WP_DEBUG is enabled.
 */
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
if (defined('WP_DEBUG') && WP_DEBUG) {
    add_action('wp_footer', 'htc_live_reload', 99);
}
