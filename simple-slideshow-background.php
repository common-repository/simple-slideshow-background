<?php
/**
 * @package simple-slideshow-background
 * @version 0.2
 */
/*
Plugin Name: Simple Slideshow Background
Plugin URI: http://think-bowl.com/wordpress/plugins/slideshow-background/
Description: Add a full screen slideshow background which transitions through photos from you Wordpress media library.
Author: Eric Bartel
Version: 0.2
Author URI: http://think-bowl.com/
*/

// Globals
$ssbg_option_name = 'simple-slideshow_background_images';
$ssbg_settings_name = 'simple-slideshow_settings';

$ssbg_settings = get_option($ssbg_settings_name);
if(!$ssbg_settings){
  // If settings are not yet set, create them based on defaults
  $ssbg_settings['delay'] = 5;
  $ssbg_settings['enabled'] = true;
  update_option($ssbg_settings_name, $ssbg_settings);
}

include_once 'admin-form.php';
include_once 'admin-menu.php';
include_once 'admin-table.php';
include_once 'display-background.php';

// Script enqueues
function ssbg_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
}

function ssbg_admin_styles() {
wp_enqueue_style('thickbox');
wp_register_style('ssbg-style', WP_PLUGIN_URL.'/simple-slideshow-background/simple-slideshow-background-admin.css');
wp_enqueue_style('ssbg-style');
}

if (isset($_GET['page']) && $_GET['page'] == 'simple-slideshow-background') {
  add_action('admin_print_scripts', 'ssbg_admin_scripts');
  add_action('admin_print_styles', 'ssbg_admin_styles');
}

function ssbg_styles_scripts() {
wp_register_style('ssbg-style', WP_PLUGIN_URL.'/simple-slideshow-background/simple-slideshow-background.css');
wp_enqueue_style('ssbg-style');
wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'ssbg_styles_scripts');
?>