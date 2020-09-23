<?php
/*
Plugin Name: Footer Details
Plugin URI: http://www.youcode.ma
Description: Afficher differents informations sur le footer
Version: 1.0.0
Author: Hanane Elkaaba - Mohamed Kainouch
Author URI: http://www.youcode.ma
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

add_action('admin_menu', 'my_admin_menu');

function my_admin_menu()
{
  add_menu_page('Footer Text title', 'Footer Details', 'manage_options', 'footer_setting_page', 'mt_settings_page', 'dashicons-palmtree');
}
// 
function mt_settings_page()
{
  echo "<h2> Footer Details Settings </h2>";
}

// Load Widget Class
require_once(plugin_dir_path(__FILE__) . '/footer-details-class.php');

// Register Widget
function register_footer_details()
{
  register_widget('Footer_Details');
}

// Hook in function
add_action('widgets_init', 'register_footer_details');
