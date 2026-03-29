<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * NavWalker
 */
add_filter('wp_nav_menu_args', function ($args) {
    $args['walker'] = new View\Components\NavigationWalker();

    return $args;
});
