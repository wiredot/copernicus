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

// load composer libraries
require __DIR__ . '/vendor/autoload.php';

define( 'CP_PATH', dirname( __FILE__ ) );
define( 'CP_URL', plugin_dir_url( __FILE__ ) );

use Copernicus\CP;

$CP = new CP();