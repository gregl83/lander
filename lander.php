<?php

/**
 * @package wp-lander
 * @version 0.1.0
 */

/*
Plugin Name: WordPress Lander
Plugin URI: https://github.com/gregl83/wp-lander
Description: Manage landing pages for WordPress sites
Version: 0.1.0
Author: Gregory Langlais
Author URI: https://github.com/gregl83
License: MIT
*/

if (!defined('ABSPATH')) {die();}


function lander_rewrite_tag() {
    add_rewrite_tag('%lander%', '([^&]+)');
}
add_action('init', 'lander_rewrite_tag', 10, 0);


function lander_rewrite() {
    add_rewrite_rule('^lander/(.*)', 'index.php?lander=$matches[1]', 'top');
    flush_rewrite_rules(false); // todo fixme
}
add_action('init', 'lander_rewrite');


function lander_template($original_template) {
    $lander = get_query_var('lander');
    $template = get_query_template('lander', array($lander . '.php'));

    if (!empty($template)) {
        return $template;
    } else {
        if (!empty($lander)) {
            global $wp_query;
            $wp_query->is_404 = true;
            return get_404_template();
        } else {
            return $original_template;
        }
    }
}
add_filter('template_include', 'lander_template');


// todo build out plugin bootstrap and includes