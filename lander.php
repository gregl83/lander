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



function is_lander($lander = '') {
    if (empty($lander)) return false;

    return true;
}

function get_lander_template() {
    if ($template = get_query_template('lander', array('lander.php'))) return $template;
//Sprint WP_PLUGIN_DIR . '/wp-lander/index.php';
    return WP_PLUGIN_DIR . '/wp-lander/index.php';  // todo verify template
}


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
    //$template = get_query_template('lander', array($lander . '.php'));

    if (is_lander($lander) && $template = get_lander_template()) ;
    else $template = $original_template;

    return $template;
//    if (!empty($template)) return $template;
//
//    if (empty($lander)) return $original_template;
//
//    global $wp_query;
//    $wp_query->is_404 = true;
//    return get_404_template();
}
//add_filter('template_include', 'lander_template');


// todo build out plugin bootstrap and includes

function lander_page_show_edit_options($page, $metabox) {
    //global $post;
    //$exclude_ads = get_post_meta($post->ID,
    //    GooglePublisherPluginUtils::EXCLUDE_ADS_METADATA, true);
    //wp_nonce_field(self::METABOX_ACTION, 'gppMetaboxNonce');

    //if ($exclude_ads) {
    //    $exclude_checked = ' checked';
    //} else {
    //   $exclude_checked = '';
    //}
    echo '<input type="checkbox" name="blah" id="blah" value="yes"/> blah';
}
function lander_page_add_edit_options() {
    add_meta_box('lander_page_edit_options', 'Lander Plugin', 'lander_page_show_edit_options', 'page', 'side', 'low');
}
add_action('add_meta_boxes', 'lander_page_add_edit_options');


// add_action('save_post', array($this, 'savePageEditOptions'));

/*
 *
  public function addPageEditOptions() {
    add_meta_box('googlePublisherPluginMetaBox',
        __('AdSense Plugin', 'google-publisher-plugin'),
        array($this, 'showPageEditOptions'), 'page', 'side', 'low');
  }

  public function showPageEditOptions() {
    global $post;
    $exclude_ads = get_post_meta($post->ID,
        GooglePublisherPluginUtils::EXCLUDE_ADS_METADATA, true);
    wp_nonce_field(self::METABOX_ACTION, 'gppMetaboxNonce');

    if ($exclude_ads) {
      $exclude_checked = ' checked';
    } else {
      $exclude_checked = '';
    }
    echo '<input type="checkbox" name="gppDisableAds"',
        ' id="google-publisher-plugin-disable-ads" value="yes"',
        $exclude_checked, '/>',
        __('Disable ads on this page', 'google-publisher-plugin');
  }

  public function savePageEditOptions($post_id) {
    // If googlePublisherPluginMetabox has not been inserted then the nonce will
    // not have been set and the function should return.
    if (!isset($_POST['gppMetaboxNonce']) ||
        !wp_verify_nonce($_POST['gppMetaboxNonce'], self::METABOX_ACTION)) {
      return;
    } else if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    } else if (!current_user_can('edit_page', $post_id)) {
      return;
    } else if (isset($_POST['gppDisableAds']) &&
        $_POST['gppDisableAds'] == 'yes') {
      update_post_meta($post_id,
          GooglePublisherPluginUtils::EXCLUDE_ADS_METADATA, true);
    } else {
      delete_post_meta($post_id,
          GooglePublisherPluginUtils::EXCLUDE_ADS_METADATA);
    }
  }

 *
 */