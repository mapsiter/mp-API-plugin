<?php
/*
Plugin Name:    MP BE Test
Description:    Test plugin for MemberPress BE challange.
Version:        1.0.0
Author:         Mark Bozó
License:        MIT
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

// Define plugin constants
define('MP_BE_TEST_VERSION', '1.0.0');
define('MP_BE_TEST_DIR', plugin_dir_path(__FILE__));

// Includes
require_once(MP_BE_TEST_DIR . 'includes/api-endpoint.php');
require_once(MP_BE_TEST_DIR . 'includes/shortcode.php');
require_once(MP_BE_TEST_DIR . 'includes/wp-cli.php');

// Admin
if (is_admin()) {
  require_once(MP_BE_TEST_DIR . 'admin/admin-hero.php');
  require_once(MP_BE_TEST_DIR . 'admin/admin-table.php');
  require_once(MP_BE_TEST_DIR . 'admin/admin-search.php');
}



/**
 * Enqueue plugin styles and scripts.
 */

// Frontend
function mp_be_test_enqueue_assets() {
  wp_enqueue_style('mp-be-test-style', plugins_url('assets/css/style.css', __FILE__));
}
// add_action('wp_enqueue_scripts', 'mp_be_test_enqueue_assets');

// Admin
function mp_be_test_enqueue_admin_assets() {
  $screen = get_current_screen();
  if ($screen->id === 'edit-mp_be_test') {
    wp_enqueue_style('mp_be_test_admin_page_style', plugins_url('assets/css/admin-style.css', __FILE__));
    wp_enqueue_script('mp_be_test_api_call', plugins_url('assets/js/admin-search.js', __FILE__), array(), MP_BE_TEST_VERSION, true);
  }
}
add_action('admin_enqueue_scripts', 'mp_be_test_enqueue_admin_assets');
?>
