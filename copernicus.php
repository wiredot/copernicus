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

// main class file path
$copernicus_class_filename = plugin_dir_path(__FILE__) . 'library/copernicus/class-copernicus.php';

if ( file_exists( $copernicus_class_filename ) ) {

	// load composer libraries
	require_once plugin_dir_path(__FILE__).'library/vendor/autoload.php';

	// load & initialize framework
	require_once $copernicus_class_filename;

	$CP = new CP(__FILE__);

} else {
	echo 'error loading plugin';
}
