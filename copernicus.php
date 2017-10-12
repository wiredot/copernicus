<?php
/*
  Plugin Name: Copernicus
  Plugin URI:  http://copernicus.wiredot.com/
  Description: WordPress Framework Plugin
  Author: wiredot
  Version: 2.0.0
  Author URI: http://wiredot.com/
  License: GPLv2 or later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// load composer libraries
require __DIR__ . '/vendor/autoload.php';

define( 'CP_PATH', dirname( __FILE__ ) );
define( 'CP_URL', plugin_dir_url( __FILE__ ) );
define( 'CP_BASENAME', dirname( plugin_basename( __FILE__ ) ) );

use Copernicus\CP;

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
	return CP::run();
}

cp();
