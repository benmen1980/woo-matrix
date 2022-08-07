<?php
/**
 * Plugin Name:       Roys Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Roy
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       roys-plugin
 * Domain Path:       /languages
 */
// constants
define('PLUGIN_URL'           , plugin_dir_url(__FILE__));
define('PLUGIN_PATH'           , plugin_dir_path(__FILE__));
// includes
add_action( 'init',function(){
	include( PLUGIN_PATH . 'includes/add-to-cart-ajax.php');
});
// scripts
add_action( 'wp_enqueue_scripts', 'simply_enqueue' );
function simply_enqueue($hook) {
	wp_enqueue_script( 'ajax-script', PLUGIN_URL. 'js/add-to-cart.js', array('jquery') );
	// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	wp_localize_script( 'ajax-script', 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ),
		       'simplyNonce' => wp_create_nonce( 'simply-nonce' ),
		       'we_value' => 1234 ) );
}
