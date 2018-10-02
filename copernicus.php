<?php
/*
  Plugin Name: Copernicus
  Plugin URI:  https://wiredot.com/labs/copernicus
  Description: WordPress Theme and Plugin development framework
  Author: Wiredot Labs
  Version: 2.1.0
  Author URI: https://wiredot.com/labs
  License: GPLv3 or later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// load composer libraries
require __DIR__ . '/vendor/autoload.php';

use Wiredot\Copernicus\CP;

function activate_plugin_name() {
	//require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	//CP_Activator::activate();
}

function deactivate_plugin_name() {
	//require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	//CP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

function cp() {
	return CP::run( plugin_dir_path( __FILE__ ), plugin_dir_url( __FILE__ ) );
}

cp();
