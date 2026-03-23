<?php
/**
 * Plugin Name: Fix Packlink Loading Error
 * Description: Supprime l'erreur de chargement de traduction pour packlink-pro-shipping
 */

// Capture et silencie l'erreur doing_it_wrong pour packlink
add_filter('doing_it_wrong_trigger_error', function($trigger, $function, $message, $version) {
    if (is_string($message) && strpos($message, 'packlink-pro-shipping') !== false) {
        return false; // Ne pas déclencher l'erreur pour packlink
    }
    return $trigger;
}, 10, 4);
