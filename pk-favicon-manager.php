<?php
/*
Plugin Name: Pk Favicon Manager
Plugin URI: https://pkplugins.com/
Description: Pk Favicon Manager is a WordPress plugin to add a favicon to your WordPress website. Favicon is a small image or logo displayed in the address bar of a web browser. By using this plugin, you can easily upload and display favicon icon on your website built in WordPress.
Author: Pradnyankur Nikam
Author URI: https://pkplugins.com/
Version: 2.1
License: GPLv2
*/

// Restrict direct access to the file
if(!defined('ABSPATH')){ exit; }

##################################################

// On plugin activation, set default plugin
function pk_fmanager_on_activation() {
  if(!current_user_can('activate_plugins')){ return; }
$favurl1 = plugin_dir_url( __FILE__ ).'images/pkfm_favicon1.png';
$favurl2 = plugin_dir_url( __FILE__ ).'images/pkfm_favicon2.png';
  update_option(
  'pk_fmanager_options', 
	array(
	'pk_fm_version' => '2.0', 'pk_fm_version_type' => 'free',
	'pk_fav_status' => '1', 'pk_active_favicon' => 'default',
	'pk_fav_url1' => $favurl1, 'pk_fav_url2' => $favurl2
	)
  );
}
register_activation_hook( __FILE__, 'pk_fmanager_on_activation' );

// On plugin deactivation
function pk_fmanager_on_deactivation(){
  if(!current_user_can('activate_plugins')){ return; }
  // if required, remove custom options on deactivation on the plugin
}
register_deactivation_hook(__FILE__, 'pk_fmanager_on_deactivation');

// Enable auto update for this plugin
function pk_fmanager_auto_updates( $value, $item ) {
  if ( 'phpsword-favicon-manager' === $item->slug ) {
	return true; // Enable auto-updates for this plugin
  }
  return $value; // keep default for other plugins
}
add_filter( 'auto_update_plugin', 'pk_fmanager_auto_updates', 10, 2 );

##################################################

function pkfm_register_css_js(){
  // register CSS
  wp_register_style('pkfm-css', plugin_dir_url( __FILE__ ) . 'css/pkfm.css' ); 
  // register JS
  wp_register_script('pkfm-js', plugin_dir_url( __FILE__ ) . 'js/pkfm.js', array('jquery') );
}
add_action('init', 'pkfm_register_css_js');

// Load custom CSS & JS files
function pkfm_load_css_js() {
  wp_enqueue_style('pkfm-css');
  wp_enqueue_script('pkfm-js');
}
// Load css & js only for admin panel
add_action('admin_enqueue_scripts', 'pkfm_load_css_js');

##################################################

// Include class file	
require_once plugin_dir_path(__FILE__).'includes/class-pk-favicon-manager.php';

// If admin area
if(is_admin()){
  // Include admin menu	
  require_once plugin_dir_path(__FILE__).'admin/admin-menu.php';
}

##################################################

?>