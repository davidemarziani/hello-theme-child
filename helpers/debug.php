<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * htc_print_r function
 */
function htc_print_r($print)
{
    echo '<pre>';
    print_r($print);
    echo '</pre>';
}

/**
 * Log personalizzato 
 *
 * @param mixed  $data  Variabile o stringa da loggare
 * @param string $label Etichetta opzionale
 */
function htc_log($data, $label = '')
{
    $log_file = get_stylesheet_directory() . '/htc.log'; // path del log nel child theme
    $time = date('Y-m-d H:i:s');

    // Prepara il messaggio
    $log_message = "[$time]";
    if ($label) {
        $log_message .= " [$label]";
    }

    // Converti array o oggetti in stringa leggibile
    if (is_array($data) || is_object($data)) {
        $log_message .= " " . print_r($data, true);
    } else {
        $log_message .= " " . $data;
    }

    // Scrive il log, aggiungendo una nuova riga
    file_put_contents($log_file, $log_message . PHP_EOL, FILE_APPEND | LOCK_EX);
}
